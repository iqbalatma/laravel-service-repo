<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceRepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->publishes([
            __DIR__.'/config/servicerepo.php' => config_path('servicerepo.php'),
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
