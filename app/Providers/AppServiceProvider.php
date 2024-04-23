<?php

namespace App\Providers;

use App\Contracts\AuthenticateInterface;
use App\Services\AuthenticateServices;
use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $this->app->bind(AuthenticateInterface::class,AuthenticateServices::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
