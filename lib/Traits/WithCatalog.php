<?php

namespace BX\Base\Traits;

use Bitrix\Catalog\PriceTable;
use Bitrix\Main\Loader;

Loader::includeModule('catalog');
Loader::includeModule('sale');

trait WithCatalog
{
    protected bool $isCatalog = true;

    public function enrichByPrices(array $params, array $iblockElementsList): array
    {
        foreach ($iblockElementsList as $iblockElementKey => $iblockElement) {
            $iblockElementsList[$iblockElementKey]['PRICES'] = \CCatalogProduct::GetOptimalPrice($iblockElement['ID']);
        }

        return $iblockElementsList;
    }

    public function filterEnrichByPrices(array $params): array
    {
        //TODO: исправить на релизе
        if (
            array_key_exists('!PRICE.PRICE', $params['filter'])
            || array_key_exists('>PRICE.PRICE', $params['filter'])
            || array_key_exists('<PRICE.PRICE', $params['filter'])
            || array_key_exists('<=PRICE.PRICE', $params['filter'])
            || array_key_exists('>=PRICE.PRICE', $params['filter'])
            || array_key_exists('PRICE.PRICE', $params['filter'])
        ) {
            if (!isset($params['runtime'])) {
                $params['runtime'] = [];
            }

            $params['runtime']['PRICE'] = [
                'data_type' => PriceTable::class,
                'reference' => [
                    '=this.ID' => 'ref.PRODUCT_ID',
                ]
            ];
            $params['select'][] = 'PRICE.PRICE';
        }

        return $params;
    }
}