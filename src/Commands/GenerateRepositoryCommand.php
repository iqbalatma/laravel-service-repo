<?php

namespace Iqbalatma\LaravelServiceRepo\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class GenerateRepositoryCommand extends Command
{
    protected $signature = "make:repository {name : service filename} {--M|model=}";

    protected $description = "Generate new repository";
    protected const STUB_PATH = __DIR__ . '/../Stubs/Repository.stub';

    protected Filesystem $files;
    protected string $targetPath;
    protected string $singularClassName;
    protected string $modelName;

    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }


    /**
     * @return void
     */
    public function handle(): void
    {
        $this->setSingularClassName()
            ->setModelName()
            ->setTargetFilePath()
            ->makeDirectory();

        if (!$this->files->exists($this->targetPath)) {
            $this->files->put($this->targetPath, $this->getTemplateFileContent()); // use to put file
            $this->info("File : {$this->targetPath} created");
        } else {
            $this->warn("File : {$this->targetPath} already exits"); // condition when file already exists
        }
    }


    /**
     * @return self
     */
    private function setModelName(): self
    {
        $this->modelName = is_null($this->option("model")) ?
            str_replace("Repository", "", $this->argument("name")) :
            $this->option("model");

        return $this;
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

        $explodedModelName = explode("/", $this->modelName);

        return [
            'NAMESPACE' => ucwords(str_replace("/", "\\", config("servicerepo.target_repository_dir", "app/Repositories"))) . $namespace,
            'MODEL_NAMESPACE' => config("servicerepo.model_root_namespace", "App\\Models") . "\\" . str_replace("/", "\\", $this->modelName),
            'CLASS_NAME' => end($explodedClassName),
            'MODEL_NAME' => end($explodedModelName),
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
        $this->targetPath = base_path(config("servicerepo.target_repository_dir", "app/Repositories")) . "/$className.php";

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
