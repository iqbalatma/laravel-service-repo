<?php

namespace Iqbalatma\LaravelExtend;

use Iqbalatma\LaravelExtend\Interfaces\IRepository;

abstract class BaseRepository implements IRepository
{
    protected const DEFAULT_PER_PAGE = 5;
    protected  $model;

    public function searchColumn(array $searchableColumn = []): object
    {
        $queryParams = request()->query()["search"];
        ["columns" => $columns, "values" => $values, "operators" => $operators] = $queryParams;

        for ($i = 0; $i < count($columns); $i++) {
            if (isset($columns[$i]) && isset($values[$i]) && isset($searchableColumn[$columns[$i]])) {
                $this->model = $this->model->where($searchableColumn[$columns[$i]], $operators[$i] ?? "=", $values[$i]);
            }
        }


        return $this;
    }

    public function getAllDataPaginated(array $columns = ["*"], int $perPage = self::DEFAULT_PER_PAGE): ?object
    {
        return $this->model
            ->select($columns)
            ->paginate($perPage);
    }
    public function getAllData(array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->get();
    }
    public function getDataById(int $id, array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->where("id", $id)
            ->first();
    }

    public function addNewData(array $requestedData): object
    {
        return $this->model
            ->create($requestedData);
    }
    public function updateDataById(int $id, array $requestedData, array $columns = ["*"]): ?object
    {
        $this->model
            ->where("id", $id)
            ->update($requestedData);

        return $this->model->find($id, $columns);
    }
    public function deleteDataById(int $id): int
    {
        return $this->model
            ->where("id", $id)
            ->delete();
    }
}
