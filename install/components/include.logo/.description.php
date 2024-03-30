<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = [
	"NAME" => Loc::getMessage("BX_INCLUDE_LOGO_DESCRIPTION"),
	"DESCRIPTION" => Loc::getMessage("BX_INCLUDE_LOGO_DESCRIPTION"),
	"ICON" => "/images/cat_all.gif",
	"CACHE_PATH" => "Y",
	"SORT" => 30,
];