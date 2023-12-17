<?php

namespace Iqbalatma\LaravelServiceRepo;

use Closure;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\RepositoryInterface;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryOverload;


/**
 * @method static getAllDataPaginated(array $whereClause = [], array|null $columns = ["*"], ?int $perPage = null): LengthAwarePaginator
 * @method getAllDataPaginated(array $whereClause = [], array|null $columns = ["*"], ?int $perPage = null): LengthAwarePaginator
 * @method static getAllData(array $whereClause = [], array|null $columns = ["*"]):Collection
 * @method getAllData(array $whereClause = [], array|null $columns = ["*"]):Collection
 * @method static Model|null|mixed getDataById(string|int|array $id, array|null $columns = ["*"])
 * @method Model|null|mixed getDataById(string|int|array $id, array|null $columns = ["*"])
 * @method static Model|null|mixed getSingleData(array $whereClause = [], array|null $columns = ["*"])
 * @method Model|null|mixed getSingleData(array $whereClause = [], array|null $columns = ["*"])
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
 * @method static Collection|null get()
 * @method Collection|null get()
 * @method static int update(array $requestedData)
 * @method int update(array $requestedData)
 * @method static int delete()
 * @method int delete()
 * @method static BaseRepository with(array|string $relations)
 * @method BaseRepository with(array|string $relations)
 * @method static BaseRepository without(array|string $relations)
 * @method BaseRepository without(array|string $relations)
 * @method static BaseRepository withAvg(array|string $relation, string $column)
 * @method BaseRepository withAvg(array|string $relation, string $column)
 * @method static BaseRepository withCount(mixed $relations)
 * @method BaseRepository withCount(mixed $relations)
 * @method static BaseRepository withMin(array|string $relation, string $column)
 * @method BaseRepository withMin(array|string $relation, string $column)
 * @method static BaseRepository withMax(array|string $relation, string $column)
 * @method BaseRepository withMax(array|string $relation, string $column)
 * @method static BaseRepository withSum(array|string $relation, string $column)
 * @method BaseRepository withSum(array|string $relation, string $column)
 * @method static BaseRepository has(Relation|string $relation, string $operator = '>=', int $count = 1, string $boolean = 'and', Closure|null $callback = null)
 * @method BaseRepository has(Relation|string $relation, string $operator = '>=', int $count = 1, string $boolean = 'and', Closure|null $callback = null)
 * @method static BaseRepository whereHas(string $relation, Closure|null $callback = null, string $operator = '>=', int $count = 1)
 * @method BaseRepository whereHas(string $relation, Closure|null $callback = null, string $operator = '>=', int $count = 1)
 * @method static BaseRepository orWhereHas(string $relation, Closure|null $callback = null, string $operator = '>=', int $count = 1)
 * @method BaseRepository orWhereHas(string $relation, Closure|null $callback = null, string $operator = '>=', int $count = 1)
 * @method static BaseRepository where(array|string $column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and')
 * @method BaseRepository where(array|string $column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and')
 * @method static BaseRepository orWhere(array|string $column, ?string $operator = null, ?string $value = null)
 * @method BaseRepository orWhere(array|string $column, ?string $operator = null, ?string $value = null)
 * @method static BaseRepository whereNot($column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and')
 * @method BaseRepository whereNot($column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and')
 * @method static BaseRepository whereBetween(string $column, array $values, string $boolean = 'and', bool $not = false)
 * @method BaseRepository whereBetween(string $column, array $values, string $boolean = 'and', bool $not = false)
 * @method static BaseRepository whereNotBetween(string $column, array|string $values, string $boolean = 'and')
 * @method BaseRepository whereNotBetween(string $column, array|string $values, string $boolean = 'and')
 * @method static BaseRepository whereBetweenColumns(string $column, array $values, string $boolean = 'and', bool $not = false)
 * @method BaseRepository whereBetweenColumns(string $column, array $values, string $boolean = 'and', bool $not = false)
 * @method static BaseRepository whereNotBetweenColumns(string $column, array $values, string $boolean = 'and')
 * @method BaseRepository whereNotBetweenColumns(string $column, array $values, string $boolean = 'and')
 * @method static BaseRepository whereIn(string $column, array $values, string $boolean = 'and', bool $not = false)
 * @method BaseRepository whereIn(string $column, array $values, string $boolean = 'and', bool $not = false)
 * @method static BaseRepository whereNotIn(string $column, array $values, string $boolean = 'and')
 * @method BaseRepository whereNotIn(string $column, array $values, string $boolean = 'and')
 * @method static BaseRepository whereNull(array|string $columns, string $boolean = 'and', bool $not = false)
 * @method BaseRepository whereNull(array|string $columns, string $boolean = 'and', bool $not = false)
 * @method static BaseRepository whereNotNull(string|array $columns, string $boolean = 'and')
 * @method BaseRepository whereNotNull(string|array $columns, string $boolean = 'and')
 * @method static BaseRepository whereDate(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereDate(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereMonth(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereMonth(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereDay(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereDay(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereYear(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereYear(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereTime(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereTime(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereColumn(array|string $first, ?string $operator = null, ?string $second = null, ?string $boolean = 'and')
 * @method BaseRepository whereColumn(array|string $first, ?string $operator = null, ?string $second = null, ?string $boolean = 'and')
 * @method static BaseRepository orWhereColumn(array|string $first, ?string $operator = null, ?string $second = null)
 * @method BaseRepository orWhereColumn(array|string $first, ?string $operator = null, ?string $second = null)
 *
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
