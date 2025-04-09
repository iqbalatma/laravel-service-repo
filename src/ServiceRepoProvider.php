<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Support\ServiceProvider;
use Iqbalatma\LaravelServiceRepo\Commands\GenerateAbstractCommand;
use Iqbalatma\LaravelServiceRepo\Commands\GenerateEnumCommand;
use Iqbalatma\LaravelServiceRepo\Commands\GenerateInterfaceCommand;
use Iqbalatma\LaravelServiceRepo\Commands\GenerateRepositoryCommand;
use Iqbalatma\LaravelServiceRepo\Commands\GenerateServiceCommand;
use Iqbalatma\LaravelServiceRepo\Commands\GenerateTraitCommand;
use Iqbalatma\LaravelServiceRepo\Commands\PublishStubCommand;

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
                GenerateAbstractCommand::class,

                GenerateEnumCommand::class,
                GenerateInterfaceCommand::class,
                GenerateTraitCommand::class,
                PublishStubCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/Config/servicerepo.php' => config_path('servicerepo.php'),
        ]);

        viewShare([
            "breadcrumbs" => []
        ]);
    }
}
