<?php

namespace Iqbalatma\LaravelExtend;

use Illuminate\Support\ServiceProvider;

class ServiceRepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/config/servicerepo.php' => config_path('servicerepo.php'),
        ]);
    }
}
