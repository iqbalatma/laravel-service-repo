<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts;

interface IService
{
    public function checkData(int $id): bool;
}
