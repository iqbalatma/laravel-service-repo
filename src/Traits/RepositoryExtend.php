<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait RepositoryExtend
{
    /**
     * Use to add with relation on model
     *
     * @param array|string $relations
     * @return BaseRepository
     */
    public function with(array|string $relations): self
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * @param array|string $relations
     * @return BaseRepository
     */
    public function without(array|string $relations): self
    {
        $this->model = $this->model->without($relations);
        return $this;
    }

    /**
     * @param array|string $relation
     * @param string $column
     * @return BaseRepository
     */
    public function withAvg(array|string $relation, string $column): self
    {
        $this->model = $this->model->withAvg($relation, $column);
        return $this;
    }


    /**
     * @param mixed $relations
     * @return BaseRepository
     */
    public function withCount(mixed $relations): self
    {
        $this->model = $this->model->withCount($relations);
        return $this;
    }


    /**
     * @param array|string $relation
     * @param string $column
     * @return BaseRepository
     */
    public function withMin(array|string $relation, string $column): self
    {
        $this->model = $this->model->withMin($relation, $column);
        return $this;
    }

    /**
     * @param array|string $relation
     * @param string $column
     * @return BaseRepository
     */
    public function withMax(array|string $relation, string $column): self
    {
        $this->model = $this->model->withMax($relation, $column);
        return $this;
    }


    /**
     * @param array|string $relation
     * @param string $column
     * @return BaseRepository
     */
    public function withSum(array|string $relation, string $column): self
    {
        $this->model = $this->model->withSum($relation, $column);
        return $this;
    }

    /**
     * @param Relation|string $relation
     * @param string $operator
     * @param int $count
     * @param string $boolean
     * @param \Closure|null $callback
     * @return BaseRepository
     */
    public function has(Relation|string $relation, string $operator = '>=', int $count = 1, string $boolean = 'and', \Closure|null $callback = null): self
    {
        $this->model = $this->model->has($relation, $operator, $count, $boolean, $callback);
        return $this;
    }


    /**
     * @param string $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return BaseRepository
     */
    public function whereHas(string $relation, \Closure|null $callback = null, string $operator = '>=', int $count = 1): self
    {
        $this->model = $this->model->whereHas($relation, $callback, $operator, $count);
        return $this;
    }

    /**
     * @param string $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return BaseRepository
     */
    public function orWhereHas(string $relation, \Closure|null $callback = null, string $operator = '>=', int $count = 1): self
    {
        $this->model = $this->model->orWhereHas($relation, $callback, $operator, $count);
        return $this;
    }


    /**
     * @param array|string $column
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $boolean
     * @return BaseRepository
     */
    public function where(array|string $column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and'): self
    {
        $this->model = $this->model->where($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param array|string $column
     * @param string|null $operator
     * @param string|null $value
     * @return BaseRepository
     */
    public function orWhere(array|string $column, ?string $operator = null, ?string $value = null): self
    {
        $this->model = $this->model->orWhere($column, $operator, $value);
        return $this;
    }

    /**
     * @param array|string $column
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $boolean
     * @return BaseRepository
     */
    public function whereNot(array|string $column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and'): self
    {
        $this->model = $this->model->whereNot($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereBetween(string $column, array $values, string $boolean = 'and', bool $not = false): self
    {
        $this->model = $this->model->whereBetween($column, $values, $boolean, $not);
        return $this;
    }


    /**
     * @param string $column
     * @param string|array $values
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotBetween(string $column, array|string $values, string $boolean = 'and'): self
    {
        $this->model = $this->model->whereNotBetween($column, $values, $boolean);
        return $this;
    }

    /**
     * @param string $column
     * @param array|string $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereBetweenColumns(string $column, array $values, string $boolean = 'and', bool $not = false): self
    {
        $this->model = $this->model->whereBetweenColumns($column, $values, $boolean, $not);
        return $this;
    }


    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotBetweenColumns(string $column, array $values, string $boolean = 'and'): self
    {
        $this->model = $this->model->whereNotBetweenColumns($column, $values, $boolean);
        return $this;
    }

    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereIn(string $column, array $values, string $boolean = 'and', bool $not = false): self
    {
        $this->model = $this->model->whereIn($column, $values, $boolean, $not);
        return $this;
    }

    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotIn(string $column, array $values, string $boolean = 'and'): self
    {
        $this->model = $this->model->whereNotIn($column, $values, $boolean);
        return $this;
    }


    /**
     * @param array|string $columns
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereNull(array|string $columns, string $boolean = 'and', bool $not = false): self
    {
        $this->model = $this->model->whereNull($columns, $boolean, $not);
        return $this;
    }


    /**
     * @param string|array $columns
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotNull(string|array $columns, string $boolean = 'and'): self
    {
        $this->model = $this->model->whereNotNull($columns, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereDate(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->model = $this->model->whereDate($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereMonth(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->model = $this->model->whereMonth($column, $operator, $value, $boolean);
        return $this;
    }

    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereDay(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->model = $this->model->whereDay($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereYear(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->model = $this->model->whereYear($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereTime(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->model = $this->model->whereTime($column, $operator, $value, $boolean);
        return $this;
    }

    /**
     * @param array|string $first
     * @param string|null $operator
     * @param string|null $second
     * @param string|null $boolean
     * @return BaseRepository
     */
    public function whereColumn(array|string $first, ?string $operator = null, ?string $second = null, ?string $boolean = 'and'): self
    {
        $this->model = $this->model->whereColumn($first, $operator, $second, $boolean);
        return $this;
    }

    /**
     * @param array|string $first
     * @param string|null $operator
     * @param string|null $second
     * @return BaseRepository
     */
    public function orWhereColumn(array|string $first, ?string $operator = null, ?string $second = null): self
    {
        $this->model = $this->model->orWhereColumn($first, $operator, $second);
        return $this;
    }
}
