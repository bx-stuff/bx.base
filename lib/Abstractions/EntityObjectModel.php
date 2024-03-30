<?php

namespace BX\Base\Abstractions;

use Bitrix\Main\ORM\Objectify\EntityObject;
use Exception;

class EntityObjectModel extends AbstractModel
{
    /**
     * @param EntityObject $entityObject
     * @throws Exception
     */
    public function __construct(EntityObject $entityObject)
    {
        parent::__construct($entityObject);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this as $name => $value) {
            $result[$name] = $this->getEntityObjectValue($value);
        }

        return $result;
    }
}