<?php

namespace App\Providers;

use App\Contracts\AuthenticateInterface;
use App\Contracts\PaymentGatewayInterface;
use App\Services\AuthenticateServices;
use App\Services\StripeServices;
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
        $this->app->bind(PaymentGatewayInterface::class,StripeServices::class);
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
