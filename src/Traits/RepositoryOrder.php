<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;


trait RepositoryOrder
{
    /**
     * @param array $orderaleColumns
     * @param string|null $columns
     * @param string|null $direction
     * @return RepositoryOrder
     */
    public function orderBy(array $orderaleColumns = [], ?string $columns = null, ?string $direction = "ASC"): self
    {
        $requestQueryParam = request()->query();
        if(is_null($columns)){
            if ($this->isOrderRequestExists($requestQueryParam)) {
                $columns = array_intersect_key($requestQueryParam["order"], $orderaleColumns);

                foreach ($columns as $columnName => $requestDirection) {
                    $this->checkDirection($requestDirection);
                    $this->model = $this->model->orderBy($columnName, $requestDirection);
                }
            }
        }else{
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
     * @param array $requestQueryParam
     * @return bool
     */
    private function isOrderRequestExists(array $requestQueryParam): bool
    {
        return isset($requestQueryParam["order"]) && is_array($requestQueryParam["order"]);
    }
}
