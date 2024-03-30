<?php

declare(strict_types=1);

namespace BX\Base\Interfaces;

interface DtoInterface
{
    /**
     * @return array
     */
    public function toArray(): array;

    public function getMap(): array;

    public function mapDataToEntity(): array;
}