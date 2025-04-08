<?php

namespace App\Providers;

use App\Integration\Fenix\FenixApiClient;
use App\Integration\Fenix\FenixClientInterface;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FenixClientInterface::class, FenixApiClient::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Existing bootstrapping code
        Paginator::useBootstrap();
        Order::observe(OrderObserver::class);
    }
}
