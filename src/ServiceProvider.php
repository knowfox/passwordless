<?php

namespace Knowfox\Passwordless;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadViewsFrom(__DIR__ . '/../views', 'passwordless');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    public function register()
    {
    }
}