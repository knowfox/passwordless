<?php

namespace Knowfox\Passwordless;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Knowfox\Entangle\Commands\ImportEntangle;
use Knowfox\Entangle\Models\EventExtension;
use Knowfox\Entangle\Models\LocationExtension;

class ServiceProvider extends IlluminateServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadViewsFrom(__DIR__ . '/../views', 'entangle');
    }

    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }
}