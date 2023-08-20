<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Database\Eloquent\Model;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\ServiceInterface;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;

abstract class BaseService implements ServiceInterface
{
    /**
     * @var BaseRepository $repository
     */
    protected $repository;


    /**
     * @var Model $serviceEntity
     */
    protected Model $serviceEntity;

    /**
     * @var array $requestedData
     */
    protected array $requestedData;

    /**
     * Use to check is data exists
     * @param string|int $id
     * @param array $columns
     * @return bool
     * @throws EmptyDataException
     */
    public function checkData(string|int $id, array $columns = ["*"]): bool
    {
        $entity = $this->repository->getDataById($id);
        if (!$entity) {
            throw new EmptyDataException("Data doesn't exists !");
        }
        $this->setServiceEntity($entity);
        return true;
    }

    /**
     * Use to check data or entity exists
     *
     * @param mixed $data
     * @return void
     * @throws EmptyDataException
     */
    public function isExists(mixed $data): void
    {
        if ($data?->count() == 0 || !$data) {
            throw new EmptyDataException("Data doesn't exists !");
        }
    }

    /**
     * @param Model $serviceEntity
     * @return $this
     */
    public function setServiceEntity(Model $serviceEntity): self
    {
        $this->serviceEntity = $serviceEntity;
        return $this;
    }


    /**
     * @return Model
     */
    public function getServiceEntity(): Model
    {
        return $this->serviceEntity;
    }


    /**
     * @param array $requestedData
     * @return $this
     */
    public function setRequestedData(array $requestedData): self
    {
        $this->requestedData = $requestedData;
        return $this;
    }


    /**
     * @return array
     */
    public function getRequestedData(): array
    {
        return $this->requestedData;
    }
}
