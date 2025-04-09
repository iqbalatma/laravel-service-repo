<?php

namespace Iqbalatma\LaravelServiceRepo\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishStubCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-repo:publish-stub';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish stub on generate command abstract, interface, enum, and trait';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info("Publishing generate command stub");

        $fileSystem = new Filesystem();

        $targetPath = base_path("/stubs/service-repo");
        if (!$fileSystem->isDirectory($targetPath)){
            $fileSystem->makeDirectory($targetPath, recursive: true);
        }

        foreach ($fileSystem->allFiles(__DIR__ . "/../Stubs",) as $file) {
            $fileSystem->copy($file->getRealPath(), $targetPath."/".$file->getFilename());
        }

        $this->info("Stub asset published");
    }
}
