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
    public function filterColumn(array $filterableColumns = [], array $relationFilterableColumn = []): BaseRepository
    {
        $query = request()->query();
        if (isset($query["filter"])) {
//            filter column for current model
            $filter = array_intersect_key($query["filter"], $filterableColumns);
            foreach ($filter as $columnName => $column) {
                if (isset($column["value"])) {
                    $value = $column["value"];

//                    operator check
                    $operator = self::$defaultOperator;
                    if (isset($column["operator"])) $operator = $column["operator"];

//                    which mean the value is only 1
                    if (is_string($value)) {
                        $this->checkLikeOperator($operator, $value);
                        $this->model = $this->model->where($filterableColumns[$columnName], $operator, $value);
                    }

//                    which mean the value is more than one
                    if (is_array($value)) {
                        foreach ($value as $subValue) {
                            $this->checkLikeOperator($operator, $subValue);
                            $this->model = $this->model->orWhere($filterableColumns[$columnName], $operator, $subValue);
                        }
                    }
                }
            }


//            filter column for relation model
            foreach ($relationFilterableColumn as $relation => $columns) {
//                this is column that belongs to relation
                $relationFilter = array_intersect_key($query["filter"], $columns);

//                loop the columns. every column has query filter data
                foreach ($relationFilter as $columnName => $column) {
                    if (isset($column["value"])) {
                        $value = $column["value"];

                        $operator = self::$defaultOperator;
                        if (isset($column["operator"])) $operator = $column["operator"];
                        if (is_string($value)) {
                            $this->checkLikeOperator($operator, $value);

                            $this->model = $this->model->whereHas($relation, function ($query) use ($value, $operator, $columnName, $columns) {
                                $query->where($columns[$columnName], $operator, $value);
                            });
                        }

                        if (is_array($value)) {
                            $operator = ">=";
                            $count = 1;
                            if(isset($column["behavior"]) && strtolower($column["behavior"]) == "and"){
                                $operator = "=";
                                $count = count($value);
                            }
                            $this->model = $this->model->whereHas($relation, function ($query) use ($value, $columnName, $columns) {
                                $query->whereIn($columns[$columnName], $value);
                            },$operator, $count);
                        }
                    }
                }
            }
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
        if (strtolower($operator) == "like") {
            $value = "%$value%";
        }
    }
}
