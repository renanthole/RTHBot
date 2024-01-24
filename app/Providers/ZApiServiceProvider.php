<?php

namespace App\Providers;

use App\Api\ApiManager;
use Illuminate\Support\ServiceProvider;

class ZApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('z-api', function () {
            return new ApiManager(config('z-api'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
