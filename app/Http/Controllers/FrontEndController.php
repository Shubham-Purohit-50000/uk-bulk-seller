<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Category;
use \App\Models\Product;
use \App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Attendence;
use App\Events\RMLocationUpdated;
use App\Models\GeoTracking;
use App\Models\CartItem;
use App\Models\Level;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\BargainedPrice;
use Log;

class FrontEndController extends Controller
{
    public static function renderCategoriesSide($categories, $parentId)
    {
        $html = '<ul class="facet-body">';
        foreach ($categories as $category) {
            $collapseId = 'collapse-' . $category->id; // Unique ID for collapse
            $html .= '<li>';
            
            // Category Item
            $html .= '<div role="dialog" class="facet-title collapsed" data-bs-toggle="collapse" data-bs-target="#' . $collapseId . '" aria-expanded="false" aria-controls="' . $collapseId . '">
                        <img class="avt" src="' . ($category->image ? asset("storage/" . $category->image) : asset("frontend/images/avatar/default.jpg")) . '" alt="avt">
                        <span class="title">' . $category->name . '</span>';
                        if ($category->subcategories->isNotEmpty()) {
                            $html .= '<span class="icon icon-arrow-down"></span>';
                        }
            $html .= '</div>';
            
            // Subcategories (if any)
            if ($category->subcategories->isNotEmpty()) {
                $html .= '<div id="' . $collapseId . '" class="collapse" data-bs-parent="#' . $parentId . '">';
                $html .= self::renderCategoriesSide($category->subcategories, $collapseId);
                $html .= '</div>';
            }
            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    public static function renderCategoriesHome_old($categories, $parentId)
    {
        $html = '<ul class="facet-body">';
        foreach ($categories as $category) {
            $collapseId = 'collapse-' . $category->id; // Unique ID for collapse
            $html .= '<li>';
            
            // Category Item
            $html .= '<div role="dialog" class="facet-title collapsed sub-row row" data-bs-toggle="collapse" data-bs-target="#' . $collapseId . '" aria-expanded="false" aria-controls="' . $collapseId . '">
                        <div class="col-10">
                            <img class="avt" src="' . ($category->image ? asset("storage/" . $category->image) : asset("frontend/images/avatar/default.jpg")) . '" alt="avt">
                            <span class="title" style="margin-left: 10px;">' . $category->name . '</span>
                        </div>
                        <div class="col-2" style="text-align: end;">';
                        if ($category->subcategories->isNotEmpty()) {
                            $html .= '<span class="icon icon-arrow-down"></span>';
                        }
                        
            $html .= '</div></div>';

            // Check if category has products
            if ($category->products->isNotEmpty() || $category->subcategories->pluck('products')->flatten()->isNotEmpty()) {
                $html .= '<div class="row">'; // Start row container
                foreach ($category->products as $product) {
                    $price = \App\Http\Controllers\UserController::getProductPriceForUser($product->id);
                    $defaultImage = isset($product->image[0]) ? asset('storage/' . $product->image[0]) : asset('frontend/images/placeholder.jpg');
                    
                    // Product Card inside .col-6 .col-md-3
                    $html .= '<div class="col-6 col-md-3 col-lg-2">';
                    $html .= '<div class="card-product grid">
                                <div class="card-product-wrapper">
                                    <a href="' . url('product-detail/' . $product->slug) . '" class="product-img">
                                        <img class="lazyload img-product" data-src="' . $defaultImage . '" src="' . $defaultImage . '" alt="image-product">
                                    </a>
                                    <div class="list-product-btn">
                                        <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Wishlist</span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                                            <span class="icon icon-gitDiff"></span>
                                            <span class="tooltip">Compare</span>
                                        </a>
                                        <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                                            <span class="icon icon-eye"></span>
                                            <span class="tooltip">Quick View</span>
                                        </a>
                                    </div>';
                    
                    if (auth()->check()) {
                        $html .= '<div class="list-btn-main">
                                    <a href="#shoppingCart" data-url="' . url('add-cart', $product->id) . '" data-bs-toggle="modal" class="btn-main-product add-cart">Add To Cart</a>
                                </div>';
                    }
                    
                    $html .= '</div>
                            <div class="card-product-info">
                                <a href="' . url('product-detail/' . $product->slug) . '" class="title link">' . $product->name . '</a>
                                <span class="price current-price">$' . $price . '</span>
                            </div>
                        </div>'; // Close product card
                    
                    $html .= '</div>'; // Close .col-6 .col-md-3
                }
                $html .= '</div>'; // Close .row container
            }

            // Subcategories (if any)
            if ($category->subcategories->isNotEmpty()) {
                $html .= '<div id="' . $collapseId . '" class="collapse" data-bs-parent="#' . $parentId . '">';
                $html .= self::renderCategoriesHome($category->subcategories, $collapseId);
                $html .= '</div>';
            }
            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }

    public static function renderCategoriesHome($categories, $parentId)
    {
        $html = '<ul class="facet-body">';
        foreach ($categories as $category) {
            $collapseId = 'collapse-' . $category->id; // Unique ID for collapse
            $hasProducts = $category->products->isNotEmpty() || $category->subcategories->pluck('products')->flatten()->isNotEmpty();
            $hasSubcategories = $category->subcategories->isNotEmpty();

            $html .= '<li>';
            
            // Category Item
            $html .= '<div role="dialog" class="facet-title collapsed sub-row row" ' 
                . ($hasProducts || $hasSubcategories ? 'data-bs-toggle="collapse" data-bs-target="#' . $collapseId . '" aria-expanded="false" aria-controls="' . $collapseId . '"' : '') . '>
                        <div class="col-10">
                            <img class="avt" src="' . ($category->image ? asset("storage/" . $category->image) : asset("frontend/images/avatar/default.jpg")) . '" alt="avt">
                            <span class="title" style="margin-left: 10px;">' . $category->name . '</span>
                        </div>
                        <div class="col-2" style="text-align: end;">';
                            if ($hasProducts || $hasSubcategories) {
                                $html .= '<span class="icon icon-arrow-down"></span>'; // Show dropdown arrow if collapsible
                            }
            $html .= '</div></div>';

            // Collapsible container for products and subcategories
            if ($hasProducts || $hasSubcategories) {
                $html .= '<div id="' . $collapseId . '" class="collapse" data-bs-parent="#' . $parentId . '">';

                // Products (if any)
                if ($category->products->isNotEmpty()) {
                    $html .= '<div class="row">'; // Start row container
                    foreach ($category->products as $product) {
                        $price = \App\Http\Controllers\UserController::getProductPriceForUser($product->id);
                        $defaultImage = isset($product->image[0]) ? asset('storage/' . $product->image[0]) : asset('frontend/images/placeholder.jpg');
                        
                        // Product Card inside .col-6 .col-md-3
                        $html .= '<div class="col-6 col-md-3 col-lg-2">';
                        $html .= '<div class="card-product grid">
                                    <div class="card-product-wrapper">
                                        <a href="' . url('product-detail/' . $product->slug) . '" class="product-img">
                                            <img class="lazyload img-product" data-src="' . $defaultImage . '" src="' . $defaultImage . '" alt="image-product">
                                        </a>
                                        <div class="list-product-btn">
                                            <a href="javascript:void(0);" class="box-icon wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Wishlist</span>
                                            </a>
                                            <a href="#compare" data-bs-toggle="offcanvas" aria-controls="compare" class="box-icon compare btn-icon-action">
                                                <span class="icon icon-gitDiff"></span>
                                                <span class="tooltip">Compare</span>
                                            </a>
                                            <a href="#quickView" data-bs-toggle="modal" class="box-icon quickview tf-btn-loading">
                                                <span class="icon icon-eye"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </div>';
                        
                        if (auth()->check()) {
                            $html .= '<div class="list-btn-main">
                                        <a href="#shoppingCart" data-url="' . url('add-cart', $product->id) . '" data-bs-toggle="modal" class="btn-main-product add-cart">Add To Cart</a>
                                    </div>';
                        }
                        
                        $html .= '</div>
                                <div class="card-product-info">
                                    <a href="' . url('product-detail/' . $product->slug) . '" class="title link">' . $product->name . '</a>
                                    <span class="price current-price">$' . $price . '</span>
                                </div>
                            </div>'; // Close product card
                        
                        $html .= '</div>'; // Close .col-6 .col-md-3
                    }
                    $html .= '</div>'; // Close .row container
                }

                // Subcategories (if any)
                if ($hasSubcategories) {
                    $html .= self::renderCategoriesHome($category->subcategories, $collapseId);
                }

                $html .= '</div>'; // Close collapsible container
            }

            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }


    public function home(){
        $categories = Category::all();
        return view('page.home')->with(['categories' => $categories]);
    }

    public function shub_index()
    {
        // Fetch only parent categories (where parent_id is null) and load subcategories recursively
        $categories = Category::whereNull('parent_id')->with('subcategoriesRecursive')->get();
        return response()->json($categories);
    }

    public function shub_getProducts($subcategoryId)
    {
        $products = Product::where('category_id', $subcategoryId)->get();
        // return response()->json($products);
        // Return the rendered view with products
        return view('components.shub-product-list', compact('products'));
    }

    public function home_new(){
        $categories = Category::all();
        return view('page.home-new')->with(['categories' => $categories]);
    }


    public function shop_old($categorySlug = null) {
        $user = auth()->user();
    
        // Ensure RM has selected a store
        if ($user->hasRole('relational-manager') && !session()->has('store')) {
            return back()->with('error', 'Please Select Store!');
        }
    
        // Fetch all categories in one query
        $categories = Category::all();
        $products = collect(); // Default empty collection
    
        // Fetch products based on user role
        if ($user->hasRole('company') || $user->hasAnyRole(['complete-franchise', 'partial-franchise'])) {
            $companyUser = $user->hasAnyRole(['complete-franchise', 'partial-franchise']) ? $user->parentCompany : $user;
    
            // Get the actual Product models from tie-up products
            $products = $companyUser->tieUpProducts()->with('product')->get()->pluck('product');
        } else {
            $products = Product::when($categorySlug, function ($query) use ($categorySlug) {
                return $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
            })->with('category')->get();
        }
    
        return view('page.shop', compact('categories', 'products'));
    }        

    public function shop($categorySlug = null) {
        $user = auth()->user();
    
        // Ensure RM has selected a store
        if ($user->hasRole('relational-manager') && !session()->has('store')) {
            return back()->with('error', 'Please Select Store!');
        }
    
        // Fetch all categories
        $categories = Category::all();
        $products = collect(); // Default empty collection
    
        // Fetch products based on user role
        if ($user->hasRole('company') || $user->hasAnyRole(['complete-franchise', 'partial-franchise'])) {
            $companyUser = $user->hasAnyRole(['complete-franchise', 'partial-franchise']) ? $user->parentCompany : $user;
    
            // Get Product models from tie-up products
            $products = $companyUser->tieUpProducts()->with(['product', 'product.productVariationOptions.option'])->get()->pluck('product');
        } else {
            $products = Product::when($categorySlug, function ($query) use ($categorySlug) {
                return $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
            })->with(['category', 'productVariationOptions.option'])->get();
        }
    
        // Extract Filters
        $colors = [];
        $brands = [];
        $prices = [];
    
        foreach ($products as $product) {
            foreach ($product->productVariationOptions as $variation) {
                $option = $variation->option;
    
                // Collect color codes
                if (!empty($option->color_code)) {
                    $colors[$option->color_code] = $option->value;
                }
    
                // Collect brands (assuming "Brand" is a Variation Attribute)
                if ($variation->attribute->name === 'Brand') {
                    $brands[$option->id] = $option->value;
                }
            }
    
            // **Get price based on user role**
            $price = \App\Http\Controllers\UserController::getProductPriceForUser($product->id);
            if ($price !== null) {
                $prices[] = $price;
            }
        }
    
        // Remove duplicates
        $brands = array_unique($brands);
        $prices = array_unique($prices);
        sort($prices); // Sort prices for UI display
    
        return view('page.shop', compact('categories', 'products', 'colors', 'brands', 'prices'));
    }
    


    public function myAccount(){
        return view('account.my-account');
    }

    public function myOrders()
    {
        $user = auth()->user();

        // Ensure relational-manager has a selected store
        if ($user?->hasRole('relational-manager') && !session()->has('store')) {
            return back()->with('error', 'Please Select a Store!');
        }

        // Assign store if user is a relational-manager
        $user = $user->hasRole('relational-manager') ? session('store') : $user;

        // Eager load necessary relationships to prevent N+1 queries
        $orders = $user->orders()->with('orderItems.product')->latest()->get();

        return view('account.my-orders', compact('orders'));
    }

    public function product($product_slug)
    {
        // Ensure RM has selected a store
        $user = auth()->user();
        if ($user && $user->hasRole('relational-manager') && !session()->has('store')) {
            return back()->with('error', 'Please Select Store!');
        }

        $product = Product::where('slug', $product_slug)->firstOrFail();
        $breadcrumb = $this->breadcrumb($product->category);
        return view('page.product', compact('product', 'breadcrumb'));
    }

    public function breadcrumb($category)
    {
        $breadcrumb = [];
        
        while ($category) {
            $breadcrumb[] = [
                'name' => $category->name,
                'slug' => $category->slug // Assuming slug is used for URLs
            ];
            $category = $category->category; // Assuming there's a relationship "parent" in Category model
        }
        
        return array_reverse($breadcrumb); // Reverse to get from parent to child order
    }

    public function checkout_old(Request $request, $p_slug = null){
        $product = Product::where('slug', $p_slug)->first();
        if($request->client_id){
            $request->session()->put('client_id', $request->client_id);
            $client = User::find($request->client_id);
            return optional($product->priceVariations->where('level_id', $client->level->id)->first())->price;
        }
        return view('page.checkout');

        // if (session()->has('user_id')) {
        //     $user_id = session('user_id');
        // } else {
        //     $user_id = null;
        // }
        // session()->forget('user_id')
        // $request->session()->get('user_id');
    }

    public function checkout($product_slug = null)
    {
        $user = auth()->user();

        // Ensure RM has selected a store
        if ($user->hasRole('relational-manager') && !session()->has('store')) {
            return back()->with('error', 'Please Select Store!');
        }

        $user = $user->hasRole('relational-manager') ? session('store') : $user;

        if ($product_slug) {
            $product = Product::where('slug', $product_slug)->firstOrFail();
            return view('page.checkout', compact('product'));
        }

        if($user->cart == null){
            return back()->with('error', 'Try to access empty cart');
        }

        $cart = $user->cart->load('cartItems.product');

        return view('page.checkout', compact('cart'));
    }

    public function checkNewPrice(Request $request){

        $user = auth()->user();

        // Ensure RM has selected a store
        if ($user?->hasRole('relational-manager') && !session()->has('store')) {
            return response()->json([
                'error' => true,
                'message' => 'Please select store first!',
            ]);        
        }

        $cart_item = CartItem::findOrFail($request->item_id);
        $product = $cart_item->product;

        $store = User::findOrFail(session('store')->id);
        $level_id = $store->level->id + 1;
        $level = Level::find($level_id);

        if($level == null){
            return response()->json([
                'error' => true,
                'message' => 'Price is already lowest in all levels!',
            ]); 
        }
        
        $next_level_price = optional($product->priceVariations->where('level_id', $level_id)->first())->price;

        if(empty($next_level_price)){
            return response()->json([
                'error' => true,
                'message' => 'Price is already lowest in all levels!',
            ]); 
        }

        if($request->new_price < $next_level_price){
            $cart_item->requested_price = $request->new_price;
            $cart_item->approve = false;
            $cart_item->forwarded_to = 'admin';
            $cart_item->save();

            return response()->json([
                'error' => true,
                'message' => "RM can be change price upto $next_level_price, price lower then this are forwarded to Admin!",
            ]); 
        }

        // $cart_item->price = $request->new_price;
        $cart_item->requested_price = $request->new_price;
        $cart_item->approve = true;
        $cart_item->forwarded_to = 'Relational Manager';
        $cart_item->approver_name = $user->name;
        $cart_item->save();

        BargainedPrice::create([
            'product_id' => $product->id,
            'user_id' => $store->id,
            'price' => $request->new_price,
            'approved_by' => 'Relational Manager',
            'approver_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => "New Price Updated Successfully!",
        ]);
    }


    public function createOrder_old(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity.*' => 'integer|min:1',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = auth()->user(); // Ensure user is logged in

        // Get authenticated user
        if(session()->has('client')){
            $user = session('client');
        }

        // Initialize total order amount
        $totalOrderAmount = 0;

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'total_amount' => 0 // Placeholder, will update later
        ]);

        // Insert order items
        foreach ($request->product_id as $index => $productId) {
            $product = \App\Models\Product::find($productId);
            $quantity = $request->quantity[$index] ?? 1;
            $level_id = $user->level->id;
            $price = optional($product->priceVariations->where('level_id', $level_id)->first())->price;
            $total = $price * $quantity;

            // Add to total order amount
            $totalOrderAmount += $total;

            // Insert into order_items table
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total
            ]);
        }

        // Update order total
        $order->update(['total_amount' => $totalOrderAmount]);

        return redirect('/my-orders')->with('success', 'Order placed successfully!');
    }

    public function createOrder(Request $request)
    {
        // Validate the request data
        $request->validate([
            'action' => 'required|in:direct,cart',
        ]);

        $user = auth()->user();
        $user = $user->hasRole('relational-manager') ? session('store') : $user;

        // Initialize total order amount
        $totalOrderAmount = 0;

        if ($request->action == 'direct') {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => 0 // Placeholder, will update later
            ]);

            $product = Product::find($request->product_id);
            $quantity = $request->quantity;
            $level_id = $user->level->id;
            $price = optional($product->priceVariations->where('level_id', $level_id)->first())->price;
            $total = $price * $quantity;

            // Add to total order amount
            $totalOrderAmount += $total;

            // Insert into order_items table
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $request->product_id,
                'quantity' => $quantity,
                'price' => $price,
                'actual_price' => $price,
                'total' => $total
            ]);

            $order->update(['total_amount' => $totalOrderAmount]);
        }
        
        if ($request->action == 'cart') {
            
            $request->validate([
                'cart_id' => ['required', 'exists:carts,id'],
            ], [
                'cart_id.required' => 'Your cart is empty.', 
                'cart_id.exists' => 'Your cart is empty.', 
            ]);

            $cart = Cart::where('id', $request->cart_id)->where('user_id', $user->id)->firstOrFail();
            
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => 0 // Placeholder, will update later
            ]);

            $cartItems = CartItem::where('cart_id', $cart->id)->get();
            
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'actual_price' => $cartItem->actual_price,
                    'total' => $cartItem->total,
                    'forwarded_to' => $cartItem->forwarded_to,
                    'approver_name' => $cartItem->approver_name,
                ]);
                $totalOrderAmount += $cartItem->total;
            }

            $order->update(['total_amount' => $totalOrderAmount]);
            
            // Clear cart after order placement
            $cart->delete();
            CartItem::where('cart_id', $cart->id)->delete();
        }

        return redirect('/my-orders')->with('success', 'Order placed successfully!');
    }


    public function orderItems($order_id)
    {
        $user = auth()->user();

        // Check if the user is a relational manager
        if ($user->hasRole('relational-manager')) {
            // Fetch the order only if it belongs to the user's clients
            $order = Order::whereIn('user_id', $user->clients->pluck('id'))
                        ->where('id', $order_id)
                        ->first();

            if (!$order) {
                abort(404, 'Order not found');
            }
        } else {
            // Regular users can access their own orders
            $order = Order::where('id', $order_id)
                        ->where('user_id', $user->id)
                        ->firstOrFail();
        }

        return view('account.order-items-detail', compact('order'));
    }

    public function getCart()
    {
        $user = auth()->user();

        if($user->hasRole('relational-manager') and !session()->has('store')){
            return response()->json([
                'error' => true,
                'message' => 'Please select store'
            ]);
        }

        $user = $user->hasRole('relational-manager') ? session('store') : $user;

        // Fetch the cart with cart items and their associated products
        $cart = Cart::with('cartItems.product')->where('user_id', $user->id)->first();

        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty',
                'cart' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }

    public function updateCartNote(Request $request)
    {
        // Validate the request
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'note' => 'nullable|string|max:500',
            'proof' => 'nullable|array', // Changed to array for multiple files
            'proof.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048' // Validating each file in the array
        ]);

        // Find the cart
        $cart = Cart::findOrFail($request->cart_id);

        // Handle file uploads if provided
        $proofPaths = [];
        if ($request->hasFile('proof')) {
            foreach ($request->file('proof') as $file) {
                $proofPaths[] = $file->store('proofs', 'public'); // Store each file and add to array
            }
            // Assuming you want to store the paths as a JSON array
            $cart->proof = json_encode($proofPaths);
        }

        // Update the note
        $cart->note = $request->note;
        $cart->save();

        return back()->with('success', 'Note and proof updated successfully!');
    }


    public function addCart_old($product_id)
    {
        $user = auth()->user();

        // Ensure relational-manager has a selected store
        if ($user->hasRole('relational-manager') && !session()->has('store')) {
            return response()->json([
                'error' => true,
                'message' => 'Please select a store'
            ]);
        }

        // Assign store if relational-manager, else use the authenticated user
        $user = $user->hasRole('relational-manager') ? session('store') : $user;

        $product = Product::findOrFail($product_id);

        // Get the product price based on the user level
        $price = UserController::getProductPriceForUser($product->id);

        // Fetch or create a cart for the user
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total_amount' => 0]
        );

        // Fetch existing cart item if exists
        $cartItem = CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $product->id],
            [
                'quantity' => \DB::raw('quantity + 1'),
                'actual_price' => $price,
                'price' => $price,
                'total' => \DB::raw("(quantity) * $price")
            ]
        );

        // Update total cart amount efficiently
        $cart->update(['total_amount' => $cart->cartItems()->sum('total')]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart' => $cart->load('cartItems.product') // Load cart with items and products
        ]);
    }
  

    public function addCart(Request $request, $product_id)
    {
        $user = auth()->user();
        
        // Validate quantity input
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $quantity = $request->quantity; // Get the quantity from the request

        // Ensure relational-manager has a selected store
        if ($user->hasRole('relational-manager') && !session()->has('store')) {
            return response()->json([
                'error' => true,
                'message' => 'Please select a store'
            ]);
        }

        // Assign store if relational-manager, else use the authenticated user
        $user = $user->hasRole('relational-manager') ? session('store') : $user;

        $product = Product::findOrFail($product_id);

        // Get the product price based on the user level
        $price = UserController::getProductPriceForUser($product->id);

        // Fetch or create a cart for the user
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total_amount' => 0]
        );

        // Fetch existing cart item if exists
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // If product already exists in cart, update quantity and total
            $cartItem->increment('quantity', $quantity);
            $cartItem->update(['total' => $cartItem->quantity * $price]);
        } else {
            // If product is new in cart, create a new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'actual_price' => $price,
                'price' => $price,
                'total' => $quantity * $price
            ]);
        }

        // Update total cart amount
        $cart->update(['total_amount' => $cart->cartItems()->sum('total')]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart' => $cart->load('cartItems.product') // Load cart with items and products
        ]);
    }


    public function updateCart(Request $request, $product_id)
    {
        $user = auth()->user();

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $quantity = $request->quantity;

        // Find or create the user's cart
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total_amount' => 0]
        );

        // Find the product to get its price
        $product = Product::findOrFail($product_id);
        $price = UserController::getProductPriceForUser($product->id);

        // Find the cart item
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product_id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $quantity,
                'total' => $quantity * $cartItem->price
            ]);
        } else {
            // If no cart item exists, create a new one
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'actual_price' => $price,
                'price' => $price,
                'total' => $quantity * $price
            ]);
        }

        // Update the total cart amount
        $totalAmount = $cart->cartItems()->sum('total');
        $cart->update(['total_amount' => $totalAmount]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart' => $cart->load('cartItems.product')
        ]);
    }

    public function updateCartItem(Request $request, $item_id){
        $user = auth()->user();
    
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
    
        $cart_item = CartItem::findOrFail($item_id);
    
        // Recalculate the total for this cart item
        $cart_item->update([
            'quantity' => $request->quantity,
            'total' => $request->quantity * $cart_item->price // Ensure price is used correctly
        ]);
    
        $cart = $cart_item->cart;
    
        // Update the cart total amount
        $totalAmount = $cart->cartItems()->sum('total');
        $cart->update(['total_amount' => $totalAmount]);
    
        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart' => $cart->load('cartItems.product')
        ]);
    }
    

    public function updateCart_work_direct_with_inc_dec(Request $request, $product_id)
    {
        $user = auth()->user();

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $quantity = $request->quantity;

        // Find or create the user's cart
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total_amount' => 0]
        );

        // Find the product to get its price
        $product = Product::findOrFail($product_id);
        $price = UserController::getProductPriceForUser($product->id);

        // Find the cart item
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product_id)
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $quantity,
                'total' => $quantity * $cartItem->price
            ]);
        } else {
            // If no cart item exists, create a new one
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'actual_price' => $price,
                'price' => $price,
                'total' => $quantity * $price
            ]);

        }

        // Update the total cart amount
        $totalAmount = $cart->cartItems()->sum('total');
        $cart->update(['total_amount' => $totalAmount]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart' => $cart->load('cartItems.product')
        ]);
    }


    public function removeCartItem(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
        ]);

        $user = auth()->user();
        $user = $user->hasRole('relational-manager') ? session('store') : $user;

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action!',
            ], 403);
        }

        // Fetch the cart item
        $cartItem = CartItem::findOrFail($request->cart_item_id);
        
        // Ensure the cart belongs to the correct user
        if ($cartItem->cart->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'This cart item does not belong to you!',
            ], 403);
        }

        // Get the cart before deleting the item
        $cart = $cartItem->cart;

        // Delete the cart item
        $cartItem->delete();

        // Update the cart's total amount
        $cart->update(['total_amount' => $cart->cartItems()->sum('total')]);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart successfully!',
            'cart' => $cart->load('cartItems.product') // Return updated cart with items
        ]);
    }

    // check-in check-out as daily 
    public function rmCheckIn()
    {
        // Check if attendance already exists for today
        $attendence = auth()->user()->attendence;
        if ($attendence) {
            return back()->with('error', 'Attendance already marked for today.');
        }

        // Create new attendance record for today
        Attendence::create([
            'user_id' => auth()->id(),
            'date' => now()->toDateString(), // Today's date
            'check_in' => now(), // Current timestamp for check-in
            'status' => 1, // Status 1 for check-in (can be used to indicate "present")
        ]);

        return back()->with('success', 'Successfully checked in.');
    }

    public function rmCheckOut() // check-in check-out code
    {
        // Check if there's an attendance record for today
        $attendance = auth()->user()->attendence;

        if (!$attendance) {
            return back()->with('error', 'No attendance found for today. Please check in first.');
        }

        // Update the attendance record with check-out time
        $attendance->update([
            'check_out' => now(), // Current timestamp for check-out
        ]);

        return back()->with('success', 'Successfully checked out.');
    }

    public function updateLocation(Request $request) {
        $user = auth()->user();
        
        // Check if user is checked in
        if (!$user || !$user->attendence || $user->attendence->check_out) {
            return response()->json(['error' => 'User is not checked in'], 403);
        }
    
        // Save new location entry in GeoTracking table
        $geoTracking = GeoTracking::create([
            'user_id' => $user->id,
            'attendence_id' => $user->attendence->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
    
        // Find nearby stores within 50 meters
        $nearbyStores = User::where('added_by', $user->id)
            ->select('id', 'name', 'latitude', 'longitude')
            ->selectRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) 
                          * cos(radians(longitude) - radians(?)) + sin(radians(?)) 
                          * sin(radians(latitude)))) AS distance", 
                          [$request->latitude, $request->longitude, $request->latitude])
            ->having("distance", "<", 0.05) // 50 meters
            ->orderBy("distance")
            ->get();
    
        // Broadcast location update event along with nearby stores
        event(new RMLocationUpdated($user->id, $request->latitude, $request->longitude, $nearbyStores));
    
        return response()->json([
            'message' => 'Location updated',
            'nearby_stores' => $nearbyStores
        ]);
    }

    public function selectStore(Request $request){
        if ($request->selected_store) {
            $store = User::findOrFail($request->selected_store);
            session()->put('store', $store);
            return back()->with('success', 'Store Selected Successfully!');
        }
        return back()->with('error', 'Bad Request : 403');
    }

    public function getStores()
    {
        $user = auth()->user();

        // Convert associative array {"Store Name": ID} to [{ id: ID, name: "Store Name" }]
        $stores = $user->clients->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->name,
            ];
        });

        return response()->json($stores);
    }

    public function myFranchises()
    {
        $company = auth()->user();
        $franchises = $company->franchises;

        return view('account.my-franchises', compact('franchises'));
    }

    public function createFranchise(){
        return view('account.create-franchise');
    }

    public function storeFranchise(Request $request)
    {
        // ✅ Validate request data
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|string|max:15|unique:users,phone',
            'password'  => 'required|min:6',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'type'      => 'required|in:complete-franchise,partial-franchise',
            'address'   => 'required|string',
            'images.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            // ✅ Create new User (Franchise)
            $user = User::create([
                'name'           => $validated['name'],
                'email'          => $validated['email'],
                'phone'          => $validated['phone'],
                'password'       => Hash::make($validated['password']),
                'latitude'       => $validated['latitude'],
                'longitude'      => $validated['longitude'],
                'address'        => $validated['address'],
                'added_by'       => auth()->user()->rm->id,
                'parent_company' => auth()->id(),
            ]);

            // Assign Role
            $user->assignRole($validated['type']);

            // ✅ Handle Multiple Image Uploads
            if ($request->hasFile('images')) {
                $imagePaths = collect($request->file('images'))
                    ->map(fn ($image) => $image->store('franchise_images', 'public'))
                    ->toArray();

                $user->update(['images' => json_encode($imagePaths)]);
            }

            return redirect()->back()->with('success', 'Franchise registered successfully!');
        });
    }

    public function createFranchiseView(){
        return view('account.create-store');
    }

    public function createStore(Request $request)
    {
        // ✅ Validate request data
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|string|max:15|unique:users,phone',
            'password'  => 'required|min:6',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'address'   => 'required|string',
            'images.*'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            // ✅ Create new User (Franchise)
            $user = User::create([
                'name'           => $validated['name'],
                'email'          => $validated['email'],
                'phone'          => $validated['phone'],
                'password'       => Hash::make($validated['password']),
                'latitude'       => $validated['latitude'],
                'longitude'      => $validated['longitude'],
                'address'        => $validated['address'],
                'added_by'       => auth()->user()->id,
                'level_id'       => 1,
            ]);

            // Assign Role
            $user->assignRole('business');

            // ✅ Handle Multiple Image Uploads
            if ($request->hasFile('images')) {
                $imagePaths = collect($request->file('images'))
                    ->map(fn ($image) => $image->store('franchise_images', 'public'))
                    ->toArray();

                $user->update(['images' => json_encode($imagePaths)]);
            }

            return redirect()->back()->with('success', 'Store registered successfully!');
        });
    }

    public function productSearch(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->take(10)->get();

        $html = '';

        foreach ($products as $product) {
            $html .= view('components.product-card', compact('product'))->render();
        }

        return response()->json(['html' => $html]);
    }

}

    // public function myOrders()
    // {
    //     $user = auth()->user();

    //     // Ensure relational-manager has a selected store
    //     if ($user?->hasRole('relational-manager') && !session()->has('store')) {
    //         return back()->with('error', 'Please Select a Store!');
    //     }

    //     // Assign store if user is a relational-manager
    //     $user = $user->hasRole('relational-manager') ? session('store') : $user;

    //     // Eager load necessary relationships to prevent N+1 queries
    //     $orders = $user->orders()->with('orderItems.product')->latest()->get();

    //     return view('account.my-orders', compact('orders'));
    // }
