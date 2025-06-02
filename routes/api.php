<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Test route
Route::get('/test', function () {
    return response()->json(['message' => 'API routes are working!']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Product routes
Route::get('/products', [ProductController::class, 'index']);          // GET /api/products
    Route::get('/products/{id}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']); // basic info

    // Additional profile routes
    Route::get('/user/profile', [UserController::class, 'profile']); // full with relations
    Route::put('/user/update', [UserController::class, 'update']);
    Route::get('/user/orders', [UserController::class, 'orders']);

    Route::get('/orders', [OrderController::class, 'index']); // List user orders
    Route::get('/orders/{id}', [OrderController::class, 'show']); // View order details
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']); // Cancel order
    Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice']);

    Route::get('/cart', [CartController::class, 'index']);           // GET /api/cart
    Route::post('/cart', [CartController::class, 'store']);          // POST /api/cart
    Route::put('/cart/{cartItem}', [CartController::class, 'update']); // PUT /api/cart/{cartItem}
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy']);
});
