<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Iqbalatma\LaravelServiceRepo\BaseRepository;
use Iqbalatma\LaravelServiceRepo\BaseRepositoryExtend;

trait RepositoryFilterMainModel
{
    use BaseRepositoryFilter;

    public array $filterableColumns;

    /**
     * @note filter for main model
     * @return RepositoryFilter|BaseRepositoryExtend
     */
    private function filterMainModel(): self
    {
        foreach (array_intersect_key($this->requestQueryParam["filter"], $this->filterableColumns) as $requestedKey => $value) {
            # continue loop when value is null
            if (is_null($value)) {
                continue;
            }

            $dbOperator = $this->getDBOperator($requestedKey);
            $dbColumnName = $this->getDBColumn($requestedKey);

            # which mean the request value is only 1
            if (is_string($value)) {
                $this->checkLikeOperator($dbOperator, $value);
                $this->builder->where($dbColumnName, $dbOperator, $value);
            }

            # which mean the request value is more than one
            if (is_array($value)) {
                foreach ($value as $subValue) {
                    #continue when value is null
                    if (is_null($subValue)) {
                        continue;
                    }
                    $this->checkLikeOperator($dbColumnName, $subValue);
                    $this->builder->orWhere($dbColumnName, $dbOperator, $subValue);
                }
            }
        }

        return $this;
    }


    /**
     * @param array|null $filterableColumns
     * @return RepositoryFilter|BaseRepository
     */
    private function setFilterableColumns(?array $filterableColumns = null): self
    {
        /**
         * Priority :
         * 1 filterableColumns argument from filterColumn() method
         * 2 filterableColumns from model property
         * 3 empty array
         */
        $this->filterableColumns = $filterableColumns ?? $this->builder->getModel()->filterableColumns ?? [];

        return $this;
    }


    /**
     * @return RepositoryFilterMainModel|BaseRepositoryExtend
     */
    private function defaultFilterableColumn(): self
    {
        $this->builder->when(!empty(request()?->query()["filter"]["created_at"][0]), function (Builder $query) {
            try {
                $date = Carbon::createFromFormat('Y-m-d', request()?->query()["filter"]["created_at"][0]);
            } catch (\Exception $e) {
                throw ValidationException::withMessages(['filter.created_at.0' => 'Date format should be yyyy-mm-dd']);
            }

            $query->where("created_at", ">=", $date->startOfDay());
        });

        $this->builder->when(!empty(request()?->query()["filter"]["created_at"][1]), function (Builder $query) {
            try {
                $date = Carbon::createFromFormat('Y-m-d', request()?->query()["filter"]["created_at"][1]);
            } catch (\Exception $e) {
                throw ValidationException::withMessages(['filter.created_at.1' => 'Date format should be yyyy-mm-dd']);
            }

            $query->where("created_at", "<=", $date->endOfDay());
        });

        return $this;
    }

    /**
     * @param string $requestedKey
     * @return string
     */
    private function getDBOperator(string $requestedKey): string
    {
        return $this->filterableColumns[$requestedKey]["operator"] ?? self::$defaultOperator;
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
        return $dbColumnName["column"] ?? $dbColumnName;
    }
}
