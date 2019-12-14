<?php

namespace Knowfox\Passwordless;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadViewsFrom(__DIR__ . '/../views', 'passwordless');
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'passwordless');

        $this->publishes([
            __DIR__ . '/../views' => resource_path('views/vendor/passwordless'),
            __DIR__ . '/../passwordless.php' => config_path('passwordless.php'),
            __DIR__ . '/../lang' => resource_path('lang/vendor/passwordless'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../passwordless.php', 'passwordless'
        );
    }
}
