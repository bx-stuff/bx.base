<?php

use Bitrix\Main\Application;
use Symfony\Component\Dotenv\Dotenv;

if (file_exists(Application::getDocumentRoot() . '/local/vendor/autoload.php')) {
    include Application::getDocumentRoot() . '/local/vendor/autoload.php';
}

if (file_exists(Application::getDocumentRoot() . '/local/.env')) {
    $dotenv = new Dotenv();
    $dotenv->load(Application::getDocumentRoot() . '/local/.env');
}

include(__DIR__ . "/helpers.php");
