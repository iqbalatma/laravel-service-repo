<?php

namespace Iqbalatma\LaravelServiceRepo;

use Closure;
use DateTimeInterface;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Iqbalatma\LaravelServiceRepo\Traits\Repositories\RepositoryFilter;
use Iqbalatma\LaravelServiceRepo\Traits\Repositories\RepositoryOrder;

class BaseRepositoryExtend
{
    use RepositoryOrder {
        RepositoryOrder::_orderColumn as private orderColumnTrait;
    }
    use RepositoryFilter {
        RepositoryFilter::_filterColumn as private filterColumnTrait;
    }

    public Builder $builder;
    public BaseRepository $baseRepository;

    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
        $this->builder = $baseRepository->builder;
    }

    /**
     * @return int
     */
    public static function getPerPage(): int
    {
        return request()->query(config("servicerepo.perpage.key"), config('servicerepo.perpage.value'));
    }

    /**
     * @param array|null $filterableColumns
     * @param array|null $relationFilterableColumns
     * @return BaseRepository
     */
    public function filterColumn(?array $filterableColumns = null, ?array $relationFilterableColumns = null): BaseRepository
    {
        $this->filterColumnTrait($filterableColumns, $relationFilterableColumns);
        $this->baseRepository->applyAdditionalFilterParams();

        return $this->baseRepository;
    }


    /**
     * @param array|string|null $orderableColumns
     * @param string $direction
     * @return BaseRepository
     */
    public function orderColumn(array|string|null $orderableColumns = null, string $direction = "ASC"): BaseRepository
    {
        $this->orderColumnTrait($orderableColumns, $direction);
        return $this->baseRepository;
    }


    /**
     * @note Use call method scope on model instance
     * @param $name
     * @param $arguments
     * @return BaseRepository
     */
    public function forwardScope($name, $arguments): BaseRepository
    {
        $this->builder->getModel()->$name($this->builder, ...$arguments);
        return $this->baseRepository;
    }


    /**
     * @param array|string $columns
     * @return Collection|null
     */
    public function get(array|string $columns = ['*']): Collection|null
    {
        return $this->builder->get($columns);
    }

    /**
     * @param array $requestedData
     * @return int
     */
    public function update(array $requestedData): int
    {
        return $this->builder->update($requestedData);
    }

    /**
     * @return int
     */
    public function delete(): int
    {
        return $this->builder->delete();
    }

    /**
     * @param array|string $relations
     * @param Closure|string|null $callback
     * @return BaseRepository
     */
    public function with(array|string $relations, Closure|null|string $callback = null): BaseRepository
    {
        if (is_null($callback)) {
            $this->builder->with($relations);
        } else {
            $this->builder->with($relations, $callback);
        }
        return $this->baseRepository;
    }


    /**
     * @param mixed $relations
     * @return BaseRepository
     */
    public function without(mixed $relations): BaseRepository
    {
        $this->builder->without($relations);
        return $this->baseRepository;
    }

    /**
     * @param array|string $relation
     * @param string $column
     * @return BaseRepository
     */
    public function withAvg(array|string $relation, string $column): BaseRepository
    {
        $this->builder->withAvg($relation, $column);
        return $this->baseRepository;
    }


    /**
     * @param mixed $relations
     * @return BaseRepository
     */
    public function withCount(mixed $relations): BaseRepository
    {
        $this->builder->withCount($relations);
        return $this->baseRepository;
    }


    /**
     * @param array|string $relation
     * @param string $column
     * @return BaseRepository
     */
    public function withMin(array|string $relation, string $column): BaseRepository
    {
        $this->builder->withMin($relation, $column);
        return $this->baseRepository;
    }


    /**
     * @param array|string $relation
     * @param string $column
     * @return BaseRepository
     */
    public function withMax(array|string $relation, string $column): BaseRepository
    {
        $this->builder->withMax($relation, $column);
        return $this->baseRepository;
    }


    /**
     * @param array|string $relation
     * @param string $column
     * @return BaseRepository
     */
    public function withSum(array|string $relation, string $column): BaseRepository
    {
        $this->builder->withSum($relation, $column);
        return $this->baseRepository;
    }

    /**
     * @param Relation|string $relation
     * @param string $operator
     * @param int $count
     * @param string $boolean
     * @param Closure|null $callback
     * @return BaseRepository
     */
    public function has(Relation|string $relation, string $operator = '>=', int $count = 1, string $boolean = 'and', Closure|null $callback = null): BaseRepository
    {
        $this->builder->has($relation, $operator, $count, $boolean, $callback);
        return $this->baseRepository;
    }


    /**
     * @param string $relation
     * @param Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return BaseRepository
     */
    public function whereHas(string $relation, Closure|null $callback = null, string $operator = '>=', int $count = 1): BaseRepository
    {
        $this->builder->whereHas($relation, $callback, $operator, $count);
        return $this->baseRepository;
    }


    /**
     * @param string $relation
     * @param Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return BaseRepository
     */
    public function orWhereHas(string $relation, Closure|null $callback = null, string $operator = '>=', int $count = 1): BaseRepository
    {
        $this->builder->orWhereHas($relation, $callback, $operator, $count);
        return $this->baseRepository;
    }


    /**
     * @param array|Closure|Expression|string $column
     * @param mixed $operator
     * @param mixed $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function where(array|Closure|Expression|string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->where($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param array|Closure|Expression|string $column
     * @param mixed $operator
     * @param mixed $value
     * @return BaseRepository
     */
    public function orWhere(array|Closure|Expression|string $column, mixed $operator = null, mixed $value = null): BaseRepository
    {
        $this->builder->orWhere($column, $operator, $value);
        return $this->baseRepository;
    }


    /**
     * @param array|Closure|Expression|string $column
     * @param string|null $operator
     * @param mixed $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNot(array|Closure|Expression|string $column, mixed $operator = null, mixed $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNot($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param Expression|string $column
     * @param iterable $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereBetween(Expression|string $column, iterable $values, string $boolean = 'and', bool $not = false): BaseRepository
    {
        $this->builder->whereBetween($column, $values, $boolean, $not);
        return $this->baseRepository;
    }


    /**
     * @param Expression|string $column
     * @param iterable $values
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotBetween(Expression|string $column, iterable $values, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNotBetween($column, $values, $boolean);
        return $this->baseRepository;
    }

    /**
     * @param Expression|string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereBetweenColumns(Expression|string $column, array $values, string $boolean = 'and', bool $not = false): BaseRepository
    {
        $this->builder->whereBetweenColumns($column, $values, $boolean, $not);
        return $this->baseRepository;
    }

    /**
     * @param Expression|string $column
     * @param array $values
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotBetweenColumns(Expression|string $column, array $values, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNotBetweenColumns($column, $values, $boolean);
        return $this->baseRepository;
    }

    /**
     * @param Expression|string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereIn(Expression|string $column, mixed $values, string $boolean = 'and', bool $not = false): BaseRepository
    {
        $this->builder->whereIn($column, $values, $boolean, $not);
        return $this->baseRepository;
    }

    /**
     * @param Expression|string $column
     * @param mixed $values
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotIn(Expression|string $column, mixed $values, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNotIn($column, $values, $boolean);
        return $this->baseRepository;
    }

    /**
     * @param array|Expression|string $columns
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereNull(array|Expression|string $columns, string $boolean = 'and', bool $not = false): BaseRepository
    {
        $this->builder->whereNull($columns, $boolean, $not);
        return $this->baseRepository;
    }


    /**
     * @param string|Expression|array $columns
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotNull(string|Expression|array $columns, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNotNull($columns, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param Expression|string $column
     * @param string $operator
     * @param DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereDate(Expression|string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereDate($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param Expression|string $column
     * @param string $operator
     * @param DateTimeInterface|int|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereMonth(Expression|string $column, string $operator, DateTimeInterface|int|string|null $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereMonth($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }

    /**
     * @param Expression|string $column
     * @param string $operator
     * @param DateTimeInterface|string|int|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereDay(Expression|string $column, string $operator, DateTimeInterface|int|string|null $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereDay($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param Expression|string $column
     * @param string $operator
     * @param DateTimeInterface|int|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereYear(Expression|string $column, string $operator, DateTimeInterface|int|string|null $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereYear($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereTime(string $column, string $operator, DateTimeInterface|string|null $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereTime($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param array|string $first
     * @param string|null $operator
     * @param string|null $second
     * @param string|null $boolean
     * @return BaseRepository
     */
    public function whereColumn(array|string $first, ?string $operator = null, ?string $second = null, ?string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereColumn($first, $operator, $second, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param array|string $first
     * @param string|null $operator
     * @param string|null $second
     * @return BaseRepository
     */
    public function orWhereColumn(array|string $first, ?string $operator = null, ?string $second = null): BaseRepository
    {
        $this->builder->orWhereColumn($first, $operator, $second);
        return $this->baseRepository;
    }


    /**
     * @param array $whereClause
     * @param array|null $columns
     * @param int|null $perPage
     * @return LengthAwarePaginator
     */
    public function getAllDataPaginated(array $whereClause = [], array|null $columns = null, ?int $perPage = null): LengthAwarePaginator
    {
        if (!$perPage) {
            $perPage = self::getPerPage();
        }

        if ($columns) {
            $this->builder->addSelect($columns);
        }

        return $this->builder->where($whereClause)->paginate($perPage);
    }

    /**
     * @param array $whereClause
     * @param array|null $columns
     * @return Collection
     */
    public function getAllData(array $whereClause = [], array|null $columns = null): Collection
    {
        if ($columns) {
            $this->builder->addSelect($columns);
        }
        return $this->builder
            ->where($whereClause)
            ->get();
    }


    /**
     * @param string|int|array $id
     * @param array|null $columns
     * @return Model|null
     */
    public function getDataById(string|int|array $id, array|null $columns = null): Model|null
    {
        if ($columns) {
            $this->builder->addSelect($columns);
        }
        return $this->builder->find($id);
    }


    /**
     * @param array $whereClause
     * @param array|null $columns
     * @return Model|null
     */
    public function getSingleData(array $whereClause = [], array|null $columns = null): Model|null
    {
        if ($columns) {
            $this->builder->addSelect($columns);
        }
        return $this->builder
            ->where($whereClause)
            ->first();
    }


    /**
     * @param array $requestedData
     * @return Model
     */
    public function addNewData(array $requestedData): Model
    {
        return $this->builder->create($requestedData);
    }


    /**
     * @param string|int $id
     * @param array $requestedData
     * @param array $columns
     * @param bool $isReturnObject
     * @return int|Collection|Model|null
     */
    public function updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true): int|Collection|Model|null
    {
        $updatedData = $this->builder
            ->where("id", $id)
            ->update($requestedData);
        if (!$isReturnObject) return $updatedData;

        return $this->builder->find($id, $columns);
    }


    /**
     * @param array $whereClause
     * @param array $requestedData
     * @param array $columns
     * @param bool $isReturnObject
     * @return Collection|int
     */
    public function updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false): Collection|int
    {
        $updatedData = $this->builder
            ->where($whereClause)
            ->update($requestedData);
        if (!$isReturnObject) return $updatedData;

        return $this->getAllData($whereClause, $columns);
    }


    /**
     * @param string|int $id
     * @return bool
     */
    public function deleteDataById(string|int $id): bool
    {
        return $this->builder
            ->where("id", $id)
            ->delete();
    }


    /**
     * @param array $whereClause
     * @return bool
     */
    public function deleteDataByWhereClause(array $whereClause): bool
    {
        return $this->builder
            ->where($whereClause)
            ->delete();
    }
}
