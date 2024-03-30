<?php

namespace BX\Base\Interfaces;

use Bitrix\Main\Result;

interface ManagerInterface
{
    public function save(ModelInterface $model): Result;
    public function delete(int $id): Result;
}