<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Retailer;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use App\Observers\UserObserver;
use App\Observers\RetailerObserver;

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

    public function boot()
    {
        User::observe(UserObserver::class);
        Retailer::observe(RetailerObserver::class);
        Passport::ignoreMigrations();
        \Dusterio\LumenPassport\LumenPassport::routes($this->app);
    }
}
