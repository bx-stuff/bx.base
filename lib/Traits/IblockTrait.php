<?php

declare(strict_types=1);

namespace BX\Base\Traits;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\Loader;
use BX\Base\Abstractions\AbstractManager;
use BX\Base\Abstractions\AbstractModel;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Managers\IblockElementBaseManager;
use BX\Base\Managers\IblockSectionBaseManager;
use BX\Base\Models\IblockElementBaseModel;
use BX\Base\Models\IblockSectionBaseModel;
use BX\Base\Repositories\IblockElementBaseRepository;
use BX\Base\Repositories\IblockSectionBaseRepository;

Loader::includeModule('iblock');

trait IblockTrait
{
    public string $code;
    public AbstractRepository|IblockElementBaseRepository|IblockSectionBaseRepository $repository;
    public AbstractManager|IblockElementBaseManager|IblockSectionBaseManager $manager;
    private AbstractModel|IblockElementBaseModel|IblockSectionBaseModel $model;

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Bitrix\Main\ArgumentException
     */
    public function initiateVariables(): void
    {
        $this->setIblockApiCode();
        $this->repository = $this->getRepository();
        $this->manager = $this->getManager();
        $this->repository->setIblockIdAndCodeByApiCode();
    }

    private function setIblockApiCode(): void
    {
        $this->model = $this->getModel();
        $this->code = $this->model->code;
    }

    private function getModel(): AbstractModel
    {
        $currentClass = get_called_class();

        $modelClass = str_replace(
            ['Repositories', 'Managers', 'Services', 'Repository', 'Manager', 'Service', 'Application'],
            ['Models', 'Models', 'Models', '', '', '', 'Domain'],
            $currentClass
        );

        return ($currentClass === $modelClass) ? $this : new $modelClass();
    }

    public function getRepository()
    {
        $currentClass = get_called_class();

        $repositoryClass = str_replace(
            ['Services', 'Service', 'Models'],
            ['Repositories', 'Repository', 'Repositories'],
            $currentClass
        );
        if (!str_contains($repositoryClass, 'Repository')) {
            $repositoryClass = $repositoryClass . 'Repository';
        }

        return ($currentClass === $repositoryClass) ? $this : new $repositoryClass($this->code);
    }

    public function getManager(): AbstractManager
    {
        $currentClass = get_called_class();

        $modelClass = str_replace(
            ['Services', 'Service', 'Models'],
            ['Managers', 'Manager', 'Managers'],
            $currentClass
        );

        if (!str_ends_with($modelClass, 'Manager')) {
            $modelClass = $modelClass . 'Manager';
        }

        return ($currentClass === $modelClass) ? $this : new $modelClass($this->code);
    }


    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Bitrix\Main\ArgumentException
     */
    public function setIblockIdAndCodeByApiCode(): void
    {
        $iblock = IblockTable::getList([
            'filter' => [
                'API_CODE' => $this->code
            ],
            'limit' => 1,
            'cache' => [
                'ttl' => 86400000
            ],
            'select' => ['ID', 'CODE']
        ])->fetch();
        $this->iblockId = (int)$iblock['ID'];
        $this->iblockCode = (string)$iblock['CODE'];
    }
}
