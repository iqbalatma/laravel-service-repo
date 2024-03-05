<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ServiceInterface
{
    public function getAllDataPaginated(): LengthAwarePaginator;

    public function getAllData(): Collection|array;

    public function getDataById(string|int $id): Model;

    public function addNewData(array $requestedData): Model;

    public function updateDataById(string|int $id, array $requestedData): Model;

    public function deleteDataById(string|int $id): int;
}
