<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ServiceInterface
{
    public function getAllDataPaginated(): LengthAwarePaginator|array;

    public function getAllData(): Collection|array;

    public function getDataById(string|int $id): Model|array;

    public function addNewData(array $requestedData): Model|array;

    public function updateDataById(string|int $id, array $requestedData): Model|array;

    public function deleteDataById(string|int $id): int|array;
}
