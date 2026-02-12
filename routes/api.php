<?php

use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialPriceLogController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User profile endpoint
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Order Management
Route::post('/buat-pesanan', [OrderController::class, 'store']);

// Product Management
Route::get('/products', [ProductController::class, 'index']);

// Material Management
Route::get('/materials', [MaterialController::class, 'index']);
Route::patch('/materials/{material}/price', [MaterialController::class, 'updatePrice']);
Route::get('/materials/price-history', [MaterialPriceLogController::class, 'index']);

// Report Generation
Route::get('/reports', [ReportController::class, 'index']);

// Stock Management
Route::post('/stocks/add', [StockController::class, 'store']);
Route::get('/stocks/history', [StockController::class, 'index']);
Route::post('/materials/reduce', [MaterialController::class, 'reduceStock']);
