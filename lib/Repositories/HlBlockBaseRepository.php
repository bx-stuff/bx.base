<?php

declare(strict_types=1);

namespace BX\Base\Repositories;

use Bitrix\Main\Loader;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Abstractions\ModelCollection;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Traits\HlBlockTrait;

Loader::includeModule('highloadblock');

class HlBlockBaseRepository extends AbstractRepository
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
     * @param int $id
     * @param array $params
     * @return \BX\Base\Interfaces\CollectionItemInterface|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getById(int $id, array $params = []): ?ModelInterface
    {
        $baseParams = [
            'filter' => [
                '=ID' => $id
            ],
            'limit' => 1,
        ];

        $params = array_merge($baseParams, $params);

        return $this->getList($params)->first();
    }

    /**
     * @param array $params
     * @return \BX\Base\Abstractions\ModelCollection
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getList(array $params = []): ModelCollection
    {
        $iblockElementsList = $this->hlBlock::getList($params)->fetchAll();

        return new ModelCollection($iblockElementsList, $this->model::class);
    }

}
