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
        $queryParam = request()->query();
        if ($this->isMultipleOrderByRequest($columns, $queryParam)) {
            $columns = array_intersect_key($queryParam["order"], $orderaleColumns);

            foreach ($columns as $columnName => $requestDirection) {
                $this->checkDirection($requestDirection);
                $this->model = $this->model->orderBy($columnName, $requestDirection);
            }
        } else {
            $this->checkDirection($direction);
            $this->model = $this->model->orderBy($columns, $direction);
        }
        return $this;
    }


    /**
     * Use set direction into ASC when direction is not between ASC or DESC
     * @param $requestDirection
     * @return void
     */
    private function checkDirection(&$requestDirection): void
    {
        $requestDirection = strtoupper($requestDirection);

        if ($requestDirection !== "ASC" && $requestDirection !== "DESC") {
            $requestDirection = "ASC";
        }
    }


    /**
     * @param string|null $columns
     * @param array $queryParam
     * @return bool
     */
    private function isMultipleOrderByRequest(?string $columns, array $queryParam): bool
    {
        return is_null($columns) && isset($queryParam["order"]) && is_array($queryParam["order"]);
    }
}
