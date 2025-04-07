<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Database\Eloquent\Builder;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\RepositoryInterface;
use Iqbalatma\LaravelServiceRepo\Traits\Repositories\RepositoryOverload;


/**
 * @mixin BaseRepositoryExtend
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @note use to overloading method from BaseRepositoryExtend
     */
    use RepositoryOverload;

    public Builder $builder;

    public function __construct(Builder $builder = null)
    {
        $this->builder = $builder ?? $this->getBaseQuery();
    }


    /**
     * @note use get set builder instance via model
     * @return Builder
     */
    abstract public function getBaseQuery(): Builder;


    /**
     * @note use to get QueryBuilder instance
     * @return Builder
     */
    public function build(): Builder
    {
        return $this->builder;
    }


    /**
     * @note use to create instance via static method
     * @return BaseRepository
     * @example RoleRepository::init()->getAllDataPaginated();
     */
    public static function init(): BaseRepository
    {
        return new static();
    }

    /**
     * @note use to implement custom filter param, call it on (for example RoleQuery) and override
     * @return void
     */
    public function applyAdditionalFilterParams(): void
    {

    }
}
