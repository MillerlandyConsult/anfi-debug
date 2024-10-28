<?php

namespace ANFI\DebugPackage;

use Illuminate\Support\ServiceProvider;

class DebugServiceProvider extends ServiceProvider
{
    /**
     * Bootstraps the package services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'anfi-debug');

//        $this->publishes([
//            __DIR__.'/../public/css' => public_path('vendor/anfi-debug/css'),
//        ], 'public');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/anfi-debug'),
        ], 'views');

        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    /**
     * Registers a new user or entity into the system.
     *
     */
    public function register()
    {
        //
    }
}
