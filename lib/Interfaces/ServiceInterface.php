<?php

namespace BX\Base\Interfaces;

use Bitrix\Main\Result;

interface ServiceInterface
{
    public function getById(int $id): ?ModelInterface;

    public function getList(array $params = []): ?ModelCollectionInterface;

    public function save(ModelInterface $model): Result;

    public function delete(int $id): Result;
}