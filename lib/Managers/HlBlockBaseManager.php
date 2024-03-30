<?php

declare(strict_types=1);

namespace BX\Base\Managers;

use Bitrix\Main\Loader;
use Bitrix\Main\Result;
use BX\Base\Abstractions\AbstractManager;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Traits\HlBlockTrait;

Loader::includeModule('highloadblock');

class HlBlockBaseManager extends AbstractManager
{
    use HlBlockTrait;

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Bitrix\Main\ArgumentException
     */
    public function __construct()
    {
        $this->initiateVariables();
    }

    /**
     * @throws \Exception
     */
    public function delete(int $id): Result
    {
        return $this->hlBlock::delete($id);
    }

    public function save(ModelInterface $model): Result
    {
        return $model->save();
    }
}
