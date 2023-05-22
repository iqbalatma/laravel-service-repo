<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Database\Eloquent\Collection;
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
     * @param int|array $id
     * @param array $columns
     * @return object|null
     */
    public function getDataById(int|array $id, array $columns = ["*"]): ?object
    {
        return $this->model->select($columns)->find($id);
    }


    /**
     * Get data with where clause
     * @param array $whereClause
     * @param array $columns
     * @return mixed
     */
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
