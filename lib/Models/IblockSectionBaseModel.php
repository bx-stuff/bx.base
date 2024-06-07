<?php

namespace BX\Base\Models;

use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Bitrix\Main\Result;
use Bitrix\Main\Type\DateTime;
use BX\Base\Abstractions\AbstractModel;
use BX\Base\Traits\IblockTrait;

Loader::includeModule('iblock');

class IblockSectionBaseModel extends AbstractModel
{
    use IblockTrait;

    public function __construct(mixed $data = [])
    {
        parent::__construct($data);
        $this->setIblockIdAndCodeByApiCode();
        $this->setIblockId($this->iblockId);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'TIMESTAMP_X' => $this->getTimestampX(),
            'MODIFIED_BY' => $this->getModifiedBy(),
            'DATE_CREATE' => $this->getDateCreate(),
            'CREATED_BY' => $this->getCreatedBy(),
            'IBLOCK_ID' => $this->getIblockId(),
            'IBLOCK_SECTION_ID' => $this->getIblockSectionId(),
            'ACTIVE' => $this->getActive(),
            'GLOBAL_ACTIVE' => $this->getGlobalActive(),
            'SORT' => $this->getSort(),
            'NAME' => $this->getName(),
            'PICTURE' => $this->getPicture(),
            'PICTURE_SRC' => $this->getPictureSrc(),
            'DETAIL_PICTURE' => $this->getDetailPicture(),
            'DETAIL_PICTURE_SRC' => $this->getDetailPictureSrc(),
            'LEFT_MARGIN' => $this->getLeftMargin(),
            'RIGHT_MARGIN' => $this->getRightMargin(),
            'DEPTH_LEVEL' => $this->getDepthLevel(),
            'DESCRIPTION' => $this->getDescription(),
            'DESCRIPTION_TYPE' => $this->getDescriptionType(),
            'CODE' => $this->getCode(),
            'XML_ID' => $this->getXmlId()
        ];
    }

    /**
     * @param int $value
     * @return void
     */
    public function setId(int $value)
    {
        $this['ID'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setName(string $value)
    {
        $this['NAME'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setActive(string $value)
    {
        $this['ACTIVE'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setGlobalActive(string $value)
    {
        $this['GLOBAL_ACTIVE'] = $value;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setIblockId(int $value)
    {
        $this['IBLOCK_ID'] = $value;
    }

    /**
     * @param DateTime $value
     * @return void
     */
    public function setDateCreate(DateTime $value)
    {
        $this['DATE_CREATE'] = $value;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setSort(int $value)
    {
        $this['SORT'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setDescription(string $value)
    {
        $this['DESCRIPTION'] = $value;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setPicture(int $value)
    {
        $this['PICTURE'] = $value;
    }

    /**
     * @param int $value
     * @return void
     */
    public function setDetailPicture(int $value)
    {
        $this['DETAIL_PICTURE'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setCode(string $value)
    {
        $this['CODE'] = $value;
    }

    /**
     * @param string $value
     * @return void
     */
    public function setIblockSectionId(string $value)
    {
        $this['IBLOCK_SECTION_ID'] = $value;
    }

    /**
     * @param DateTime $value
     * @return void
     */
    public function setTimestampX(DateTime $value)
    {
        $this['TIMESTAMP_X'] = $value;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this['ID'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return (string)$this['NAME'];
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return (string)$this['ACTIVE'];
    }

    /**
     * @return string
     */
    public function getGlobalActive(): string
    {
        return (string)$this['GLOBAL_ACTIVE'];
    }

    /**
     * @return int
     */
    public function getIblockId(): int
    {
        return (int)$this['IBLOCK_ID'];
    }

    /**
     * @return ?DateTime
     */
    public function getDateCreate(): ?DateTime
    {
        return $this['DATE_CREATE'] instanceof DateTime ? $this['DATE_CREATE'] : null;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return (int)$this['SORT'];
    }

    /**
     * @return int
     */
    public function getPreviewPicture(): int
    {
        return (int)$this['PREVIEW_PICTURE'];
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return (string)$this['DESCRIPTION'];
    }

    /**
     * @return int
     */
    public function getPicture(): int
    {
        return (int)$this['PICTURE'];
    }

    public function getPictureSrc(): string
    {
        return (string)\CFile::GetPath($this->getPicture());
    }

    /**
     * @return int
     */
    public function getDetailPicture(): int
    {
        return (int)$this['DETAIL_PICTURE'];
    }

    public function getDetailPictureSrc(): string
    {
        return (string)\CFile::GetPath($this->getDetailPicture());
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return (string)$this['CODE'];
    }

    /**
     * @return int
     */
    public function getIblockSectionId(): int
    {
        return (int)$this['IBLOCK_SECTION_ID'];
    }

    /**
     * @return ?DateTime
     */
    public function getTimestampX(): ?DateTime
    {
        return $this['TIMESTAMP_X'] instanceof DateTime ? $this['TIMESTAMP_X'] : null;
    }

    public function getModifiedBy(): int
    {
        return (int)$this['MODIFIED_BY'];
    }

    public function setModifiedBy(int $value)
    {
        $this['MODIFIED_BY'] = $value;
    }

    public function getCreatedBy(): int
    {
        return (int)$this['CREATED_BY'];
    }

    public function setCreatedBy(int $value)
    {
        $this['CREATED_BY'] = $value;
    }

    public function getLeftMargin(): int
    {
        return (int)$this['LEFT_MARGIN'];
    }

    public function setLeftMargin(int $value)
    {
        $this['LEFT_MARGIN'] = $value;
    }

    public function getRightMargin(): int
    {
        return (int)$this['RIGHT_MARGIN'];
    }

    public function setRightMargin(int $value)
    {
        $this['RIGHT_MARGIN'] = $value;
    }

    public function getDepthLevel(): int
    {
        return (int)$this['DEPTH_LEVEL'];
    }

    public function setDepthLevel(int $value)
    {
        $this['DEPTH_LEVEL'] = $value;
    }

    public function getDescriptionType(): string
    {
        return (string)$this['DESCRIPTION_TYPE'];
    }

    public function setDescriptionType(string $value)
    {
        $this['DESCRIPTION_TYPE'] = $value;
    }
    public function getXmlId(): string
    {
        return (string)$this['XML_ID'];
    }

    public function setXmlId(string $value)
    {
        $this['XML_ID'] = $value;
    }

    public function isParent(): bool
    {
        return $this->getRightMargin() - $this->getLeftMargin() > 1;
    }

    public function save(): Result
    {
        $result = new Result();
        $section = new \CIBlockSection();

        $id = $this->getId();
        $data = $this->toArray();

        if ($id > 0) {
            unset($data['ID']);
            $isSuccess = (bool)$section->Update($id, $data);

            if (!$isSuccess) {
                return $result->addError(new Error("Ошибка обновления раздела инфоблока: {$section->LAST_ERROR}"));
            }

            return $result;
        }

        $id = (int)$section->Add($data);
        if (!$id) {
            $result->setLastId(0);
            return $result->addError(new Error("Ошибка добавления раздела инфоблока: {$section->LAST_ERROR}"));
        } else {
            $result->setLastId($id);
        }

        return $result;
    }
}
