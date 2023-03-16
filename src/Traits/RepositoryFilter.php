<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Iqbalatma\LaravelServiceRepo\BaseRepository;

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
    public function filterColumn(array $filterableColumns): BaseRepository
    {
        $query = request()->query();
        if (isset($query["filter"])) {
            $queryParams = $query["filter"];
            $columns = $queryParams["columns"] ?? [];
            $values = $queryParams["values"] ?? [];
            $operators = $queryParams["operators"] ?? [];
            if (count($columns) > 0 && count($filterableColumns) > 0) {
                $this->applyWhereClause($columns, $values, $operators, $filterableColumns);
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
    private function applyWhereClause(array $columns, array $values, array $operators, array $filterableColumns): void
    {
        for ($i = 0; $i < count($columns); $i++) {
            if (isset($columns[$i]) && isset($values[$i]) && isset($filterableColumns[$columns[$i]])) {
                $value = $values[$i];
                $operator =  $operators[$i] ?? self::$defaultFilterOperator;
                $this->checkLikeOperator($operator, $value);
                $this->model = $this->model
                    ->where(
                        $filterableColumns[$columns[$i]],
                        $operator,
                        $value
                    );
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
}
