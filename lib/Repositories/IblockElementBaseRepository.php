<?php

declare(strict_types=1);

namespace BX\Base\Repositories;

use Bitrix\Main\Loader;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Abstractions\ModelCollection;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Traits\IblockTrait;
use CIBlockProperty;

Loader::includeModule('iblock');

class IblockElementBaseRepository extends AbstractRepository
{
    use IblockTrait;

    protected string $iblockCode;
    protected int $iblockId;

    public function __construct()
    {
        $this->setIblockApiCode();
        $this->setIblockIdAndCodeByApiCode();
    }

    /**
     * Получить ID инфоблока
     * @return int
     */
    public function getIblockId(): int
    {
        return $this->iblockId;
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

        $fileList = $this->getList($params);
        return $fileList->first();
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
        if (empty($params['select'])) {
            $params['select'] = [
                '*'
            ];
            $props = CIBlockProperty::GetList(['SORT' => 'ASC'], [
                'IBLOCK_CODE' => $this->iblockCode,
                'ACTIVE' => 'Y'
            ]);
            while ($prop = $props->Fetch()) {
                if ($prop['CODE'] !== 'IBLOCK_ID') {
                    $params['select'][$prop['CODE'] . '_VALUE'] = $prop['CODE'] . '.VALUE';
                }
            }
        }
        $params['filter']['=IBLOCK_ID'] = $this->iblockId;
        $iblockElementClass = '\Bitrix\Iblock\Elements\Element' . ucfirst($this->code) . 'Table';
        $iblockElementsList = $iblockElementClass::getList($params)->fetchAll();
        $modelClass = str_replace(['Repository', 'Repositories', 'Application'],
            ['', 'Models', 'Domain'],
            get_called_class());


        return new ModelCollection($iblockElementsList, $modelClass);
    }

    /**
     * @return \BX\Base\Abstractions\ModelCollection
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getActiveList(): ModelCollection
    {
        return $this->getList([
            'filter' => [
                'ACTIVE' => 'Y'
            ]
        ]);
    }

}
