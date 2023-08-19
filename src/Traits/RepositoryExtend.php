<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait RepositoryExtend
{
    /**
     * @param array|string $relations
     * @return RepositoryExtend|BaseRepository
     */
    public function with(array|string $relations): self
    {
        $this->query->with($relations);
        return $this;
    }


    /**
     * @param array|string $relations
     * @return RepositoryExtend|BaseRepository
     */
    public function without(array|string $relations): self
    {
        $this->query->without($relations);
        return $this;
    }

    /**
     * @param array|string $relation
     * @param string $column
     * @return RepositoryExtend|BaseRepository
     */
    public function withAvg(array|string $relation, string $column): self
    {
        $this->query->withAvg($relation, $column);
        return $this;
    }


    /**
     * @param mixed $relations
     * @return RepositoryExtend|BaseRepository
     */
    public function withCount(mixed $relations): self
    {
        $this->query->withCount($relations);
        return $this;
    }


    /**
     * @param array|string $relation
     * @param string $column
     * @return RepositoryExtend|BaseRepository
     */
    public function withMin(array|string $relation, string $column): self
    {
        $this->query->withMin($relation, $column);
        return $this;
    }


    /**
     * @param array|string $relation
     * @param string $column
     * @return RepositoryExtend|BaseRepository
     */
    public function withMax(array|string $relation, string $column): self
    {
        $this->query->withMax($relation, $column);
        return $this;
    }


    /**
     * @param array|string $relation
     * @param string $column
     * @return RepositoryExtend|BaseRepository
     */
    public function withSum(array|string $relation, string $column): self
    {
        $this->query->withSum($relation, $column);
        return $this;
    }

    /**
     * @param Relation|string $relation
     * @param string $operator
     * @param int $count
     * @param string $boolean
     * @param \Closure|null $callback
     * @return RepositoryExtend|BaseRepository
     */
    public function has(Relation|string $relation, string $operator = '>=', int $count = 1, string $boolean = 'and', \Closure|null $callback = null): self
    {
        $this->query->has($relation, $operator, $count, $boolean, $callback);
        return $this;
    }


    /**
     * @param string $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return RepositoryExtend|BaseRepository
     */
    public function whereHas(string $relation, \Closure|null $callback = null, string $operator = '>=', int $count = 1): self
    {
        $this->query->whereHas($relation, $callback, $operator, $count);
        return $this;
    }


    /**
     * @param string $relation
     * @param \Closure|null $callback
     * @param string $operator
     * @param int $count
     * @return RepositoryExtend|BaseRepository
     */
    public function orWhereHas(string $relation, \Closure|null $callback = null, string $operator = '>=', int $count = 1): self
    {
        $this->query->orWhereHas($relation, $callback, $operator, $count);
        return $this;
    }


    /**
     * @param array|string $column
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function where(array|string $column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and'): self
    {
        $this->query->where($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param array|string $column
     * @param string|null $operator
     * @param string|null $value
     * @return RepositoryExtend|BaseRepository
     */
    public function orWhere(array|string $column, ?string $operator = null, ?string $value = null): self
    {
        $this->query->orWhere($column, $operator, $value);
        return $this;
    }


    /**
     * @param array|string $column
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereNot(array|string $column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and'): self
    {
        $this->query->whereNot($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return RepositoryExtend|BaseRepository
     */
    public function whereBetween(string $column, array $values, string $boolean = 'and', bool $not = false): self
    {
        $this->query->whereBetween($column, $values, $boolean, $not);
        return $this;
    }


    /**
     * @param string $column
     * @param array|string $values
     * @param string $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereNotBetween(string $column, array|string $values, string $boolean = 'and'): self
    {
        $this->query->whereNotBetween($column, $values, $boolean);
        return $this;
    }

    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return RepositoryExtend|BaseRepository
     */
    public function whereBetweenColumns(string $column, array $values, string $boolean = 'and', bool $not = false): self
    {
        $this->query->whereBetweenColumns($column, $values, $boolean, $not);
        return $this;
    }


    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereNotBetweenColumns(string $column, array $values, string $boolean = 'and'): self
    {
        $this->query->whereNotBetweenColumns($column, $values, $boolean);
        return $this;
    }

    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @param bool $not
     * @return RepositoryExtend|BaseRepository
     */
    public function whereIn(string $column, array $values, string $boolean = 'and', bool $not = false): self
    {
        $this->query->whereIn($column, $values, $boolean, $not);
        return $this;
    }

    /**
     * @param string $column
     * @param array $values
     * @param string $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereNotIn(string $column, array $values, string $boolean = 'and'): self
    {
        $this->query->whereNotIn($column, $values, $boolean);
        return $this;
    }

    /**
     * @param array|string $columns
     * @param string $boolean
     * @param bool $not
     * @return RepositoryExtend|BaseRepository
     */
    public function whereNull(array|string $columns, string $boolean = 'and', bool $not = false): self
    {
        $this->query->whereNull($columns, $boolean, $not);
        return $this;
    }


    /**
     * @param string|array $columns
     * @param string $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereNotNull(string|array $columns, string $boolean = 'and'): self
    {
        $this->query->whereNotNull($columns, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereDate(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->query->whereDate($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereMonth(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->query->whereMonth($column, $operator, $value, $boolean);
        return $this;
    }

    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereDay(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->query->whereDay($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereYear(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->query->whereYear($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param string $operator
     * @param \DateTimeInterface|string|null $value
     * @param string $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereTime(string $column, string $operator, \DateTimeInterface|string|null $value = null, string $boolean = 'and'): self
    {
        $this->query->whereTime($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param array|string $first
     * @param string|null $operator
     * @param string|null $second
     * @param string|null $boolean
     * @return RepositoryExtend|BaseRepository
     */
    public function whereColumn(array|string $first, ?string $operator = null, ?string $second = null, ?string $boolean = 'and'): self
    {
        $this->query->whereColumn($first, $operator, $second, $boolean);
        return $this;
    }

    /**
     * @param array|string $first
     * @param string|null $operator
     * @param string|null $second
     * @return RepositoryExtend|BaseRepository
     */
    public function orWhereColumn(array|string $first, ?string $operator = null, ?string $second = null): self
    {
        $this->query = $this->query->orWhereColumn($first, $operator, $second);
        return $this;
    }
}
