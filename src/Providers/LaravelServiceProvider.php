<?php

namespace Iqbalatma\LaravelExtend\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([__DIR__ . "/../config/service-repo.php" => config_path("service-repo.php")], 'service-repo-config');
    }
}
