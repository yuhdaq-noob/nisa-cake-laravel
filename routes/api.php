<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialPriceLogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User profile endpoint
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Order Management
    Route::post('/buat-pesanan', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::patch('/orders/{order}/complete', [OrderController::class, 'complete']);

    // Product Management
    Route::get('/products', [ProductController::class, 'index']);

    // Material Management
    Route::get('/materials', [MaterialController::class, 'index']);
    Route::patch('/materials/{material}/price', [MaterialController::class, 'updatePrice']);
    Route::post('/materials/reduce', [MaterialController::class, 'reduceStock']);
    Route::get('/materials/price-history', [MaterialPriceLogController::class, 'index']);

    // Report Generation
    Route::get('/reports', [ReportController::class, 'index']);

    // Stock Management
    Route::post('/stocks/add', [StockController::class, 'store']);
    Route::get('/stocks/history', [StockController::class, 'index']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
