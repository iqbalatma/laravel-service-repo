<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait RepositoryFilter
{
    private static string $defaultOperator = "=";
    private array $requestQueryParam;
    private array $filterableColumns;
    private array $relationFilterableColumns;

    /**
     * @param array $filterableColumns
     * @param array $relationFilterableColumns
     * @return BaseRepository
     */
    public function filterColumn(array $filterableColumns = [], array $relationFilterableColumns = []): BaseRepository
    {
        $this->setRequestQueryParam()
            ->setFilterableColumns($filterableColumns)
            ->setRelationFilterableColumns($relationFilterableColumns);


        if ($this->isFilterRequestExists()) {
            $this->filterMainModel()
                ->filterRelationModel();
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
    private function checkLikeOperator(string $operator, string &$value): void
    {
        if (strtolower($operator) === "like") $value = "%$value%";

    }

    /**
     * @return void
     */
    private function filterRelationModel(): void
    {
        // looping for every relation
        foreach ($this->relationFilterableColumns as $relationName => $filterableColumns) {

            $intersectedFilter = array_intersect_key($this->requestQueryParam["filter"], $filterableColumns);

            // looping for every column on relation
            foreach ($intersectedFilter as $requestedKey => $requestValue) {
                $dbOperator = $this->getDBOperator($requestedKey);
                $dbColumnName = $this->getRelationDBColumn($relationName, $requestedKey);


                if (is_string($requestValue)) {
                    $this->checkLikeOperator($dbOperator, $requestValue);

                    $this->query->whereHas($relationName, function ($subQuery) use ($dbColumnName, $dbOperator, $requestValue) {
                        $subQuery->where($dbColumnName, $dbOperator, $requestValue);
                    });
                }

                if (is_array($requestValue)) {
                    $dbOperator = ">=";
                    $count = 1;

                    if (isset($filterableColumns[$requestedKey]["behavior"]) && strtolower($filterableColumns[$requestedKey]["behavior"]) === "and") {
                        $dbOperator = "=";
                        $count = count($requestValue);
                    }

                    $this->query->whereHas($relationName, function ($subQuery) use ($requestValue, $dbColumnName) {
                        $subQuery->whereIn($dbColumnName, $requestValue);
                    }, $dbOperator, $count);
                }
            }
        }
    }

    /**
     * @return RepositoryFilter|BaseRepository
     */
    private function filterMainModel(): self
    {
        // filter column for main model
        foreach (array_intersect_key($this->requestQueryParam["filter"], $this->filterableColumns) as $requestedKey => $value) {

            $dbOperator = $this->getDBOperator($requestedKey);
            $dbColumnName = $this->getDBColumn($requestedKey);

            // which mean the request value is only 1
            if (is_string($value)) {
                $this->checkLikeOperator($dbOperator, $value);
                $this->query->where($dbColumnName, $dbOperator, $value);
            }

            // which mean the request value is more than one
            if (is_array($value)) {
                foreach ($value as $subValue) {
                    $this->checkLikeOperator($dbColumnName, $subValue);
                    $this->query->orWhere($dbColumnName, $dbOperator, $subValue);
                }
            }
        }

        return $this;
    }


    /**
     * @return bool
     */
    private function isFilterRequestExists(): bool
    {
        return isset($this->requestQueryParam["filter"]) && is_array($this->requestQueryParam["filter"]);
    }


    /**
     * @param string $requestedKey
     * @return string
     */
    private function getDBOperator(string $requestedKey): string
    {
        $filterableColumns = $this->filterableColumns;
        $dbOperator = self::$defaultOperator;
        if (isset($filterableColumns[$requestedKey]["operator"])) {
            $dbOperator = $filterableColumns[$requestedKey]["operator"];
        }
        return $dbOperator;
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
         *  "name" => "users.name"
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
        if (isset($dbColumnName["column"])) {
            $dbColumnName = $dbColumnName["column"];
        }

        return $dbColumnName;
    }


    /**
     * @param string $requestedKey
     * @return string
     */
    private function getDBColumn(string $requestedKey): string
    {

        /**
         * this is for $filterableColumns = [
         *  "name" => "users.name"
         * ]
         *
         * which mean that the value is string
         */
        $dbColumnName = $this->filterableColumns[$requestedKey];

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


    /**
     * @return RepositoryFilter|BaseRepository
     */
    private function setRequestQueryParam(): self
    {
        $this->requestQueryParam = request()->query();

        return $this;
    }

    /**
     * @param array $filterableColumn
     * @return RepositoryFilter|BaseRepository
     */
    private function setFilterableColumns(array $filterableColumn): self
    {
        $this->filterableColumns = $filterableColumn;

        return $this;
    }

    /**
     * @param array $relationFilterableColumns
     * @return RepositoryFilter|BaseRepository
     */
    private function setRelationFilterableColumns(array $relationFilterableColumns): self
    {
        $this->relationFilterableColumns = $relationFilterableColumns;

        return $this;
    }
}
