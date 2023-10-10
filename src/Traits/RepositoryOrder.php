<?php

namespace Iqbalatma\LaravelServiceRepo\Traits;


use Illuminate\Database\Eloquent\Builder;
use Iqbalatma\LaravelServiceRepo\BaseRepositoryExtend;

trait RepositoryOrder
{
    /**
     * @param array|string|null $orderableColumns
     * @param string $direction
     * @return RepositoryOrder|BaseRepositoryExtend
     */
    public function _orderColumn(array|string|null $orderableColumns = null, string $direction = "ASC"): self
    {
        $orderableColumns = $orderableColumns ?? $this->builder->getModel()->orderableColumns ?? [];
        $this->defaultOrderColumn();


        if (is_array($orderableColumns)) {
            $requestQueryParam = config("servicerepo.order_query_param_root") ?
                request()->query(config("servicerepo.order_query_param_root"), []) :
                request()->query();
            if ($this->isOrderRequestExists($requestQueryParam)) {
                $columns = array_intersect_key($requestQueryParam["order"], $orderableColumns);

                foreach ($columns as $columnName => $requestDirection) {
                    $this->checkDirection($requestDirection);
                    $this->builder->orderBy($columnName, $requestDirection);
                }
            }
        }

        if (is_string($orderableColumns)) {
            $this->checkDirection($direction);
            $this->builder->orderBy($orderableColumns, $direction);
        }
        return $this;
    }


    /**
     * @return void
     */
    private function defaultOrderColumn(): void
    {
        $this->builder->when(!empty(request()->query()["order"]["created_at"]), function (Builder $query) {
            $query->orderBy("created_at", request()->query()["order"]["created_at"]);
        });
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
