<?

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$ext = 'jpg,jpeg,gif,png,svg';

$arComponentParameters = [
	"GROUPS" => [
	],
	"PARAMETERS" => [
		"LOGO" => [
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage("BX_INCLUDE_LOGO_PARAMETERS_LOGO"),
			"TYPE" => "FILE",
            "FD_TARGET" => "F",
            "FD_EXT" => $ext,
            "FD_UPLOAD" => true,
            "FD_USE_MEDIALIB" => true,
            "FD_MEDIALIB_TYPES" => Array('video', 'sound')
		],
	],
];

