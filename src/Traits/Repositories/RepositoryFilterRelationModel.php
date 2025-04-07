<?php

namespace Iqbalatma\LaravelServiceRepo\Traits\Repositories;

use Iqbalatma\LaravelServiceRepo\BaseRepositoryExtend;

trait RepositoryFilterRelationModel
{
    use BaseRepositoryFilter;

    private array $relationFilterableColumns;

    /**
     *  Description
     *
     *  request query param is come from http request
     *
     *  example postman
     *       filter[name]    =   "budi"
     *       filter[category]=   "food"
     *
     *  the request query format would be :
     *       "filter" :[
     *           "name"      : "budi",
     *           "category"  : "food"
     *       ]
     *
     *  filterable columns are list of column that allow to filter,
     *  it contains array key and value,
     *  key is represent array key on request, for this example is name and category
     *  value is represent for column name on db
     *       [
     *           "name" : "roles.name",
     *           "category" : "roles.category",
     *       ]
     *  it's possible to use different name for request key, as long as same to request key
     *
     *  array_intersect_key will filter request query param that does not allow by filterablecolumns
     *
     * @return void
     */
    private function filterRelationModel(): void
    {
        // looping for every relation
        foreach ($this->relationFilterableColumns as $relationName => $filterableColumns) {
            $intersectedFilter = array_intersect_key($this->requestQueryParam, $filterableColumns);

            // looping for every column on relation
            foreach ($intersectedFilter as $requestedKey => $requestValue) {
                if ($requestValue) {
                    $dbOperator = $this->getRelationDBOperator($filterableColumns, $requestedKey);
                    $dbColumnName = $this->getRelationDBColumn($relationName, $requestedKey);


                    if (is_string($requestValue)) {
                        $this->checkLikeOperator($dbOperator, $requestValue);

                        $this->builder->whereHas($relationName, function ($query) use ($dbColumnName, $dbOperator, $requestValue) {
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

                        $this->builder->whereHas($relationName, function ($query) use ($requestValue, $dbColumnName) {
                            $query->whereIn($dbColumnName, $requestValue);
                        }, $dbOperator, $count);
                    }
                }
            }
        }
    }


    /**
     * @param string $relationName
     * @param string $requestedKey
     * @return string
     */
    private function getRelationDBColumn(string $relationName, string $requestedKey): string
    {

        /**
         * this is for $filterableColumns = [
         *      "name" => "users.name"
         * ]
         *
         * which mean that the value is string
         */
        $dbColumnName = $this->relationFilterableColumns[$relationName][$requestedKey];

        /**
         * this is case when developer want to custom operator (not using default operator '=')
         * this is for $filterableColumns = [
         *      "name" => [
         *          "column" => "users.name",
         *          "operator" => "like" // could be = >= > < <= !=
         *      ]
         * ]
         */
        return $dbColumnName["column"] ?? $dbColumnName;
    }


    /**
     * @param array|null $relationFilterableColumns
     * @return RepositoryFilterRelationModel|BaseRepositoryExtend
     */
    private function setRelationFilterableColumns(?array $relationFilterableColumns): self
    {
        $this->relationFilterableColumns = $relationFilterableColumns ?? $this->builder->getModel()->relationFilterableColumns ?? [];

        return $this;
    }

    /**
     * @param array $relationFilterableColumn
     * @param string $requestedKey
     * @return string
     */
    private function getRelationDBOperator(array $relationFilterableColumn, string $requestedKey): string
    {
        return $relationFilterableColumn[$requestedKey]["operator"] ?? self::$defaultOperator;
    }
}
