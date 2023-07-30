<?php

namespace Iqbalatma\LaravelServiceRepo\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class GenerateServiceCommand extends Command
{
    protected $signature = "make:service {name : service filename}";

    protected $description = "Generate new service";

    protected Filesystem $files;
    protected const STUB_PATH = __DIR__ . '/../Stubs/Service.stub';
    protected string $targetPath;
    protected string $singularClassName;



    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }


    public function handle()
    {
        $this->setSingularClassName()
            ->setTargetFilePath()
            ->makeDirectory();


        if (!$this->files->exists($this->targetPath)) {
            $this->files->put($this->targetPath, $this->getTemplateFileContent());
            $this->info("File : {$this->targetPath} created");
        } else {
            $this->info("File : {$this->targetPath} already exits");
        }
    }



    /**
     * @return array
     */
    private function getStubVariables(): array
    {
        $singularClassName = $this->singularClassName;

        $explodedClassName = explode("/", $singularClassName);

        $namespace = "";
        $explodedNamespace = explode("/", $singularClassName);

        // when namespace is more than 1 segment, remove last part because it is class name, and get previous part because its namespace dir
        if (count($explodedNamespace) > 1) {
            array_pop($explodedNamespace);
            $namespace = "\\" . implode("\\", $explodedNamespace);
        }

        return [
            'NAMESPACE' => ucwords(str_replace("/", "\\", config("servicerepo.target_service_dir", "app/Services"))) . $namespace,
            'CLASS_NAME' => end($explodedClassName)
        ];
    }


    /**
     * @return array|false|string|string[]
     */
    private function getTemplateFileContent()
    {
        $content = file_get_contents(self::STUB_PATH);

        foreach ($this->getStubVariables() as $search => $replace) {
            $content = str_replace("*$search*", $replace, $content);
        }

        return $content;
    }

    /**
     * @return self
     */
    private function setSingularClassName(): self
    {
        $this->singularClassName = ucwords(Pluralizer::singular($this->argument('name')));
        return $this;
    }



    /**
     * @return self
     */
    private function setTargetFilePath(): self
    {
        $className = $this->singularClassName;
        $this->targetPath = base_path( config("servicerepo.target_service_dir","app/Services")) . "/$className.php";

        return $this;
    }


    /**
     * @return $this
     */
    private function makeDirectory(): self
    {
        if (!$this->files->isDirectory(dirname($this->targetPath))) {
            $this->files->makeDirectory(dirname($this->targetPath), 0777, true, true);
        }

        return $this;
    }
}
