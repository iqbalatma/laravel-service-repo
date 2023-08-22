<?php

namespace Iqbalatma\LaravelServiceRepo;

use App\Concerns\QueryExtend;
use App\Contracts\Abstracts\BaseQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\RepositoryInterface;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryExtend;


/**
 * @method static getAllDataPaginated(array $whereClause = [], array $columns = ["*"])
 * @method getAllDataPaginated(array $whereClause = [], array $columns = ["*"])
 * @method static getAllData(array $whereClause = [], array $columns = ["*"])
 * @method getAllData(array $whereClause = [], array $columns = ["*"])
 * @method static getDataById(string|int|array $id, array $columns = ["*"])
 * @method getDataById(string|int|array $id, array $columns = ["*"])
 * @method static getSingleData(array $whereClause = [], array $columns = ["*"])
 * @method getSingleData(array $whereClause = [], array $columns = ["*"])
 * @method static addNewData(array $requestedData)
 * @method addNewData(array $requestedData)
 * @method static updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true)
 * @method updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true)
 * @method static updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false)
 * @method updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false)
 * @method static deleteDataById(string|int $id)
 * @method deleteDataById(string|int $id)
 * @method static deleteDataByWhereClause(array $whereClause)
 * @method deleteDataByWhereClause(array $whereClause)
 * @method void function applyFilterParams()
 * @method static BaseRepository orderColumn(array|string|null $orderableColumns = null, string $direction = "ASC")
 * @method BaseRepository orderColumn(array|string|null $orderableColumns = null, string $direction = "ASC")
 * @method static BaseRepository filterColumn(?array $filterableColumns = null, ?array $relationFilterableColumns = null)
 * @method BaseRepository filterColumn(?array $filterableColumns = null, ?array $relationFilterableColumns = null)
 * @mixin RepositoryExtend
 *
 */
abstract class BaseRepository implements RepositoryInterface
{
    use RepositoryExtend;

    public Builder $builder;

    public function __construct(Builder $builder = null)
    {
        $this->builder = $builder ?? $this->getBaseQuery();
    }

    abstract public function getBaseQuery(): Builder;


    /**
     * @return Builder
     */
    public function build(): Builder
    {
        return $this->builder;
    }

    /**
     * use to implement custom filter param, call it on (for example RoleQuery) and override
     * @return void
     */
    public function applyAdditionalFilterParams(): void
    {

    }
}
