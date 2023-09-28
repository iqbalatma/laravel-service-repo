<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\RepositoryInterface;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryOverload;


/**
 * @method static getAllDataPaginated(array $whereClause = [], array $columns = ["*"]):LengthAwarePaginator
 * @method getAllDataPaginated(array $whereClause = [], array $columns = ["*"]):LengthAwarePaginator
 * @method static getAllData(array $whereClause = [], array $columns = ["*"]):Collection
 * @method getAllData(array $whereClause = [], array $columns = ["*"]):Collection
 * @method static Model|null|mixed getDataById(string|int|array $id, array $columns = ["*"])
 * @method Model|null|mixed getDataById(string|int|array $id, array $columns = ["*"])
 * @method static Model|null|mixed getSingleData(array $whereClause = [], array $columns = ["*"])
 * @method Model|null|mixed getSingleData(array $whereClause = [], array $columns = ["*"])
 * @method static Model|mixed addNewData(array $requestedData)
 * @method Model addNewData(array $requestedData)
 * @method static int|Collection|Model|null|mixed updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true)
 * @method int|Collection|Model|null|mixed updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true)
 * @method static Collection|int updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false)
 * @method Collection|int updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false):Collection|int
 * @method static bool deleteDataById(string|int $id)
 * @method bool deleteDataById(string|int $id)
 * @method static bool deleteDataByWhereClause(array $whereClause)
 * @method bool deleteDataByWhereClause(array $whereClause)
 * @method void function applyAdditionalFilterParams()
 * @method static BaseRepository orderColumn(array|string|null $orderableColumns = null, string $direction = "ASC")
 * @method BaseRepository orderColumn(array|string|null $orderableColumns = null, string $direction = "ASC")
 * @method static BaseRepository filterColumn(?array $filterableColumns = null, ?array $relationFilterableColumns = null)
 * @method BaseRepository filterColumn(?array $filterableColumns = null, ?array $relationFilterableColumns = null)
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
