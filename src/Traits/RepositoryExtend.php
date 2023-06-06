<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Couchbase\RemoveOptions;
use Illuminate\Database\Eloquent\Model;
use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait RepositoryExtend
{
    /**
     * @var Model
     */
    protected $model;
    /**
     * Use to add with relation on model
     *
     * @param array $relations
     * @return BaseRepository
     */
    public function with(array|string $relations): BaseRepository
    {
        $this->model = $this->model->with($relations);
        return $this;
    }


    /**
     * @param array|string $column
     * @param string|null $operator
     * @param string|null $value
     * @param string|null $boolean
     * @return BaseRepository
     */
    public function where(array|string $column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and'):BaseRepository
    {
        $this->model = $this->model->where($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param array|stirng $column
     * @param string|null $operator
     * @param string|null $value
     * @return BaseRepository
     */
    public function orWhere(array|stirng $column,?string $operator = null, ?string $value = null):BaseRepository
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
    public function whereNot(array|string $column, ?string $operator = null, ?string $value = null, ?string $boolean = 'and'):BaseRepository
    {
        $this->model = $this->model->whereNot($column, $operator, $value, $boolean);
        return $this;
    }


    /**
     * @param string $column
     * @param string $values
     * @param string $boolean
     * @param bool $not
     * @return BaseRepository
     */
    public function whereBetween(string $column, string $values, string $boolean = 'and', bool $not = false):BaseRepository
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
    public function whereNotBetween(string $column,array|string $values,string $boolean = 'and'):BaseRepository
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
    public function whereBetweenColumns(string $column, array $values, string $boolean = 'and', bool $not = false):BaseRepository
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
    public function whereNotBetweenColumns(string $column,array $values, string $boolean = 'and'):BaseRepository
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
    public function whereIn(string $column, array $values,string $boolean = 'and',bool $not = false):BaseRepository
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
    public function whereNotIn(string $column, array $values, string $boolean = 'and'):BaseRepository
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
    public function whereNull(array|string $columns, string $boolean = 'and', bool $not = false):BaseRepository
    {
        $this->model = $this->model->whereNull($columns, $boolean, $not);
        return $this;
    }


    /**
     * @param string|array $columns
     * @param string $boolean
     * @return BaseRepository
     */
    public function whereNotNull(string|array $columns, string $boolean = 'and'):BaseRepository
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
    public function whereDate(string $column, string $operator, \DateTimeInterface|string|null $value = null,string $boolean = 'and'):BaseRepository
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
    public function whereMonth(string $column, string $operator,\DateTimeInterface|string|null $value = null, string $boolean = 'and'):BaseRepository
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
    public function whereDay(string $column,string $operator,\DateTimeInterface|string|null $value = null, string $boolean = 'and'):BaseRepository
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
    public function whereYear(string $column, string $operator, \DateTimeInterface|string|null $value = null,string $boolean = 'and'):BaseRepository
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
    public function whereTime(string $column,string $operator,\DateTimeInterface|string|null $value = null,string $boolean = 'and'):BaseRepository
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
    public function whereColumn(array|string $first,?string $operator = null,?string $second = null,?string $boolean = 'and'):BaseRepository
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
    public function orWhereColumn(array|string $first,?string $operator = null,?string $second = null):BaseRepository
    {
        $this->model = $this->model->orWhereColumn($first, $operator, $second);
        return $this;
    }


    /**
     * Use to order by collection data
     *
     * @param array $orderaleColumns
     * @param string|null|null $column
     * @param string $order
     * @return BaseRepository
     */
    public function orderBy(array $orderaleColumns, string|null $column = null, string|null $order = "ASC"): BaseRepository
    {
        // if there is no param, it's mean they want it from request
        if (is_null($column)) {
            $columns = request()->query("order_columns");
            $orders = request()->query("order_intervals");
            // we need to make sure that the param is array even we have default
            if (gettype($columns) == "array") {
                foreach ($columns as $key => $column) {
                    if (isset($orderaleColumns[$column])) {
                        if (isset($orders[$key])) {
                            $order = $orders[$key];
                            if ($order != "asc" && $order != "desc") {
                                $order = "asc";
                            }
                        } else {
                            $order = "asc";
                        }

                        $this->model = $this->model->orderBy($column, $order);
                    }
                }
            }
        } else {
            $this->model = $this->model->orderBy($column, $order ?? "asc");
        }
        return $this;
    }
}
