<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Iqbalatma\LaravelServiceRepo\BaseRepository;

interface RepositoryInterface
{
    public function filterColumn(array $filterableColumns): BaseRepository;
    public function getAllDataPaginated(array $whereClause = [], array $columns = ["*"]): LengthAwarePaginator;
    public function getAllData(array $whereClause = [], array $columns = ["*"]): Collection|null;
    public function getDataById(string|int|array $id, array $columns = ["*"]): Model|Collection|null;
    public function getSingleData(array $whereClause, array $columns = ["*"]):?Model;
    public function get():Collection|null;
    public function update(array $requestedData):int;
    public function delete():int;
    public function addNewData(array $requestedData): Model;
    public function updateDataById(string|int $id, array $requestedData, array $columns = ["*"], bool $isReturnObject = true): int|Model|null;
    public function updateDataByWhereClause(array $whereClause, array $requestedData, array $columns = ["*"], bool $isReturnObject = true): int|Collection|null;
    public function deleteDataById(string|int $id): int;
    public function deleteDataByWhereClause(array $whereClause): int;
}
