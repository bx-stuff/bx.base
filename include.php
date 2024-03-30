<?php

use Arrilot\BitrixBlade\BladeProvider;
use Bitrix\Main\Application;
use Symfony\Component\Dotenv\Dotenv;

if (file_exists(Application::getDocumentRoot() . '/local/vendor/autoload.php')) {
    include Application::getDocumentRoot() . '/local/vendor/autoload.php';
}

if (file_exists(Application::getDocumentRoot() . '/local/.env')) {
    $dotenv = new Dotenv();
    $dotenv->load(Application::getDocumentRoot() . '/local/.env');
}
