<?php

namespace BX\Base\Interfaces;

interface RepositoryInterface
{
    public function getById(int $id): ?ModelInterface;

    public function getList(array $params): ?ModelCollectionInterface;

}