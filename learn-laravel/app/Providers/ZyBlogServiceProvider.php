<?php

namespace App\Providers;

use App\ContainerTest\ZyBlog;
use Illuminate\Support\ServiceProvider;

class ZyBlogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('zyblog', function(){
            return new ZyBlog();
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
        if(!$this->app['zyblog']->getPhone()){
            $this->app['zyblog']->setPhone($this->app->make(env('PHONE', 'iphone12')));
        }
    }
}
