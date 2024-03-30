<?php

declare(strict_types=1);

namespace BX\Base\Services;

use Bitrix\Main\Loader;
use BX\Base\Abstractions\AbstractService;
use BX\Base\Traits\HlBlockTrait;
use BX\Base\Traits\IblockTrait;

Loader::includeModule('iblock');

class IblockBaseService extends AbstractService
{
    use IblockTrait;
}
