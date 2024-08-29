<?php

namespace App\Providers;

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
        //
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

        // Set the application locale based on the session or use the default locale
        $locale = Session::get('locale', config('app.locale'));
        App::setLocale($locale);
    }
}
