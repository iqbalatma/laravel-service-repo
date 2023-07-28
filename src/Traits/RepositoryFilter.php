<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait RepositoryFilter
{
    private static string $defaultOperator = "=";

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
            $this->filterMainModel($requestQueryParam, $filterableColumns)
                ->filterRelationModel($requestQueryParam, $relationFilterableColumns);
        };

        return $this;
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
        if (strtolower($operator) === "like") $value = "%$value%";

    }

    /**
     * @param array $requestQueryParam
     * @param array $relationFilterableColumns
     * @return void
     */
    private function filterRelationModel(array $requestQueryParam, array $relationFilterableColumns):void{
        // looping for every relation
        foreach ($relationFilterableColumns as $relationName => $filterableColumns) {
            $intersectedFilter = array_intersect_key($requestQueryParam["filter"], $filterableColumns);
            // looping for every column on relation
            foreach ($intersectedFilter as $requestedKey => $requestValue) {
                $dbOperator = $this->getDBOperator($requestedKey,$filterableColumns);
                $dbColumnName = $this->getDBColumn($requestedKey, $filterableColumns);

                if (is_string($requestValue)) {
                    $this->checkLikeOperator($dbOperator, $requestValue);

                    $this->model = $this->model->whereHas($relationName, function ($query) use ($dbColumnName, $dbOperator, $requestValue) {
                        $query->where($dbColumnName, $dbOperator, $requestValue);
                    });
                }

                if (is_array($requestValue)) {
                    $dbOperator = ">=";
                    $count = 1;

                    if (isset($filterableColumns[$requestedKey]["behavior"]) && strtolower($filterableColumns[$requestedKey]["behavior"]) === "and") {
                        $dbOperator = "=";
                        $count = count($requestValue);
                    }

                    $this->model = $this->model->whereHas($relationName, function ($query) use ($requestValue, $dbColumnName) {
                        $query->whereIn($dbColumnName, $requestValue);
                    }, $dbOperator, $count);
                }
            }
        }

    }

    /**
     * use to filter main repository model
     * @param array $requestQueryParam
     * @param array $filterableColumns
     * @return self
     */
    private function filterMainModel(array $requestQueryParam, array $filterableColumns):self
    {
        $filterRequest = $requestQueryParam["filter"];
        // filter column for main model
        $intersectedFilter = array_intersect_key($filterRequest, $filterableColumns);
        foreach ($intersectedFilter as $requestedKey => $value) {
            $dbOperator = $this->getDBOperator($requestedKey,$filterableColumns);
            $dbColumnName = $this->getDBColumn($requestedKey, $filterableColumns);


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

        return $this;
    }


    /**
     * @param array $requestQueryParam
     * @return bool
     */
    private function isFilterRequestExists(array $requestQueryParam):bool{
        return isset($requestQueryParam["filter"]) && is_array($requestQueryParam["filter"]);
    }


    /**
     * @param string $requestedKey
     * @param array $filterableColumns
     * @return string
     */
    private function getDBOperator(string $requestedKey, array $filterableColumns):string{
        $dbOperator = self::$defaultOperator;
        if (isset($filterableColumns[$requestedKey]["operator"])) {
            $dbOperator = $filterableColumns[$requestedKey]["operator"];
        }
        return $dbOperator;
    }


    /**
     * @param string $requestedKey
     * @param array $filterableColumns
     * @return string
     */
    private function getDBColumn(string $requestedKey, array $filterableColumns):string{
        /**
         * this is for $filterableColumns = [
         *  "name" => "users.name"
         * ]
         *
         * which mean that the value is string
         */
        $dbColumnName = $filterableColumns[$requestedKey];

        /**
         * this is case when developer want to custom operator (not using default operator '=')
         * this is for $filterableColumns = [
         *      "name" => [
         *          "column" => "users.name",
         *          "operator" => "like" // could be = >= > < <= !=
         *      ]
         * ]
         */
        if (isset($dbColumnName["column"])) {
            $dbColumnName = $dbColumnName["column"];
        }

        return $dbColumnName;
    }

}
