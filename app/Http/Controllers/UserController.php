<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Category;
use \App\Models\Product;
use \App\Models\User;
use Auth;

class UserController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('page.shop')->with('success', 'Login successful!'); 
        }
        return back()->with('error', 'Invalid credentials, please try again.');
    }

    static function getProductPriceForUser($product_id, $user_id = null)
    {
        $user = auth()->user();
        if($user_id){
            $user = User::findOrFail($user_id);
        }
        $product = Product::with('priceVariations.level', 'tieUpStore')->findOrFail($product_id);

        // Default price for guests
        if (!$user) {
            return optional($product->priceVariations->firstWhere('level_id', 1))->price;
        }

        // Determine the store ID and level for relational managers and business users
        if ($user->hasRole('relational-manager')) {
            $store = session('store');
            $store_id = $store->id ?? null;
            $level_id = $store->level->id ?? null;
        } elseif ($user->hasRole('business') or $user->hasRole('company')) {
            $store_id = $user->id;
            $level_id = $user->level->id;
        } elseif ($user->hasRole('complete-franchise') or $user->hasRole('partial-franchise')) {
            $store_id = $user->parentCompany->id;
            $level_id = $user->parentCompany->level->id;
        } else {
            return optional($product->priceVariations->firstWhere('level_id', 1))->price;
        }

        // Check for tie-up store pricing
        $tieUpStorePrice = optional($product->tieUpStore->firstWhere('store_id', $store_id))->price;
        if ($tieUpStorePrice !== null) {
            return $tieUpStorePrice;
        }

        // Return price variation based on user/store level
        return optional($product->priceVariations->firstWhere('level_id', $level_id))->price;
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logs out the user

        // Invalidate and regenerate session to prevent session fixation
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'You have been logged out successfully.');
    }
}
