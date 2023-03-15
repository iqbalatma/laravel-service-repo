<?php

namespace Iqbalatma\LaravelExtend\Traits;

trait RepositoryFilter
{
    static $defaultFilterOperator = "=";

    /**
     * Use to filter with column param
     *
     * @param array $filterableColumns
     * @return object
     */
    public function filterColumn(array $filterableColumns = []): object
    {
        $query = request()->query();
        if (isset($query["search"])) {
            $queryParams = $query["search"];
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

    private function checkLikeOperator(string $operator, string &$value)
    {
        if (strtolower($operator) == "like") {
            $value = "%$value%";
        }
    }
}
