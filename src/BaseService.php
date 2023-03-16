<?php

namespace Iqbalatma\LaravelServiceRepo;

use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;
use Iqbalatma\LaravelServiceRepo\Contracts\IService;

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
    public function checkData(int $id, array $columns = ["*"]): bool
    {
        $data = $this->repository->getDataById($id);
        if (!$data) {
            throw new EmptyDataException("Data doesn't exists !");
        }
        $this->setData($data);
        return true;
    }

    /**
     * Use to check is data exists
     *
     * @param [type] $data
     * @return boolean
     */
    public function isExists($data):void
    {
        $message = "Data doesn't exists !";
        if(!$data){
            throw new EmptyDataException($message);
        }
        if($data->count()==0){
            throw new EmptyDataException($message);
        }
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
