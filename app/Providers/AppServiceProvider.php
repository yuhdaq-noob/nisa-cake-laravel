<?php

namespace App\Providers;

use App\Services\OrderService;
use App\Services\StockService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OrderService::class, function ($app) {
            return new OrderService;
        });

        $this->app->singleton(StockService::class, function ($app) {
            return new StockService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('navbarLinks', [
            ['label' => 'Kasir', 'href' => '/kasir', 'key' => 'kasir'],
            ['label' => 'Gudang', 'href' => '/gudang', 'key' => 'gudang'],
            ['label' => 'Laporan', 'href' => '/laporan', 'key' => 'laporan'],
        ]);
    }
}
