<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Support\ServiceProvider;
use Iqbalatma\LaravelServiceRepo\Commands\GenerateRepositoryCommand;
use Iqbalatma\LaravelServiceRepo\Commands\GenerateServiceCommand;

class ServiceRepoProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/servicerepo.php', 'servicerepo');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if($this->app->runningInConsole()){
            $this->commands([
                GenerateServiceCommand::class,
                GenerateRepositoryCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/Config/servicerepo.php' => config_path('servicerepo.php'),
            __DIR__ . '/Config/servicerepo.php' => config_path('servicerepo.php'),
        ]);
    }
}
