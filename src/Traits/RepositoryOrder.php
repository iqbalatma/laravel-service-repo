<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;

use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait RepositoryOrder
{
    /**
     * @param array $orderaleColumns
     * @param string|null $columns
     * @param string|null $direction
     * @return RepositoryOrder
     */
    public function orderBy(array $orderaleColumns = [], ?string $columns = null, ?string $direction = "ASC"): RepositoryOrder
    {
        $query = request()->query();
        // if column is empty, use column from request query
        if (is_null($columns)) {
            if (isset($query["order"]) && is_array($query["order"])) {
                $columns = array_intersect_key($query["order"], $orderaleColumns);

                foreach ($columns as $columnName => $requestDirection) {
                    $requestDirection = strtoupper($requestDirection);

                    //to set direction into ASC when direction is not between ASC or DESC
                    if ($requestDirection !== "ASC" && $requestDirection !== "DESC") {
                        $requestDirection = "ASC";
                    }

                    $this->model = $this->model->orderBy($columnName, $requestDirection);
                }
            }
        } else {
            $this->model = $this->model->orderBy($columns, $direction);
        }
        return $this;
    }

}
