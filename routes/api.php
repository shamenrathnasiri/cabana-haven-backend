<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('bookings', App\Http\Controllers\BookingController::class);

Route::prefix('admin')->group(function () {
Route::post('login', [AdminAuthController::class, 'login']);
});
Route::get('booking/status/{deleted}', [App\Http\Controllers\BookingController::class, 'getByStatus']);
