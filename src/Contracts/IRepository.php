<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts;

use Iqbalatma\LaravelServiceRepo\BaseRepository;

interface IRepository
{
    public function filterColumn(array $filterableColumns): BaseRepository;
    public function getAllDataPaginated(array $columns = ["*"]): ?object;
    public function getAllData(array $columns = ["*"]): ?object;
    public function getDataById(int|array $id, array $columns = ["*"]): ?object;
    public function addNewData(array $requestedData): object;
    public function updateDataById(int $id, array $requestedData): int|object|null;
    public function deleteDataById(int $id): int;
}
