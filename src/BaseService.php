<?php

namespace Iqbalatma\LaravelExtend;

use Iqbalatma\LaravelExtend\Exceptions\EmptyDataException;
use Iqbalatma\LaravelExtend\Interfaces\IService;

abstract class BaseService implements IService
{
    protected $repository;
    protected object $data;

    /**
     * Check is data exists by id
     *
     * @param int $id
     * @throws EmptyDataException
     * @return bool
     */
    public function checkData(int $id): bool
    {
        $this->setData($this->repository->getDataById($id));
        $isExist = $this->getData();
        if (!$isExist) {
            throw new EmptyDataException("Data doesn't exists !");
        }
        return true;
    }

    /**
     * @return object
     */
    public function getData(): object
    {
        return $this->data;
    }

    /**
     * @param object $data
     * @return self
     */
    public function setData(object $data): self
    {
        $this->data = $data;
        return $this;
    }
}
