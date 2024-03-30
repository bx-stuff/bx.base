<?php

declare(strict_types=1);

namespace BX\Base\Traits;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\ORM\Data\DataManager;
use BX\Base\Abstractions\AbstractManager;
use BX\Base\Abstractions\AbstractModel;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Models\HlBlockBaseModel;

trait HlBlockTrait
{
    protected string $code;

    private DataManager|string $hlBlock;

    private AbstractModel|HlBlockBaseModel $model;

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Bitrix\Main\ArgumentException
     */
    public function initiateVariables(): void
    {
        $this->model = $this->getModel();
        $this->code = $this->model->code;
        $this->hlBlock = $this->getHlBlockClass($this->code);
    }

    public function getModel(): AbstractModel
    {
        $currentClass = get_called_class();

        $modelClass = str_replace(
            ['Repositories', 'Managers', 'Services', 'Repository', 'Manager', 'Service', 'Application'],
            ['Models', 'Models', 'Models', '', '', '', 'Domain'],
            $currentClass
        );

        return ($currentClass === $modelClass) ? $this : new $modelClass;
    }

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Bitrix\Main\ArgumentException
     */
    public function getHlBlockClass(string $hlBlockCode): DataManager|string
    {
        $id = $this->getHlBlockIdByCode($hlBlockCode);
        $hlBlock = HighloadBlockTable::getById($id)->fetch();
        $hlBlockEntity = HighloadBlockTable::compileEntity($hlBlock);

        return $hlBlockEntity->getDataClass();
    }

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Bitrix\Main\ArgumentException
     */
    protected function getHlBlockIdByCode(string $code): int
    {
        $hlBlock = HighloadBlockTable::getList([
            'filter' => ['=NAME' => $code],
            'select' => ['ID'],
            'cache' => ['ttl' => 864000000]
        ])->fetch();

        return (int)$hlBlock['ID'];
    }

    public function getRepository(): AbstractRepository
    {
        $currentClass = get_called_class();

        $modelClass = str_replace(
            ['Services', 'Service'],
            ['Repositories', 'Repository'],
            $currentClass
        );

        return ($currentClass === $modelClass) ? $this : new $modelClass;
    }

    public function getManager(): AbstractManager
    {
        $currentClass = get_called_class();

        $modelClass = str_replace(
            ['Services', 'Service'],
            ['Managers', 'Manager'],
            $currentClass
        );

        return ($currentClass === $modelClass) ? $this : new $modelClass;
    }
}
