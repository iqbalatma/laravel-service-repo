<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Exception;
use Iqbalatma\LaravelServiceRepo\BaseRepository;
use Iqbalatma\LaravelServiceRepo\BaseRepositoryExtend;

trait RepositoryExtend
{
    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        /**
         * @note
         * Make sure that Iqbalatma\LaravelServiceRepo\BaseRepository child implement getBaseQuery() method and returning builder
         * So construct on BaseRepository will set property builder and make sure it's not null
         */
        /** @var BaseRepository $instance */
        $instance = new static();
        if (!property_exists($instance, 'builder')) {
            throw new Exception("Property 'builder' does not exist or is not initialized.");
        }

        $baseRepositoryExtend = new BaseRepositoryExtend($instance);

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
        if (method_exists($baseRepositoryExtend->builder->getModel(), "scope".ucwords($name))) {
            return $baseRepositoryExtend->forwardScope("scope".ucwords($name),$arguments);
        }


        /**
         * @note
         * This is to overload method predefined query on Repository
         * RoleRepository that extend BaseRepository can create queryGetLatestDataRole() method
         * Service can call this method via RoleRepository::getLatestDataRole
         * When user call RoleRepository::getLatestDataRole in background class will look for queryGetLatestDataRole() method
         */
        if (method_exists($instance, "query" . ucwords($name))) {
            return $instance->{"query" . ucwords($name)}(...$arguments);
        }

        return $instance->builder->$name(...$arguments);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        /**
         * @note
         * Make sure that Iqbalatma\LaravelServiceRepo\BaseRepository child implement getBaseQuery() method and returning builder
         * So construct on BaseRepository will set property builder and make sure it's not null
         */
        if (!property_exists($this, 'builder')) {
            throw new Exception("Property 'builder' does not exist or is not initialized.");
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
        if (method_exists($baseRepositoryExtend->builder->getModel(), "scope".ucwords($name))) {
            return $baseRepositoryExtend->forwardScope("scope".ucwords($name),$arguments);
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

        return $this->builder->$name(...$arguments);
    }
}
