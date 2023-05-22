<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Iqbalatma\LaravelServiceRepo\Contracts\IRepository;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryExtend;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryFilter;
use Iqbalatma\LaravelServiceRepo\Traits\RepositorySearch;

abstract class BaseRepository implements IRepository
{
    use RepositoryFilter, RepositorySearch, RepositoryExtend;
    protected $model;

    /**
     * Use to get all data with pagination and where clause as optional param
     *
     * @param array $whereClause
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function getAllDataPaginated(array $whereClause = [], array $columns = ["*"]): LengthAwarePaginator
    {
        return $this->model
            ->select($columns)
            ->where($whereClause)
            ->paginate(request()->query("perpage", config("servicerepo.perpage")));
    }


    /**
     * Use to get all data without pagination
     *
     * @param array $whereClause
     * @param array $columns
     * @return Collection
     */
    public function getAllData(array $whereClause = [], array $columns = ["*"]): Collection
    {
        return $this->model
            ->select($columns)
            ->where($whereClause)
            ->get();
    }


    /**
     * Use to get data by id
     *
     * @param string|int|array $id
     * @param array $columns
     * @return Model|Collection|null
     */
    public function getDataById(string|int|array $id, array $columns = ["*"]):  Model|Collection|null
    {
        return $this->model->select($columns)->find($id);
    }


    /**
     * Get single data with where clause
     *
     * @param array $whereClause
     * @param array $columns
     * @return Model|null
     */
    public function getSingleDataDataByWhereClause(array $whereClause, array $columns = ["*"]):?Model
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
     * @return Model
     */
    public function addNewData(array $requestedData): Model
    {
        return $this->model->create($requestedData);
    }


    /**
     * Use to update data model by id (single update)
     *
     * @param string|int $id
     * @param array $requestedData
     * @param array $columns
     * @param bool $isReturnObject
     * @return int|Model|null
     */
    public function updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true): int|Model|null
    {
        $updatedData = $this->model
            ->where("id", $id)
            ->update($requestedData);
        if (!$isReturnObject) return $updatedData;

        return $this->model->find($id, $columns);
    }


    /**
     * Use to update data by where clause (mass update)
     *
     * @param array $whereClause
     * @param array $requestedData
     * @param array $columns
     * @param bool $isReturnObject
     * @return int|Model|null
     */
    public function updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = true): int|Collection|null
    {
        $updatedData = $this->model
            ->where($whereClause)
            ->update($requestedData);
        if (!$isReturnObject) return $updatedData;

        return $this->getAllData($whereClause, $columns);
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
