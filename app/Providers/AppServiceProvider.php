<?php

namespace App\Providers;

use App\Integration\FenixApiClient;
use App\Integration\FenixClientInterface;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
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
