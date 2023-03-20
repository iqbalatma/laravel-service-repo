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
        // use to set duplicate column
        $columnExists = [];
        $groupingValueIndexs = [];
        $countColumns = array_count_values($columns);
        foreach ($countColumns as $key => $value) {
            if ($value > 1 && isset($filterableColumns[$key])) {
                array_push($columnExists, $key);
                foreach ($columns as $subKey => $subValue) {
                    if ($subValue == $key) {
                        if (isset($values[$subKey])) {
                            $groupingValueIndexs[$key][$subKey] = $values[$subKey];
                        }
                    }
                }
            }
        }

        foreach ($columnExists as $key => $column) {
            $groupingValues = $groupingValueIndexs[$column];
            $this->model = $this->model->where(function ($query) use ($groupingValues, $column) {
                foreach ($groupingValues as $subKey => $value) {
                    $query->orWhere($column, $value);
                }
            });

            // to unset duplicate column
            foreach ($columns as $subKey => $subValue) {
                if ($subValue == $column) {
                    unset($columns[$subKey]);
                }
            }
        }

        foreach ($columns as $key => $column) {
            if (isset($column) && isset($values[$key]) && isset($filterableColumns[$column])) {
                $value = $values[$key];
                $operator =  $operators[$key] ?? self::$defaultFilterOperator;
                $column = $filterableColumns[$column];
                $this->checkLikeOperator($operator, $value);

                if (!in_array($column, $columnExists)) {
                    $this->model = $this->model
                        ->where(
                            $column,
                            $operator,
                            $value
                        );
                }
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
