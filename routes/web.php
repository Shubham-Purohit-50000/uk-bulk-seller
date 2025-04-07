<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\UserController;


Route::controller(FrontEndController::class)->group(function () {
    // Route::get('test', 'home_new')->name('frontend.home.new'); // Home page
    Route::get('/', 'home_new')->name('frontend.home'); // Home page
    Route::get('/about', 'about')->name('page.about'); // About page
    Route::get('/contact', 'contact')->name('page.contact'); // Contact page
    Route::get('/search-products', 'productSearch');


    Route::middleware(['role:business','role:user'])->group(function () {
        // Route::get('rm/check-in', [ProductController::class, 'bulkPricing']);
        // Route::get('/rm/check-in', 'checkIn');
    });

    Route::middleware(['role:relational-manager'])->group(function () {
        Route::get('/rm/check-in', 'rmCheckIn');
        Route::get('/rm/check-out', 'rmCheckOut');
        Route::post('/update-location', 'updateLocation');
        Route::post('/select-store', 'selectStore');
        Route::post('/check-new-price', 'checkNewPrice');
        Route::get('/get-stores', 'getStores');
    });

    // common route for all 3 users
    Route::middleware(['auth'])->group(function () {
        Route::get('/shop/{categorySlug?}', 'shop')->name('page.shop');
        Route::get('/account', 'myAccount')->name('page.account');
        Route::get('/my-orders', 'myOrders')->name('page.my-orders');
        Route::get('/product-detail/{slug}', 'product')->name('page.product-detail');
        Route::get('/checkout/{product_slug?}', 'checkout')->name('page.checkout');
        Route::post('order', 'createOrder')->name('page.store.order');
        Route::get('order-items/{order_id}', 'orderItems')->name('page.view.order.items');
        Route::post('add-cart/{product_id}', 'addCart');
        Route::post('update-cart/{product_id}', 'updateCart');
        Route::post('update-cart-item/{item_id}', 'updateCartItem');
        Route::post('/cart/remove', 'removeCartItem');
        Route::get('/cart', 'getCart');
        Route::post('/update/cart/note', 'updateCartNote');
        Route::get('/franchises', 'myFranchises')->name('page.my-franchises');
        Route::get('/create-franchise', 'createFranchise')->name('page.create-franchise');
        Route::post('/store-franchise', 'storeFranchise')->name('page.store-franchise');
        Route::get('/create-store', 'createStoreView')->name('page.create-store-view');
        Route::post('/create-store', 'createStore')->name('page.create-store');
    });
});

Route::controller(UserController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('login', 'postLogin')->name('post.login');
    Route::get('logout', 'logout')->name('logout');
});

// Route::middleware(['role:user-businesses'])->group(function () {
//     Route::get('/bulk-pricing', [ProductController::class, 'bulkPricing']);
// });

Route::get('/shub-categories', [FrontEndController::class, 'shub_index']);
Route::get('/shub-products/{subcategory}', [FrontEndController::class, 'shub_getProducts']);