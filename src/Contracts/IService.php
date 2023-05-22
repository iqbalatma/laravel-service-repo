<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts;

interface IService
{
    public function checkData(string|int $id, array $columns = ["*"]): bool;
}
