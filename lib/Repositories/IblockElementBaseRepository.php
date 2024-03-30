<?php

declare(strict_types=1);

namespace BX\Base\Repositories;

use Bitrix\Iblock\IblockTable;
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

    public function __construct($code = '')
    {
        if (!empty($code)) {
            $this->code = $code;
        }

        $this->setIblockIdAndCodeByApiCode();
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
