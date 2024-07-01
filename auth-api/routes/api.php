<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Route::middleware('auth:sanctum')->get('/dashboard', function (Request $request) {
//     return response()->json(['message' => 'Welcome to your dashboard!', 'user' => $request->user()]);
// });
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('cart', CartController::class);
    Route::apiResource('wishlist', WishlistController::class);
    Route::get('images/{filename}', [ImageController::class, 'show'])->name('images.show');
    Route::post('upload-image', [ImageController::class, 'upload'])->name('upload.image');
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    Route::get('/user', [UserController::class, 'show']); // Fetch profile
    Route::post('/update-profile', [UserController::class, 'updateProfile']); // Update profile
    Route::get('/address', [UserController::class, 'showAddress']); // Fetch address
    Route::post('/update-address', [UserController::class, 'updateAddress']); // Update address
    Route::post('/update-settings', [UserSettingsController::class, 'updateSettings']);
    Route::post('/change-password', [UserSettingsController::class, 'changePassword']);

});
Route::get('/user', function (Request $request) {
    return $request->user();
});
