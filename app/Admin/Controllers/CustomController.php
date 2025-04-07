<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use \App\Models\Product;
use \App\Models\Order;
use Illuminate\Http\Request;

class CustomController extends AdminController
{
    public function getScanProduct($barcode, $customer_id)
    {
        // Fetch product with only necessary fields
        $product = Product::select('id', 'name', 'barcode', 'description', 'image')
                        ->where('barcode', $barcode)
                        ->first();

        // If product not found, return JSON response
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found!'
            ]);
        }

        // Get price based on customer ID
        $price = \App\Http\Controllers\UserController::getProductPriceForUser($product->id, $customer_id);

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'barcode' => $product->barcode,
                'description' => $product->description,
                'image' => $product->image,
                'price' => $price // Using the correct price for the customer
            ]
        ]);
    }

    public function getPrice(Request $request)
    {
        $customer_id = $request->order_id 
            ? Order::where('id', $request->order_id)->value('user_id') 
            : $request->customer_id;

        $price = \App\Http\Controllers\UserController::getProductPriceForUser($request->product_id, $customer_id);

        return response()->json([
            'success' => true,
            'price' => $price
        ]);
    }


    public function getProductByBarcode(Request $request)
    {
        $barcode = $request->barcode;
        $customer_id = $request->order_id 
            ? Order::where('id', $request->order_id)->value('user_id') 
            : $request->customer_id;

        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $price = \App\Http\Controllers\UserController::getProductPriceForUser($product->id, $customer_id);

        return response()->json([
            'product' => true,
            'product_name' => $product->name,
            'product_id' => $product->id,
            'price' => $price
        ]);
    }

}