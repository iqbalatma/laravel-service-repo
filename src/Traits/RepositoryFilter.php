<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait RepositoryFilter
{
    private static string $defaultOperator = "=";

    /**
     * Use to check like operator
     *
     * @param string $operator
     * @param string $value
     * @return void
     */
    private function checkLikeOperator(string $operator, string &$value)
    {
        if (strtolower($operator) === "like") $value = "%$value%";

    }

    /**
     * if the same column value is array, it will iterate it, and use or where clause
     *
     * @param array $filterableColumns
     * @return BaseRepository
     */
    public function filterColumn(array $filterableColumns = [], array $relationFilterableColumns = []): BaseRepository
    {
        $requestQueryParam = request()->query();


        if ($this->isFilterRequestExists($requestQueryParam)) {
            $this->filterMainModel($requestQueryParam, $filterableColumns);
            // filter column for current model
//            $filter = array_intersect_key($requestQueryParam["filter"], $filterableColumns);
//            foreach ($filter as $columnName => $value) {
//                $dbOperator = self::$defaultOperator;
//
//                /**
//                 * this is for $filterableColumns = [
//                 *  "name" => "users.name"
//                 * ]
//                 *
//                 * which mean that the value is string
//                 */
//                $dbColumnName = $filterableColumns[$columnName];
//
//                /**
//                 * this is for $filterableColumns = [
//                 *      "name" => [
//                 *          "column" => "users.name",
//                 *          "operator" => "like" // could be = >= > < <= !=
//                 *      ]
//                 * ]
//                 */
//                if (is_array($dbColumnName)) {
//                    if (isset($dbColumnName["operator"])) {
//                        $dbOperator = $dbColumnName["operator"];
//                    }
//                    $dbColumnName = $dbColumnName["column"];
//                }
//
//                // which mean the request value is only 1
//                if (is_string($value)) {
//                    $this->checkLikeOperator($dbOperator, $value);
//                    $this->model = $this->model->where($dbColumnName, $dbOperator, $value);
//                }
//
//                // which mean the request value is more than one
//                if (is_array($value)) {
//                    foreach ($value as $subValue) {
//                        $this->checkLikeOperator($dbColumnName, $subValue);
//                        $this->model = $this->model->orWhere($dbColumnName, $dbOperator, $subValue);
//                    }
//                }
//            }


//            filter column for relation model
            foreach ($relationFilterableColumns as $relationName => $dbColumnDataSet) {
//                this is column that belongs to relation
                $requestedData = array_intersect_key($requestQueryParam["filter"], $dbColumnDataSet);
//                loop the columns. every column has query filter data
                foreach ($requestedData as $requestKey => $requestValue) {
                    $dbOperator = self::$defaultOperator;

                    // this $dbColumnDataSet is value from data relation, it is array of column that allowed to filter by that relation
                    $dbColumnName = $dbColumnDataSet[$requestKey];

                    if (is_array($dbColumnName)) {
                        if (isset($dbColumnDataSet[$requestKey]["operator"])) {
                            $dbOperator = $dbColumnDataSet[$requestKey]["operator"];
                        }
                        $dbColumnName = $dbColumnDataSet[$requestKey]["column"];
                    }


                    if (is_string($requestValue)) {
                        $this->checkLikeOperator($dbOperator, $requestValue);

                        $this->model = $this->model->whereHas($relationName, function ($query) use ($requestValue, $dbOperator, $dbColumnName) {
                            $query->where($dbColumnName, $dbOperator, $requestValue);
                        });
                    }

                    if (is_array($requestValue)) {
                        $dbOperator = ">=";
                        $count = 1;

                        if (isset($dbColumnDataSet[$requestKey]["behavior"]) && strtolower($dbColumnDataSet[$requestKey]["behavior"]) === "and") {
                            $dbOperator = "=";
                            $count = count($requestValue);
                        }

                        $this->model = $this->model->whereHas($relationName, function ($query) use ($requestValue, $dbColumnName, $requestKey, $dbOperator) {
                            $query->whereIn($dbColumnName, $requestValue);
                        }, $dbOperator, $count);
                    }
                }
            }
        };

        return $this;
    }

    public function filterMainModel(array $requestQueryParam, array $filterableColumns)
    {
        $filterRequest = $requestQueryParam["filter"];
        // filter column for main model
        $intersectedFilter = array_intersect_key($filterRequest, $filterableColumns);
        foreach ($intersectedFilter as $columnName => $value) {
            $dbOperator = self::$defaultOperator;

            /**
             * this is for $filterableColumns = [
             *  "name" => "users.name"
             * ]
             *
             * which mean that the value is string
             */
            $dbColumnName = $filterableColumns[$columnName];

            /**
             * this is case when developer want to custom operator (not using default operator '=')
             * this is for $filterableColumns = [
             *      "name" => [
             *          "column" => "users.name",
             *          "operator" => "like" // could be = >= > < <= !=
             *      ]
             * ]
             */
            if (is_array($dbColumnName) && isset($dbColumnName["column"])) {
                if (isset($dbColumnName["operator"]))
                    $dbOperator = $dbColumnName["operator"];

                if(isset($dbColumnName["column"]))
                    $dbColumnName = $dbColumnName["column"];
            }

            // which mean the request value is only 1
            if (is_string($value)) {
                $this->checkLikeOperator($dbOperator, $value);
                $this->model = $this->model->where($dbColumnName, $dbOperator, $value);
            }

            // which mean the request value is more than one
            if (is_array($value)) {
                foreach ($value as $subValue) {
                    $this->checkLikeOperator($dbColumnName, $subValue);
                    $this->model = $this->model->orWhere($dbColumnName, $dbOperator, $subValue);
                }
            }
        }
    }


    /**
     * @param array $requestQueryParam
     * @return bool
     */
    private function isFilterRequestExists(array $requestQueryParam):bool{
        return isset($requestQueryParam["filter"]) && is_array($requestQueryParam["filter"]);
    }

}
