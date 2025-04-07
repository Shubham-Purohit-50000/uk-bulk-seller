<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\ProductController;
use App\Admin\Controllers\CustomController;

use App\Models\Attendence;
use App\Models\GeoTracking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use \App\Models\Product;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('categories', CategoryController::class);
    $router->resource('products', ProductController::class);
    $router->resource('levels', LevelController::class);
    $router->resource('price-variations', PriceVariationController::class);
    $router->resource('business-customers', BusinessCustomerController::class);
    $router->resource('companies', CompanyController::class);
    $router->resource('orders', OrderController::class);
    $router->resource('order-items', OrderItemController::class);
    $router->resource('transactions', TransactionController::class);
    $router->resource('relation-managers', RelationManagerController::class);
    $router->resource('carts', CartController::class);
    $router->resource('cart-items', CartItemController::class);
    $router->resource('wish-lists', WishListController::class);
    $router->resource('users', UserController::class);
    $router->resource('variation-attributes', VariationAttributeController::class);
    $router->resource('variation-options', VariationOptionController::class);
    $router->resource('product-variation-options', ProductVariationOptionController::class);
    $router->resource('epos-order', EposOrderController::class);
    $router->resource('bargained-prices', BargainedPriceController::class);

    $router->resource('attendences', AttendenceController::class);
    Route::post('/admin/products/import', [ProductController::class, 'import'])->name('products.import');


    // Fetch attendance data for FullCalendar.js
    Route::get('/get-attendance-events/{user_id}', function ($user_id) {
        $attendances = Attendence::where('user_id', $user_id)
            ->select('date', 'status', 'check_in', 'check_out')
            ->get();
    
        $events = $attendances->map(function ($attendance) {
            if (!$attendance->status) {
                return [
                    'title' => 'Absent',
                    'start' => $attendance->date,
                    'color' => 'red',
                ];
            }
    
            // Convert check_in and check_out to Carbon instances
            $checkIn = Carbon::parse($attendance->check_in);
            $checkOut = $attendance->check_out ? Carbon::parse($attendance->check_out) : null;
    
            $color = $checkOut ? 'green' : 'orange';
            $timeGap = $checkOut ? $checkIn->diffInMinutes($checkOut) : null;
            $title = 'Present' . ($timeGap ? " ($timeGap min)" : '');
    
            return [
                'title' => $title,
                'start' => $attendance->date,
                'color' => $color,
            ];
        });
    
        return response()->json($events);
    });// ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

    // Fetch tracking data for selected date
    Route::get('/get-tracking-data/{user_id}/{date}', function ($user_id, $date) {
        $attendance = Attendence::where('user_id', $user_id)->where('date', $date)->first();
        if (!$attendance) {
            return response()->json([]);
        }
    
        $trackingData = GeoTracking::where('attendence_id', $attendance->id)
            ->orderBy('created_at', 'asc')
            ->get();
    
        $processedData = [];
        $lastLocation = null;
        $startTime = null;
        
        foreach ($trackingData as $index => $point) {
            $lat = $point->latitude;
            $lng = $point->longitude;
            $time = $point->created_at;
    
            if ($lastLocation && $lastLocation['latitude'] == $lat && $lastLocation['longitude'] == $lng) {
                // Continue counting time at the same location
                $lastLocation['end_time'] = $time;
            } else {
                // If the user has moved, record the previous stop duration
                if ($lastLocation && $lastLocation['start_time'] != $lastLocation['end_time']) {
                    $lastLocation['duration'] = $lastLocation['start_time']->diffInMinutes($lastLocation['end_time']);
                    $processedData[] = $lastLocation;
                }
    
                // Start a new location tracking
                $lastLocation = [
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'start_time' => $time,
                    'end_time' => $time, // Initially same as start
                    'duration' => 0
                ];
            }
        }
    
        // Add the last recorded stop if applicable
        if ($lastLocation && $lastLocation['start_time'] != $lastLocation['end_time']) {
            $lastLocation['duration'] = $lastLocation['start_time']->diffInMinutes($lastLocation['end_time']);
            $processedData[] = $lastLocation;
        }
    
        return response()->json($processedData);
    });

    Route::get('/get/product-price', [CustomController::class, 'getPrice']);
    Route::get('/get/product-by-barcode', [CustomController::class, 'getProductByBarcode']);

});
