<?php


namespace BX\Base\Repositories;

use BX\Log;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\Model\Section;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Abstractions\ModelCollection;
use BX\Base\Interfaces\ModelInterface;

class IblockSectionBaseRepository extends AbstractRepository
{
    protected Log $log;
    protected string $iblockApiCode;
    protected string $iblockCode;
    protected int $iblockId;

    public function __construct()
    {
        $this->log = new Log();
        $this->setIblockId();
    }
    public function getIblockId(): int
    {
        return $this->iblockId;
    }

    public function getIblockCode(): string
    {
        return $this->iblockCode;
    }


    public function getIblockApiCode(): string
    {
        return $this->iblockApiCode;
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

        try {
            $fileList = $this->getList($params);
            return $fileList->first();
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }

        return null;
    }

    /**
     * @param int $code
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

        try {
            $fileList = $this->getList($params);
            return $fileList->first();
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }

        return null;
    }

    public function getList(array $params): ModelCollection
    {
        if (empty($params['select'])) {
            $params['select'] = [
                '*'
            ];
        }

        $sectionEntity = Section::compileEntityByIblock($this->iblockId);
        $section = [];
        try {
            $params['filter']['=IBLOCK_ID'] = $this->iblockId;
            $section = $sectionEntity::getList($params)->fetchAll();
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }

        $modelClass = str_replace(['Repository', 'Repositories'], ['Model', 'Models'], get_called_class());
        if (!class_exists($modelClass)) {
            $modelClass = str_replace(['Repository', 'Repositories'], ['', 'Models'], get_called_class());
        }

        return new ModelCollection($section, $modelClass);
    }

    protected function setIblockId()
    {
        try {
            $iblock = IblockTable::getList([
                'filter' => [
                    'API_CODE' => $this->iblockApiCode
                ],
                'limit' => 1,
                'cache' => [
                    'ttl' => 86400000
                ],
                'select' => ['ID']
            ])->fetch();
            $this->iblockId = (int)$iblock['ID'];
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }
    }

    /**
     * Список разделов по XML_ID
     * @return array
     */
    public function getListByXmlId()
    {
        if (empty($params['select'])) {
            $params['select'] = [
                'ID',
                'XML_ID'
            ];
        }

        $sectionEntity = Section::compileEntityByIblock($this->iblockId);
        $section = [];
        $sectionByXml = [];
        try {
            $params['filter']['=IBLOCK_ID'] = $this->iblockId;
            $section = $sectionEntity::getList($params)->fetchAll();
            foreach ($section as $item){
                if($item['XML_ID'] != ''){
                    $sectionByXml[$item['XML_ID']] = $item['ID'];
                }
            }
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }

        return $sectionByXml;
    }

    /**
     * Массив id разделов, чтобы проверить
     * что запрашиваемый раздел вообще есть
     * @return array
     */
    public function getListId()
    {
        if (empty($params['select'])) {
            $params['select'] = [
                'ID',
            ];
        }

        $sectionEntity = Section::compileEntityByIblock($this->iblockId);
        $section = [];
        $sectionById = [];
        try {
            $params['filter']['=IBLOCK_ID'] = $this->iblockId;
            $section = $sectionEntity::getList($params)->fetchAll();
            foreach ($section as $item){
                $sectionById[] = $item['ID'];

            }
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }

        return $sectionById;
    }
}
