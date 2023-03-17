<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait RepositoryExtend
{
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
