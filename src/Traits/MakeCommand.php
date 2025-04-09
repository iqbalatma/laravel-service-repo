<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\MakeCommandInterface;

trait MakeCommand
{
    private string $argumentName;
    private string $className;
    private string $targetPath;
    private string $filename;
    private string $namespace;
    private Filesystem $filesystem;

    /**
     * @return Command
     */
    public function getConsoleInstance(): Command
    {
        return $this;
    }

    /**
     * @return MakeCommand
     */
    private function setArgumentName(): static
    {
        $this->argumentName = ucwords($this->getConsoleInstance()->argument("name"));
        return $this;
    }

    /**
     * @return string
     */
    protected function getArgumentName(): string
    {
        return $this->argumentName;
    }

    /**
     * @return MakeCommand
     */
    private function setClassName(): static
    {
        $this->className = ucwords(last(explode("/", $this->getArgumentName())));
        return $this;
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $targetPath
     * @return MakeCommand
     */
    private function setTargetPath(string $targetPath): static
    {
        $this->targetPath = base_path($targetPath);

        /**
         * example: if argument only Role
         * it's meant no need to nest path
         * but if argument is nested, we will create new directory with nest path
         */
        if (($dirname = dirname($this->getArgumentName())) !== ".") {
            $dirname = ucwords($dirname);
            $this->targetPath .= "/$dirname";
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function getTargetPath(): string
    {
        return $this->targetPath;
    }

    /**
     * @return MakeCommand
     */
    private function setFilename(): static
    {
        $this->filename = $this->getTargetPath() . "/" . $this->getClassName() . ".php";
        return $this;
    }

    /**
     * @return string
     */
    protected function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $targetPath
     * @return MakeCommand
     */
    private function setNamespace(string $targetPath): static
    {
        $this->namespace = str_replace("/", "\\", Str::studly($targetPath));
        if (($dirname = dirname($this->getArgumentName())) !== ".") {
            $dirname = ucwords(str_replace("/", "\\", $dirname));
            $this->namespace .= "\\$dirname";
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @return MakeCommand
     */
    private function makeDirectory(): static
    {
        $this->filesystem = new Filesystem();
        if (!$this->filesystem->isDirectory($this->getTargetPath())) {
            $this->filesystem->makeDirectory($this->getTargetPath(), recursive: true);
        }
        return $this;
    }


    /**
     * @return void
     */
    protected function generateFromStub(): void
    {
        if (!$this->filesystem->exists($this->getFilename())) {
            $this->filesystem->put($this->getFilename(), $this->getStubContent());
            $this->info("Create " . $this->getClassName() . " successfully");
        } else {
            $this->error($this->className . " already exists");
        }
    }


    /**
     * @param string $targetPath
     * @return $this
     */
    protected function prepareMakeCommand(string $targetPath): static
    {
        if (!($this instanceof MakeCommandInterface)){
            $this->error("Generate file failed");
            $this->error("Class ". get_class($this) . " should implement " . MakeCommandInterface::class);
            die();
        }
        $this->setArgumentName()
            ->setClassName()
            ->setTargetPath($targetPath)
            ->setFilename()
            ->setNamespace($targetPath)
            ->makeDirectory();

        return $this;
    }
}
