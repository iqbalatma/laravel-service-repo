<?php

namespace Iqbalatma\LaravelServiceRepo\Commands;


use Illuminate\Console\Command;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\MakeCommandInterface;
use Iqbalatma\LaravelServiceRepo\Traits\MakeCommand;

class GenerateAbstractCommand extends Command implements MakeCommandInterface
{
    use MakeCommand;

    protected const STUB_FILE_PATH = __DIR__ . "/../Stubs/abstract.stub";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:abstract {name : abstract name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new abstract class';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->prepareMakeCommand(config("servicerepo.target_abstract_dir", "app/Contracts/Abstracts"))
            ->generateFromStub();
    }

    /**
     * @return string
     */
    public function getStubContent(): string
    {
        /**
         * using abstract stub from published stub if exists, and default stub if not exists
         */
        $overridePath = base_path("stubs/service-repo/abstract.stub");
        $stubContent = $this->filesystem->exists($overridePath) ?
            file_get_contents($overridePath) :
            file_get_contents(self::STUB_FILE_PATH);

        /**
         * replacing stub placeholder with variables
         */
        foreach ($this->getStubVariables() as $key => $variable) {
            $stubContent = str_replace("*$key*", $variable, $stubContent);
        }

        return $stubContent;
    }

    /**
     * @return array
     */
    public function getStubVariables(): array
    {
        return [
            "CLASS_NAME" => $this->getClassName(),
            "NAMESPACE" => $this->getNamespace()
        ];
    }
}
