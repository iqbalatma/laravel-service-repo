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
        $path = $this->getSourceFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile();

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    /**
     * @return string
     */
    public function getStubPath():string
    {
        return __DIR__ . '/../Stubs/Service.stub';
    }


    /**
     * @return array
     */
    public function getStubVariables():array
    {
        $name = $this->getSingularClassName($this->argument('name'));

        $explodedClassName = explode("/", $name);
        $className = end($explodedClassName);


        $namespace = "";
        $explodedNamespace = explode("/", $name);
        if(count($explodedNamespace) > 1){
            array_pop($explodedNamespace);
            $namespace = "\\".implode("\\", $explodedNamespace);
        }

        return [
            'NAMESPACE'         => 'App\\Services'.$namespace,
            'CLASS_NAME'        => $className
        ];
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName($name):string
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile()
    {
        return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
    }

    /**
     * @param $stub
     * @param $stubVariables
     * @return array|false|string|string[]
     */
    public function getStubContents($stub , $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('$'.$search.'$' , $replace, $contents);
        }

        return $contents;
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public function getSourceFilePath()
    {
        return base_path('app/Services') .'/' .$this->getSingularClassName($this->argument('name')) . '.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
