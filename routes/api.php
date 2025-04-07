<?php

use Illuminate\Support\Facades\Route;
use App\Events\RMLocationUpdated;
use App\Models\GeoTracking;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/update-location', function (Request $request) {
    $user = auth()->user();
    return response()->json(['shubham error' => $user->attendence->check_out]);
    if (!$user || !$user->attendence || $user->attendence->check_out) {
        return response()->json(['error' => 'User is not checked in'], 403);
    }

    // Save to database
    $geoTracking = GeoTracking::create([
        'user_id' => $user->id,
        'attendence_id' => $user->attendence->id,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
    ]);

    // Broadcast location update event
    event(new RMLocationUpdated($user->id, $request->latitude, $request->longitude));

    return response()->json(['message' => 'Location updated']);
});