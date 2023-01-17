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

    /**
     * Use to get all data with pagination
     * @param array $columns
     * @param int $perPage
     * @return object|null
     */
    public function getAllDataPaginated(array $columns = ["*"], int $perPage = self::DEFAULT_PER_PAGE): ?object
    {
        return $this->model
            ->select($columns)
            ->paginate($perPage);
    }

    /**
     * Use to get all data withoud pagination
     *
     * @param array $columns
     * @return object|null
     */
    public function getAllData(array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->get();
    }

    /**
     * Use to get data by id
     *
     * @param int $id
     * @param array $columns
     * @return object|null
     */
    public function getDataById(int $id, array $columns = ["*"]): ?object
    {
        return $this->model
            ->select($columns)
            ->where("id", $id)
            ->first();
    }

    public function getDataByWhereClause(array $whereClause, array $columns = ["*"])
    {
        return $this->model
            ->select($columns)
            ->where($whereClause)
            ->first();
    }

    /**
     * Use to add new data to model
     *
     * @param array $requestedData
     * @return object
     */
    public function addNewData(array $requestedData): object
    {
        return $this->model->create($requestedData);
    }

    /**
     * Use to update data model by id
     *
     * @param int $id
     * @param array $requestedData
     * @param array $columns
     * @param bool $isReturnObject
     * @return int|object|null
     */
    public function updateDataById(int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true): int|object|null
    {
        $updatedData = $this->model
            ->where("id", $id)
            ->update($requestedData);
        if (!$isReturnObject) {
            return $updatedData;
        }
        return $this->model->find($id, $columns);
    }


    /**
     * Use to delete data model by value
     *
     * @param int $id
     * @return int
     */
    public function deleteDataById(int $id): int
    {
        return $this->model
            ->where("id", $id)
            ->delete();
    }
}
