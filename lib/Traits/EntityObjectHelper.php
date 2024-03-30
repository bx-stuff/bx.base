<?php

namespace BX\Base\Traits;

use Bitrix\Main\ORM\Objectify\Collection;
use Bitrix\Main\ORM\Objectify\EntityObject;
use BX\Base\Abstractions\EntityObjectModel;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\ModelCollection;
use Iterator;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

trait EntityObjectHelper
{
    /**
     * @var ReflectionClass
     */
    protected static ReflectionClass $reflectionClass;
    /**
     * @var ReflectionProperty
     */
    protected static ReflectionProperty $actualValuesProperty;
    /**
     * @var ReflectionProperty
     */
    protected static ReflectionProperty $currentValuesProperty;
    /**
     * @var ReflectionProperty
     */
    protected static ReflectionProperty $runtimeValuesProperty;
    /**
     * @var ReflectionProperty
     */
    protected static ReflectionProperty $customDataProperty;

    /**
     * @throws ReflectionException
     */
    protected function reflectEntityObject()
    {
        if (static::$reflectionClass instanceof ReflectionClass) {
            return;
        }

        static::$reflectionClass = new ReflectionClass(EntityObject::class);
        static::$actualValuesProperty = static::$reflectionClass->getProperty('_actualValues');
        static::$actualValuesProperty->setAccessible(true);

        static::$currentValuesProperty = static::$reflectionClass->getProperty('_currentValues');
        static::$currentValuesProperty->setAccessible(true);

        static::$runtimeValuesProperty = static::$reflectionClass->getProperty('_runtimeValues');
        static::$runtimeValuesProperty->setAccessible(true);

        static::$customDataProperty = static::$reflectionClass->getProperty('_customData');
        static::$customDataProperty->setAccessible(true);
    }

    /**
     * @return array
     */
    protected function getEntityObjectData(): array
    {
        $result = static::getInternalData($this->data);
        foreach ($result as &$value) {
            if ($value instanceof Collection) {
                $list = [];
                foreach ($value as $item) {
                    $list[] = static::getInternalData($item);
                }

                $value = $list;
            } elseif ($value instanceof EntityObject) {
                $value = static::getInternalData($value);
            }
        }
        unset($value);

        return $result;
    }

    protected static function getInternalData(EntityObject $object): array
    {
        $actualValues = static::$actualValuesProperty->getValue($object) ?? [];
        $currentValues = static::$currentValuesProperty->getValue($object) ?? [];
        $runtimeValues = static::$runtimeValuesProperty->getValue($object) ?? [];
        $customData = static::$customDataProperty->getValue($object) ?? [];

        return array_merge($actualValues, $currentValues, $runtimeValues, $customData);
    }

    /**
     * @param $value
     * @param string|null $defaultModelClass
     * @return mixed
     */
    protected function getEntityObjectValue($value, string $defaultModelClass = null)
    {
        if ($value instanceof Iterator) {
            $result = [];
            foreach ($value as $v) {
                $result[] = $this->getEntityObjectValue($v, $defaultModelClass);
            }

            $firstValue = current($result);
            if (count($result) > 0 && is_object($firstValue)) {
                $class = $firstValue instanceof ModelInterface ?
                    get_class($firstValue) :
                    $defaultModelClass ?? EntityObjectModel::class;

                return new ModelCollection($result, $class);
            }

            return $result;
        }

        return $value instanceof EntityObject ?
            (new static($value)) :
            $value;
    }
}
