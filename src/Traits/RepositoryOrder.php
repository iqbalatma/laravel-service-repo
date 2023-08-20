<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;


use Iqbalatma\LaravelServiceRepo\BaseRepository;

trait RepositoryOrder
{
    /**
     * @param array|string $orderableColumns
     * @param string $direction
     * @return RepositoryOrder|BaseRepository
     */
    public function orderBy(array|string $orderableColumns = [], string $direction = "ASC"): self
    {
        if (is_array($orderableColumns)) {
            $requestQueryParam = request()->query();
            if ($this->isOrderRequestExists($requestQueryParam)) {
                $columns = array_intersect_key($requestQueryParam["order"], $orderableColumns);

                foreach ($columns as $columnName => $requestDirection) {
                    $this->checkDirection($requestDirection);
                    $this->query->orderBy($columnName, $requestDirection);
                }
            }
        }

        if (is_string($orderableColumns)) {
            $this->checkDirection($direction);
            $this->query->orderBy($orderableColumns, $direction);
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
