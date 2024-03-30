<?php

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = [
	"NAME" => Loc::getMessage("IS_INCLUDE_PHONE_DESCRIPTION_PHONE"),
	"DESCRIPTION" => Loc::getMessage("IS_INCLUDE_PHONE_DESCRIPTION_PHONE"),
	"ICON" => "/images/cat_all.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 10,
];