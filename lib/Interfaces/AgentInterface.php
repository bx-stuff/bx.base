<?php

namespace BX\Base\Interfaces;

interface AgentInterface
{
    public function __invoke(): void;
    public static function run(): string;
}