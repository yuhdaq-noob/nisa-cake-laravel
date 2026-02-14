<?php

// FIXME: PERHITUNGAN

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Pages
    Route::get('/', fn () => redirect()->route('kasir'));
    Route::get('/kasir', fn () => view('kasir'))->name('kasir');
    Route::get('/gudang', [InventoryController::class, 'index'])->name('gudang');
    Route::get('/laporan', fn () => view('laporan'))->name('laporan');

    // API Endpoints
    Route::post('/materials/reduce', [MaterialController::class, 'reduceStock'])->name('materials.reduce');
    // FIXME: TIDAK DIPAKAI
    // UI gudang menggunakan endpoint API /api/stocks/add (via gudang.js), bukan web route ini.
    Route::post('/stocks/add', [StockController::class, 'store'])->name('stocks.add');
    Route::get('/laporan/export', [ReportController::class, 'export'])->name('laporan.export');
});
