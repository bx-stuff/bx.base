<?php

declare(strict_types=1);

namespace BX\Base\Managers;

use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Bitrix\Main\Result;
use BX\Base\Abstractions\AbstractManager;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Traits\IblockTrait;
use CIBlockElement;

Loader::includeModule('iblock');

class IblockElementBaseManager extends AbstractManager
{


    public function delete(int $id): Result
    {
        $result = new Result();

        $isSuccess = CIBlockElement::Delete($id);
        if (!$isSuccess) {
            return $result->addError(new Error('Ошибка удаления элемента с id=' . $id, 500));
        }

        return $result;
    }

    public function save(ModelInterface $model): Result
    {
        return $model->save();
    }
}
