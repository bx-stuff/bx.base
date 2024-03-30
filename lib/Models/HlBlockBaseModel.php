<?php

declare(strict_types=1);

namespace BX\Base\Models;

use Bitrix\Main\Loader;
use Bitrix\Main\Result;
use BX\Base\Abstractions\AbstractModel;
use BX\Base\Traits\HlBlockTrait;

Loader::includeModule('highloadblock');

class HlBlockBaseModel extends AbstractModel
{
    use HlBlockTrait;

    public function __construct($data = [])
    {
        $this->initiateVariables();
        parent::__construct($data);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this['ID'];
    }

    /**
     * @param int $value
     * @return void
     */
    public function setId(int $value): void
    {
        $this['ID'] = $value;
    }

    /**
     * @param string $propertyCode
     * @param string $propertyValue
     * @return void
     */
    public function setProperty(string $propertyCode, mixed $propertyValue): void
    {
        $this[$propertyCode] = $propertyValue;
    }


    /**
     * @throws \Exception
     */
    public function save(): Result
    {
        $id = $this->getId();
        $data = $this->data;
        foreach ($data as $key => $value) {
            $newKey = 'UF_' . $key;
            $data[$newKey] = $value;
            unset($data[$key]);
        }


        if ($id > 0) {
            unset($data['ID']);
            return $this->hlBlock::update($id, $data);
        }

        return $this->hlBlock::add($data);
    }
}
