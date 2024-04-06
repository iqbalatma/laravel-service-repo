<?php

namespace Iqbalatma\LaravelServiceRepo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Iqbalatma\LaravelServiceRepo\Contracts\Interfaces\ServiceInterface;
use Iqbalatma\LaravelServiceRepo\Exceptions\DeleteDataThatStillUsedException;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;

abstract class BaseService implements ServiceInterface
{
    protected array $relationshipCheckBeforeDelete = [];

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
    protected function checkData(string|int $id, array $columns = ["*"]): bool
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
    protected function isExists(mixed $data): void
    {
        if (!$data || $data?->count() === 0) {
            throw new EmptyDataException("Data doesn't exists !");
        }
    }


    /**
     * @param Model $serviceEntity
     * @return $this
     */
    protected function setServiceEntity(Model $serviceEntity): self
    {
        $this->serviceEntity = $serviceEntity;
        return $this;
    }


    /**
     * @return Model
     */
    protected function getServiceEntity(): Model
    {
        return $this->serviceEntity;
    }


    /**
     * @param array $requestedData
     * @return $this
     */
    protected function setRequestedData(array $requestedData): self
    {
        $this->requestedData = $requestedData;
        return $this;
    }


    /**
     * @param string|null $keys
     * @return array|string|null
     */
    protected function getRequestedData(string $keys = null): array|string|null
    {
        $requestedData = $this->requestedData;
        if ($keys){
            $explodedKeys = explode(".", $keys);
            foreach ($explodedKeys as $explodedKey){
                $requestedData = is_array($requestedData) ?
                    ($requestedData[$explodedKey] ?? null) : null;
            }
        }
        return $requestedData;
    }


    /**
     * @return LengthAwarePaginator|array
     */
    public function getAllDataPaginated(): LengthAwarePaginator|array
    {
        return $this->repository->getAllDataPaginated();
    }

    /**
     * @return Collection|array
     */
    public function getAllData(): Collection|array
    {
        return $this->repository->getAllData();
    }

    /**
     * @param string|int $id
     * @return Model|array
     * @throws EmptyDataException
     */
    public function getDataById(string|int $id): Model|array
    {
        $this->checkData($id);

        return $this->getServiceEntity();
    }

    /**
     * @param array $requestedData
     * @return Model|array
     */
    public function addNewData(array $requestedData): Model|array
    {
        return $this->repository->addNewData($requestedData);
    }

    /**
     * @param string|int $id
     * @param array $requestedData
     * @return Model|array
     * @throws EmptyDataException
     */
    public function updateDataById(string|int $id, array $requestedData): Model|array
    {
        $this->checkData($id);

        $entity = $this->getServiceEntity();
        $entity->
        $entity->fill($requestedData)->save();

        return $entity;
    }


    /**
     * @param string|int $id
     * @return int|array
     * @throws DeleteDataThatStillUsedException
     * @throws EmptyDataException
     */
    public function deleteDataById(string|int $id): int|array
    {
        $this->checkData($id);
        $entity = $this->getServiceEntity();
        foreach ($this->relationshipCheckBeforeDelete as $relation) {
            if ($entity->{$relation}()->exists()) {
                throw new DeleteDataThatStillUsedException();
            }
        }

        return $entity->delete();
    }
}
