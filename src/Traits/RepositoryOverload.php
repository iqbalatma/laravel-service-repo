<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Exception;
use Iqbalatma\LaravelServiceRepo\BaseRepository;
use Iqbalatma\LaravelServiceRepo\BaseRepositoryExtend;

trait RepositoryOverload
{
    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic(string $name, array $arguments)
    {
        /** @var BaseRepository $instance */
        $instance = new static();
        return $instance->overload($name, $arguments);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        return $this->overload($name, $arguments);
    }


    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    private function overload(string $name, array $arguments): mixed
    {
        /**
         * @note
         * Make sure that Iqbalatma\LaravelServiceRepo\BaseRepository child implement getBaseQuery() method and returning builder
         * So construct on BaseRepository will set property builder and make sure it's not null
         */
        if (!property_exists($this, 'builder')) {
            throw new \RuntimeException("Property 'builder' does not exist or is not initialized.");
        }

        $baseRepositoryExtend = new BaseRepositoryExtend($this);

        /**
         * @note
         * This overload will search method on Iqbalatma\LaravelServiceRepo\BaseRepositoryExtend
         * So this will look for predefined method on BaseRepository extend
         * Example: getAllData(), getAllDataPaginated(), etc
         */
        if (method_exists($baseRepositoryExtend, $name)) {
            return $baseRepositoryExtend->$name(...$arguments);
        }


        /**
         * @note
         * This overload will handle use case when you need to call scope method on model
         * From query builder we can get model instance and check scope via this instance
         * On laravel, scope convention is start with prefix 'scope'
         *
         * we call forward scope so when this scope called via repository extend, we still can chain method after scoping
         * Example:
         * we have model Role with method scopeSuperadmin
         * So we can just call it with RoleRepository::superadmin()->getAllData()
         * Because scopeSuperadmin is called via forwardScope method that doing method chaining after scope is called
         */
        if (method_exists($baseRepositoryExtend->builder->getModel(), "scope" . ucwords($name))) {
            return $baseRepositoryExtend->forwardScope("scope" . ucwords($name), $arguments);
        }


        /**
         * @note
         * This is to overload method predefined query on Repository
         * RoleRepository that extend BaseRepository can create queryGetLatestDataRole() method
         * Service can call this method via RoleRepository::getLatestDataRole
         * When user call RoleRepository::getLatestDataRole in background class will look for queryGetLatestDataRole() method
         */
        if (method_exists($this, "query" . ucwords($name))) {
            return $this->{"query" . ucwords($name)}(...$arguments);
        }


        /**
         * @note
         * When all of overloading mechanism above is not fulfill we will call method from QueryBuilder
         * If method does not exist in QueryBuilder, it will throw an exception. It's mean method does not exist
         */
        return $this->builder->$name(...$arguments);
    }
}
