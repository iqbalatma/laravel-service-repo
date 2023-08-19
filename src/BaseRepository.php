<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\RepositoryInterface;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryExtend;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryFilter;
use Iqbalatma\LaravelServiceRepo\Traits\RepositoryOrder;
use Iqbalatma\LaravelServiceRepo\Traits\RepositorySearch;


abstract class BaseRepository implements RepositoryInterface
{
    use RepositoryFilter, RepositorySearch, RepositoryExtend, RepositoryOrder;

    /**
     * @return self
     */
    public static function init(): self
    {
        $class = get_called_class();
        return new $class;
    }

    /**
     * @var Builder
     */
    protected Builder $query;

    /**
     * @return Collection|null
     */
    public function get(): Collection|null
    {
        return $this->query->get();
    }

    /**
     * @param array $requestedData
     * @return int
     */
    public function update(array $requestedData): int
    {
        return $this->query->update($requestedData);
    }


    /**
     * @return int
     */
    public function delete(): int
    {
        return $this->query->delete();
    }

    /**
     * Use to get all data with pagination and where clause as optional param
     *
     * @param array $whereClause
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function getAllDataPaginated(array $whereClause = [], array $columns = ["*"]): LengthAwarePaginator
    {
        return $this->query
            ->select($columns)
            ->where($whereClause)
            ->paginate(request()->query("perpage", config("servicerepo.perpage")));
    }


    /**
     * @param array $whereClause
     * @param array $columns
     * @return Collection|null
     */
    public function getAllData(array $whereClause = [], array $columns = ["*"]): Collection|null
    {
        return $this->query
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
    public function getDataById(string|int|array $id, array $columns = ["*"]): Model|Collection|null
    {
        return $this->query->select($columns)->find($id);
    }


    /**
     * Get single data with where clause
     *
     * @param array $whereClause
     * @param array $columns
     * @return Model|null
     */
    public function getSingleData(array $whereClause = [], array $columns = ["*"]): ?Model
    {
        return $this->query
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
        return $this->query->create($requestedData);
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
        $updatedData = $this->query
            ->where("id", $id)
            ->update($requestedData);
        if (!$isReturnObject) return $updatedData;

        return $this->query->find($id, $columns);
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
    public function updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = false): int|Collection|null
    {
        $updatedData = $this->query
            ->where($whereClause)
            ->update($requestedData);
        if (!$isReturnObject) return $updatedData;

        return $this->getAllData($whereClause, $columns);
    }


    /**
     * Use to delete data model by id (single delete)
     *
     * @param string|int $id
     * @return int
     */
    public function deleteDataById(string|int $id): int
    {
        return $this->query
            ->where("id", $id)
            ->delete();
    }


    /**
     * Use to delete data model by where clause(mass delete)
     *
     * @param array $whereClause
     * @return int
     */
    public function deleteDataByWhereClause(array $whereClause): int
    {
        return $this->query
            ->where($whereClause)
            ->delete();
    }
}
