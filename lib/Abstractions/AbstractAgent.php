<?php

namespace BX\Base\Abstractions;

use BX\Base\Interfaces\AgentInterface;

abstract class AbstractAgent implements AgentInterface
{
    abstract public function __invoke(): void;

    public static function run(): string
    {
        $className = get_called_class();
        (new $className)();

        return $className . '::run();';
    }
}