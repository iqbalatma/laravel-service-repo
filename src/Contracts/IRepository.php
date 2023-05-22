<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Iqbalatma\LaravelServiceRepo\BaseRepository;

interface IRepository
{
    public function filterColumn(array $filterableColumns): BaseRepository;
    public function getAllDataPaginated(array $whereClause = [], array $columns = ["*"]): LengthAwarePaginator;
    public function getAllData(array $whereClause = [], array $columns = ["*"]): Collection;
    public function getDataById(int|array $id, array $columns = ["*"]): ?object;
    public function addNewData(array $requestedData): object;
    public function updateDataById(int $id, array $requestedData): int|object|null;
    public function deleteDataById(int $id): int;
}
