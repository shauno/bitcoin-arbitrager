<?php

namespace App\Providers;

use BtcArbitrager\ExchangeRates\ExchangeRateRepository;
use BtcArbitrager\ExchangeRates\ExchangeRateRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExchangeRateRepository::class, function() {
            return new ExchangeRateRepositoryEloquent();
        });
    }
}
