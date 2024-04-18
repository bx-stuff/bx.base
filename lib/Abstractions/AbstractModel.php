<?php


namespace BX\Base\Abstractions;

use ArrayIterator;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ORM\Objectify\EntityObject;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;
use BX\Base\Interfaces\DtoInterface;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Traits\EntityObjectHelper;
use BX\Log;
use Exception;
use Iterator;

abstract class AbstractModel implements ModelInterface
{
    use EntityObjectHelper;

    /**
     * @var array|EntityObject
     */
    protected $data;
    protected int $iblockId;
    protected string $iblockCode;
    protected Log $log;

    /**
     * @param mixed $data
     * @throws \ReflectionException
     */
    public function __construct(mixed $data = [])
    {
        if ($data === null) {
            return null;
        }

        if (!is_array($data) &&
            !($data instanceof EntityObject) &&
            !($data instanceof ModelInterface) &&
            !($data instanceof DtoInterface)
        ) {
            throw new Exception('Invalid data type');
        }

        $this->log = new Log('model');

        $this->data = $data;
        if ($data instanceof EntityObject) {
            $this->reflectEntityObject();
        }

        if ($data instanceof ModelInterface) {
            $this->data = $data;
        }

        if ($data instanceof DtoInterface) {
            $this->data = $data->mapDataToEntity();
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function assertValueByKey(string $key, $value): bool
    {
        return $this->hasValueKey($key) && $this->getValueByKey($key) == $value;
    }

    /**
     * @param string $key
     * @return boolean
     */
    public function hasValueKey(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getValueByKey(string $key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->getApiModel();
    }

    /**
     * @return array
     */
    public function getApiModel(): array
    {
        $result = $this->toArray();
        foreach ($result as &$value) {
            if ($value instanceof DateTime || $value instanceof \DateTime) {
                $value = $value->format('c');
                continue;
            }
            if ($value instanceof Date) {
                $value = $value->format('Y-m-d');
            }
        }
        unset($value);

        return $result;
    }

    public function toArray(): array
    {
        return current((array)$this);
    }

    /**
     * @param string $key
     * @return boolean
     * @deprecated
     */
    public function isFill(string $key): bool
    {
        return $this->hasValueKey($key);
    }

    /**
     * @param mixed $offset
     * @return bool
     * @throws ArgumentException
     * @throws SystemException
     */
    public function offsetExists($offset): bool
    {
        if ($this->data instanceof EntityObject) {
            return $this->data->offsetExists($offset);
        }

        return $this->hasValueKey($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     * @throws ArgumentException
     * @throws SystemException
     */
    public function offsetGet($offset)
    {
        if ($this->data instanceof EntityObject) {
            return $this->data->offsetGet($offset);
        }

        return $this->getValueByKey($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws ArgumentException
     * @throws SystemException
     */
    public function offsetSet($offset, $value)
    {
        if ($this->data instanceof EntityObject) {
            $this->data->offsetSet($offset, $value);
            return;
        }

        $this->data[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->data instanceof EntityObject) {
            $this->data->offsetUnset($offset);
            return;
        }

        if (isset($this->data[$offset])) {
            unset($this->data[$offset]);
        }
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        if ($this->data instanceof EntityObject) {
            return $this->getEntityObjectData();
        }

        return $this->data;
    }

    /**
     * @param callable $fnMap - function($item): array
     * @return mixed
     */
    public function map(callable $fnMap)
    {
        return $fnMap($this);
    }
}
