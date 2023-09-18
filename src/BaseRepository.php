<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Database\Eloquent\Builder;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\RepositoryInterface;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryOverload;


/**
 * @method static getAllDataPaginated(array $whereClause = [], array $columns = ["*"]):LengthAwarePaginator
 * @method getAllDataPaginated(array $whereClause = [], array $columns = ["*"]):LengthAwarePaginator
 * @method static getAllData(array $whereClause = [], array $columns = ["*"]):Collection
 * @method getAllData(array $whereClause = [], array $columns = ["*"]):Collection
 * @method static getDataById(string|int|array $id, array $columns = ["*"]):Model|null
 * @method getDataById(string|int|array $id, array $columns = ["*"]):Model|null
 * @method static getSingleData(array $whereClause = [], array $columns = ["*"]):Model|null
 * @method getSingleData(array $whereClause = [], array $columns = ["*"]):Model|null
 * @method static addNewData(array $requestedData):Builder|Model
 * @method addNewData(array $requestedData):Builder|Model
 * @method static updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true):int|Collection|Model|null
 * @method updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true):int|Collection|Model|null
 * @method static updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false):Collection|int
 * @method updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false):Collection|int
 * @method static deleteDataById(string|int $id):bool
 * @method deleteDataById(string|int $id):bool
 * @method static deleteDataByWhereClause(array $whereClause):bool
 * @method deleteDataByWhereClause(array $whereClause):bool
 * @method void function applyAdditionalFilterParams()
 * @method static BaseRepository orderColumn(array|string|null $orderableColumns = null, string $direction = "ASC"):BaseRepository
 * @method BaseRepository orderColumn(array|string|null $orderableColumns = null, string $direction = "ASC"):BaseRepository
 * @method static BaseRepository filterColumn(?array $filterableColumns = null, ?array $relationFilterableColumns = null):BaseRepository
 * @method BaseRepository filterColumn(?array $filterableColumns = null, ?array $relationFilterableColumns = null):BaseRepository
 * @mixin RepositoryOverload
 *
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
