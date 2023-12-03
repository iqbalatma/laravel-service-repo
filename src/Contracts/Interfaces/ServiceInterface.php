<?php

namespace Iqbalatma\LaravelServiceRepo\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ServiceInterface
{
    public function checkData(string|int $id, array $columns = ["*"]): bool;
    public function setRequestedData(array $requestedData): self;
    public function getRequestedData(string $key = null): array|string|null;
    public function getServiceEntity(): Model;
    public function setServiceEntity(Model $serviceEntity): self;
    public function isExists(mixed $data): void;
}
