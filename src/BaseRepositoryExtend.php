<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryFilter;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryOrder;

class BaseRepositoryExtend
{
    use RepositoryOrder {
        _orderColumn as private orderColumnTrait;
    }
    use RepositoryFilter {
        _filterColumn as private filterColumnTrait;
    }

    public Builder $builder;
    public BaseRepository $baseRepository;

    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
        $this->builder = $baseRepository->builder;
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
     * @return Collection|null
     */
    public function get(): Collection|null
    {
        return $this->builder->get();
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
     * @return BaseRepository
     */
    public function with(array|string $relations): BaseRepository
    {
        $this->builder->with($relations);
        return $this->baseRepository;
    }


    /**
     * @param array|string $relations
     * @return BaseRepository
     */
    public function without(array|string $relations): BaseRepository
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
     * @param \Closure|null $callback
     * @return BaseRepository
     */
    public function has(Relation|string $relation, string $operator = '>=', int $count = 1, string $boolean = 'and', \Closure|null $callback = null): BaseRepository
    {
        $this->builder->has($relation, $operator, $count, $boolean, $callback);
        return $this->baseRepository;
    }


    /**
     * @param string $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return BaseRepository
     */
    public function whereHas(string $relation, \Closure|null $callback = null, string $operator = '>=', int $count = 1): BaseRepository
    {
        $this->builder->whereHas($relation, $callback, $operator, $count);
        return $this->baseRepository;
    }


    /**
     * @param string $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return BaseRepository
     */
    public function orWhereHas(string $relation, \Closure|null $callback = null, string $operator = '>=', int $count = 1): BaseRepository
    {
        $this->builder->orWhereHas($relation, $callback, $operator, $count);
        return $this->baseRepository;
    }


    /**
     * @param array|string $column
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $boolean
     * @return BaseRepository
     */
    public function where(array|string $column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and')
    {
        $this->builder->where($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param array|string $column
     * @param string|null $operator
     * @param string|null $value
     * @return BaseRepository
     */
    public function orWhere(array|string $column, ?string $operator = null, ?string $value = null): BaseRepository
    {
        $this->builder->orWhere($column, $operator, $value);
        return $this->baseRepository;
    }


    /**
     * @param $column
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $boolean
     * @return BaseRepository
     */
    public function whereNot($column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNot($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereBetween(string $column, array $values, string $boolean = 'and', bool $not = false): BaseRepository
    {
        $this->builder->whereBetween($column, $values, $boolean, $not);
        return $this->baseRepository;
    }


    /**
     * @param string $column
     * @param array|string $values
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotBetween(string $column, array|string $values, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNotBetween($column, $values, $boolean);
        return $this->baseRepository;
    }

    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereBetweenColumns(string $column, array $values, string $boolean = 'and', bool $not = false): BaseRepository
    {
        $this->builder->whereBetweenColumns($column, $values, $boolean, $not);
        return $this->baseRepository;
    }


    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotBetweenColumns(string $column, array $values, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNotBetweenColumns($column, $values, $boolean);
        return $this->baseRepository;
    }

    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereIn(string $column, array $values, string $boolean = 'and', bool $not = false): BaseRepository
    {
        $this->builder->whereIn($column, $values, $boolean, $not);
        return $this->baseRepository;
    }

    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotIn(string $column, array $values, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNotIn($column, $values, $boolean);
        return $this->baseRepository;
    }

    /**
     * @param array|string $columns
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereNull(array|string $columns, string $boolean = 'and', bool $not = false): BaseRepository
    {
        $this->builder->whereNull($columns, $boolean, $not);
        return $this->baseRepository;
    }


    /**
     * @param string|array $columns
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotNull(string|array $columns, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereNotNull($columns, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereDate(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereDate($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereMonth(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereMonth($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }

    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereDay(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereDay($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereYear(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): BaseRepository
    {
        $this->builder->whereYear($column, $operator, $value, $boolean);
        return $this->baseRepository;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereTime(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): BaseRepository
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
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function getAllDataPaginated(array $whereClause = [], array $columns = ["*"])
    {
        return $this->builder
            ->select($columns)
            ->where($whereClause)
            ->paginate(15);
    }


    /**
     * @param array $whereClause
     * @param array $columns
     * @return Builder[]|Collection
     */
    public function getAllData(array $whereClause = [], array $columns = ["*"])
    {
        return $this->builder
            ->select($columns)
            ->where($whereClause)
            ->get();
    }


    /**
     * @param string|int|array $id
     * @param array $columns
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getDataById(string|int|array $id, array $columns = ["*"])
    {
        return $this->builder->select($columns)->find($id);
    }


    /**
     * @param array $whereClause
     * @param array $columns
     * @return Builder|Model|object|null
     */
    public function getSingleData(array $whereClause = [], array $columns = ["*"])
    {
        return $this->builder
            ->select($columns)
            ->where($whereClause)
            ->first();
    }


    /**
     * @param array $requestedData
     * @return Builder|Model
     */
    public function addNewData(array $requestedData)
    {
        return $this->builder->create($requestedData);
    }


    /**
     * @param string|int $id
     * @param array $requestedData
     * @param array $columns
     * @param bool $isReturnObject
     * @return Builder|Builder[]|Collection|Model|int|null
     */
    public function updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true)
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
     * @return Collection|int|null
     */
    public function updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false)
    {
        $updatedData = $this->builder
            ->where($whereClause)
            ->update($requestedData);
        if (!$isReturnObject) return $updatedData;

        return $this->getAllData($whereClause, $columns);
    }


    /**
     * @param string|int $id
     * @return mixed
     */
    public function deleteDataById(string|int $id)
    {
        return $this->builder
            ->where("id", $id)
            ->delete();
    }


    /**
     * @param array $whereClause
     * @return mixed
     */
    public function deleteDataByWhereClause(array $whereClause)
    {
        return $this->builder
            ->where($whereClause)
            ->delete();
    }
}