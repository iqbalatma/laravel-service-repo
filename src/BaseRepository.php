<?php

namespace Iqbalatma\LaravelServiceRepo;

use Closure;
use DateTimeInterface;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\RepositoryInterface;
use Iqbalatma\LaravelServiceRepo\Traits\Repositories\RepositoryOverload;


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
 * @method static Collection|null get(array|string $columns = ['*'])
 * @method Collection|null get(array|string $columns = ['*'])
 * @method static int update(array $requestedData)
 * @method int update(array $requestedData)
 * @method static int delete()
 * @method int delete()
 * @method static BaseRepository with(array|string $relations, Closure|null|string $callback = null)
 * @method BaseRepository with(array|string $relations, Closure|null|string $callback = null)
 * @method static BaseRepository without(mixed $relations)
 * @method BaseRepository without(mixed $relations)
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
 * @method static BaseRepository where(array|Closure|Expression|string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method BaseRepository where(array|Closure|Expression|string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static BaseRepository orWhere(array|Closure|Expression|string $column, mixed $operator = null, mixed $value = null)
 * @method BaseRepository orWhere(array|Closure|Expression|string $column, mixed $operator = null, mixed $value = null)
 * @method static BaseRepository whereNot(array|Closure|Expression|string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method BaseRepository whereNot(array|Closure|Expression|string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static BaseRepository whereBetween(Expression|string $column, iterable $values, string $boolean = 'and', bool $not = false)
 * @method BaseRepository whereBetween(Expression|string $column, iterable $values, string $boolean = 'and', bool $not = false)
 * @method static BaseRepository whereNotBetween(Expression|string $column, iterable $values, string $boolean = 'and')
 * @method BaseRepository whereNotBetween(Expression|string $column, iterable $values, string $boolean = 'and')
 * @method static BaseRepository whereBetweenColumns(Expression|string $column, array $values, string $boolean = 'and', bool $not = false)
 * @method BaseRepository whereBetweenColumns(Expression|string $column, array $values, string $boolean = 'and', bool $not = false)
 * @method static BaseRepository whereNotBetweenColumns(Expression|string $column, array $values, string $boolean = 'and')
 * @method BaseRepository whereNotBetweenColumns(Expression|string $column, array $values, string $boolean = 'and')
 * @method static BaseRepository whereIn(Expression|string $column, mixed $values, string $boolean = 'and', bool $not = false)
 * @method BaseRepository whereIn(Expression|string $column, mixed $values, string $boolean = 'and', bool $not = false)
 * @method static BaseRepository whereNotIn(Expression|string $column, mixed $values, string $boolean = 'and')
 * @method BaseRepository whereNotIn(Expression|string $column, mixed $values, string $boolean = 'and')
 * @method static BaseRepository whereNull(array|Expression|string $columns, string $boolean = 'and', bool $not = false)
 * @method BaseRepository whereNull(array|Expression|string $columns, string $boolean = 'and', bool $not = false)
 * @method static BaseRepository whereNotNull(string|array $columns, string $boolean = 'and')
 * @method BaseRepository whereNotNull(string|array $columns, string $boolean = 'and')
 * @method static BaseRepository whereDate(Expression|string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereDate(Expression|string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereMonth(Expression|string $column, string $operator, DateTimeInterface|int|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereMonth(Expression|string $column, string $operator, DateTimeInterface|int|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereDay(Expression|string $column, string $operator, DateTimeInterface|int|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereDay(Expression|string $column, string $operator, DateTimeInterface|int|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereYear(Expression|string $column, string $operator, DateTimeInterface|int|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereYear(Expression|string $column, string $operator, DateTimeInterface|int|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereTime(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method BaseRepository whereTime(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and')
 * @method static BaseRepository whereColumn(array|string $first, ?string $operator = null, ?string $second = null, ?string $boolean = 'and')
 * @method BaseRepository whereColumn(array|string $first, ?string $operator = null, ?string $second = null, ?string $boolean = 'and')
 * @method static BaseRepository orWhereColumn(array|string $first, ?string $operator = null, ?string $second = null)
 * @method BaseRepository orWhereColumn(array|string $first, ?string $operator = null, ?string $second = null)
 * @method static int getPerPage()
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
