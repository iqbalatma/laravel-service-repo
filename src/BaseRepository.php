<?php

namespace Iqbalatma\LaravelExtend;

use Iqbalatma\LaravelExtend\Interfaces\IRepository;
use Iqbalatma\LaravelExtend\Traits\RepositoryFilter;
use Iqbalatma\LaravelExtend\Traits\RepositorySearch;

abstract class BaseRepository implements IRepository
{
    use RepositoryFilter, RepositorySearch;
    protected const DEFAULT_PER_PAGE = 5;
    protected $model;

    /**
     * use with for relations
     * @param array $with
     * @return BaseRepository
     */
    public function with(array $with)
    {
        $this->model->with($with);

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
     * @param int|array $id
     * @param array $columns
     * @return object|null
     */
    public function getDataById(int|array $id, array $columns = ["*"]): ?object
    {
        $this->model->select($columns);
        $this->model = is_array($id) ?
            $this->model->find($id) :
            $this->model->where("id", $id)->first();
        return $this->model;
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
