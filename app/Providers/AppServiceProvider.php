<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Session\MongoSessionHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
public function boot()
{
    Session::extend('mongo', function ($app) {
        return new MongoSessionHandler();
    });
}
    /**
     * Bootstrap any application services.
     */

}
