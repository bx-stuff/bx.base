<?php

declare(strict_types=1);

namespace BX\Base\Traits;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\ORM\Data\DataManager;
use BX\Base\Abstractions\AbstractManager;
use BX\Base\Abstractions\AbstractModel;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Interfaces\RepositoryInterface;
use BX\Base\Managers\IblockElementBaseManager;
use BX\Base\Models\HlBlockBaseModel;
use BX\Base\Models\IblockElementBaseModel;
use BX\Base\Repositories\IblockElementBaseRepository;

trait IblockTrait
{
    public string $code;

    private AbstractModel|IblockElementBaseModel $model;

    public AbstractRepository|IblockElementBaseRepository $repository;
    public AbstractManager|IblockElementBaseManager $manager;

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Bitrix\Main\ArgumentException
     */
    public function initiateVariables(): void
    {
        $this->model = $this->getModel();
        $this->code = $this->model->code;

        $this->repository = $this->getRepository();
        $this->manager = $this->getManager();
        $this->repository->setIblockIdAndCodeByApiCode();
    }

    private function getModel(): AbstractModel
    {
        $currentClass = get_called_class();

        $modelClass = str_replace(
            ['Repositories', 'Managers', 'Services', 'Repository', 'Manager', 'Service', 'Application'],
            ['Models', 'Models', 'Models', '', '', '', 'Domain'],
            $currentClass
        );

        return ($currentClass === $modelClass) ? $this : new $modelClass;
    }

    public function getRepository(): IblockElementBaseRepository
    {
        $currentClass = get_called_class();

        $modelClass = str_replace(
            ['Services', 'Service', 'Models'],
            ['Repositories', 'Repository', 'Repositories'],
            $currentClass
        );

        if (!str_contains($modelClass, 'Repository')) {
            $modelClass = $modelClass . 'Repository';
        }

        return ($currentClass === $modelClass) ? $this : new $modelClass($this->code);
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

        return ($currentClass === $modelClass) ? $this : new $modelClass;
    }
}
