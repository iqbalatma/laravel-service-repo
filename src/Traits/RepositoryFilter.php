<?php

namespace Iqbalatma\LaravelExtend\Traits;

use Iqbalatma\LaravelExtend\BaseRepository;

trait RepositoryFilter
{
    static $defaultFilterOperator = "=";
    static $defaultOrder = "ASC";

    /**
     * Use to filter with column param
     *
     * @param array $filterableColumns
     * @return object
     */
    public function filterColumn(array $filterableColumns = []): object
    {
        $query = request()->query();
        if (isset($query["filter"])) {
            $queryParams = $query["filter"];
            $columns = $queryParams["columns"] ?? [];
            $values = $queryParams["values"] ?? [];
            $operators = $queryParams["operators"] ?? [];
            $orders = $queryParams["orders"] ?? [];
            if (count($columns) > 0 && count($filterableColumns) > 0) {
                $this->applyWhereClause($columns, $values, $operators, $orders, $filterableColumns);
            }
        };

        return $this;
    }


    /**
     * This is use to apply filter operator
     *
     * @param array $columns
     * @param array $values
     * @param array $operators
     * @param array $orders
     * @param array $filterableColumns
     * @return void
     */
    private function applyWhereClause(array $columns, array $values, array $operators, array $orders, array $filterableColumns): void
    {
        for ($i = 0; $i < count($columns); $i++) {
            if (isset($columns[$i]) && isset($values[$i]) && isset($filterableColumns[$columns[$i]])) {
                $value = $values[$i];
                $operator =  $operators[$i] ?? self::$defaultFilterOperator;
                $order = $orders[$i] ?? self::$defaultOrder;
                $this->checkLikeOperator($operator, $value);
                $this->model = $this->model
                    ->where(
                        $filterableColumns[$columns[$i]],
                        $operator,
                        $value
                    );
                $this->orderBy($filterableColumns[$columns[$i]], $order);
            }
        }
    }


    /**
     * Use to check like operator
     *
     * @param string $operator
     * @param string $value
     * @return void
     */
    private function checkLikeOperator(string $operator, string &$value)
    {
        if (strtolower($operator) == "like") {
            $value = "%$value%";
        }
    }

    /**
     * Use to order by the repository
     * @param string $column
     * @param string $order
     * @return BaseRepository
     */
    public function orderBy(string $column, string $order = "ASC"): BaseRepository
    {
        $this->model = $this->model->orderBy($column, $order);
        return $this;
    }
}
