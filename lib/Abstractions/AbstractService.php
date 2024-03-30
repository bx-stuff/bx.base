<?php


namespace BX\Base\Abstractions;

use Bitrix\Main\Result;
use BX\Base\Interfaces\ModelCollectionInterface;
use BX\Base\Interfaces\ModelInterface;
use BX\Log;
use BX\Base\Interfaces\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Bitrix\Main\ArgumentException
     */
    public function __construct()
    {
        $this->initiateVariables();
        $this->repository = $this->getRepository();
        $this->manager = $this->getManager();
    }

    abstract public function initiateVariables();
    abstract function getRepository();
    abstract function getManager();

    public function getById(int $id): ?ModelInterface
    {
        return $this->repository->getById($id);
    }

    public function getList(array $params = []): ?ModelCollectionInterface
    {
        return $this->repository->getList($params);
    }

    public function save(ModelInterface $model): Result
    {
        return $this->manager->save($model);
    }

    public function delete(int $id): Result
    {
        return $this->manager->delete($id);
    }
}
