<?php

declare(strict_types=1);

namespace BX\Base\Repositories;

use Bitrix\Main\Loader;
use Bitrix\Main\UI\PageNavigation;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Abstractions\ModelCollection;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Traits\IblockTrait;

Loader::includeModule('iblock');

class IblockElementBaseRepository extends AbstractRepository
{
    use IblockTrait;

    protected string $iblockCode;
    protected int $iblockId;
    protected int $count = 0;

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
        $elements = $this->getList($params);

        return $elements->first();
    }

    /**
     * @param string $code
     * @param array $params
     * @return \BX\Base\Interfaces\CollectionItemInterface|null
     */
    public function getByCode(string $code, array $params = []): ?ModelInterface
    {
        $baseParams = [
            'filter' => [
                '=CODE' => $code
            ],
            'limit' => 1,
        ];

        $params = array_merge($baseParams, $params);
        $elements = $this->getList($params);

        return $elements->first();
    }

    public function getList(array $params = []): ModelCollection
    {
        $params['filter']['=IBLOCK_ID'] = $this->iblockId;

        if (empty($params['select'])) {
            $params['select'] = ['*'];
        }

        if (!empty($params['select_properties'])) {
            $propertyCodes = $params['select_properties'];

            if (!empty($params['property_fields'])) {
                $propertyFields = $params['property_fields'];
                unset($params['property_fields']);
            }

            unset($params['select_properties']);
            $params['select'] = ['ID'];
        }

        if (!empty($params['select_fields'])) {
           $params = $this->enrichByDetailPageUrl($params);
           $params['select'] = $params['select_fields'];
           unset($params['select_fields']);
        }

        if (isset($params['select_prices'])) {
            $isSelectPrices = $params['select_prices'];
            $params = $this->filterEnrichByPrices($params);
            unset($params['select_prices']);
        }

        $params['select'][] = 'ID';

        $iblockElementsList = $this->getElementFields($params);

        if (isset($propertyCodes)) {
            $iblockElementsList = $this->enrichByProperties(
                $params,
                $iblockElementsList,
                $propertyCodes,
                $propertyFields ?? ['ID']
            );
        }

        if (isset($isSelectPrices) && $isSelectPrices) {
            $iblockElementsList = $this->enrichByPrices(
                $params,
                $iblockElementsList
            );
        }

        return $this->getAsCollection($iblockElementsList);
    }

    public function getNavList(string $navName, int $itemsPerPage = 10, array $params = []): ModelCollection
    {

        $nav = new PageNavigation($navName);
        $nav->allowAllRecords(false)
            ->setPageSize($itemsPerPage)
            ->initFromUri();

        $params['limit'] = $nav->getLimit();
        $params['offset'] = $nav->getOffset();
        $params['count_total'] = true;

        $items = $this->getList($params);

        $nav->setRecordCount($items->getCount());

        $items->setNav($nav);

        return $items;
    }

    public function getActiveList(): ModelCollection
    {
        return $this->getList([
            'filter' => [
                '=ACTIVE' => 'Y'
            ]
        ]);
    }

    /**
     * @param array $params
     * @return mixed
     */
    private function getElementFields(array $params): mixed
    {
        $iblockElementClass = '\Bitrix\Iblock\Elements\Element' . ucfirst($this->code) . 'Table';
        $result = $iblockElementClass::getList($params);

        if ($params['count_total']) {
            $this->count = $result->getCount();
        }

        return $result->fetchAll();
    }

    private function enrichByProperties(array $params, array $iblockElementsList, array $propertyCodes, array $propertyFields = ['ID']): array
    {
        $properties = [];
        \CIBlockElement::GetPropertyValuesArray(
            $properties,
            $this->iblockId,
            $params['filter'],
            [
                'CODE' => $propertyCodes
            ],
            [
                'PROPERTY_FIELDS' => $propertyFields,
                'GET_RAW_DATA' => 'Y'
            ]
        );

        foreach ($iblockElementsList as $iblockElementKey => $iblockElement) {
            $iblockElementsList[$iblockElementKey]['PROPERTIES'] = $properties[$iblockElement['ID']];
        }

        return $iblockElementsList;
    }

    private function getAsCollection(array $iblockElementsList): ModelCollection
    {
        $modelClass = str_replace(['Repository', 'Repositories', 'Application'],
            ['', 'Models', 'Domain'],
            get_called_class());

        $collection = new ModelCollection($iblockElementsList, $modelClass);

        $collection->count = $this->count;

        return $collection;
    }

    private function enrichByDetailPageUrl(array $params): array
    {
        if (in_array('DETAIL_PAGE_URL', $params['select_fields'])) {
            $params['select_fields'] = array_diff($params['select'], ['DETAIL_PAGE_URL']);
            $params['select_fields']['DETAIL_PAGE_URL'] = 'IBLOCK.DETAIL_PAGE_URL';
            $params['select_fields'][] = '*';
        }

        return $params;
    }

}
