<?php

declare(strict_types=1);

namespace BX\Base\Abstractions;

use BX\Base\Interfaces\DtoInterface;

class AbstractDto implements DtoInterface
{

    public string $connectionType;
    public string $method;

    protected array $entityMap;

    public function __construct(array $fields = [])
    {
        foreach ($fields as $key => $value) {
            $this->$key = $value;
        }
    }


    public function toArray(): array
    {
        return (array)$this;
    }

    public function getMap(): array
    {
        return $this->entityMap;
    }

    public function mapDataToEntity(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $dtoProperty => $value) {
            if (!empty($this->entityMap[$dtoProperty])) {
                $data[$this->entityMap[$dtoProperty]] = $value;
            }
        }

        return $data;
    }

}
