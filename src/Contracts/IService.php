<?php

namespace Iqbalatma\LaravelExtend\Contracts;

interface IService
{
    public function checkData(int $id): bool;
}
