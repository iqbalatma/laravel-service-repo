<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Iqbalatma\LaravelServiceRepo\BaseRepository;
use Iqbalatma\LaravelServiceRepo\BaseRepositoryExtend;

trait RepositoryExtend
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public static function __callStatic($name, $arguments)
    {
        /** @var BaseRepository $instance */
        $instance = new static();
        if (!property_exists($instance, 'builder') || is_null($instance->builder)) {
            throw new \Exception("Property 'builder' does not exist or is not initialized.");
        }


        if (method_exists(new BaseRepositoryExtend($instance), $name)) {
            return ((new BaseRepositoryExtend($instance))->$name(...$arguments));
        }


        if (method_exists($instance, "query" . ucwords($name))) {
            return $instance->{"query" . ucwords($name)}(...$arguments);
        }

        return $instance->builder->$name(...$arguments);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (!property_exists($this, 'builder') || is_null($this->builder)) {
            throw new \Exception("Property 'builder' does not exist or is not initialized.");
        }

        if (method_exists(new BaseRepositoryExtend($this), $name)) {
            return (new BaseRepositoryExtend($this))->$name(...$arguments);
        }


        if (method_exists($this, "query" . ucwords($name))) {
            return $this->{"query" . ucwords($name)}(...$arguments);
        }

        return $this->builder->$name(...$arguments);
    }
}
