<?php

namespace App\Providers;

use App\ContainerTest\iPhone12;
use App\ContainerTest\Mi11;
use Illuminate\Support\ServiceProvider;

class PhoneServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('iphone12', function(){
            return new iPhone12();
        });
        $this->app->bind('mi11', function(){
            return new Mi11();
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
