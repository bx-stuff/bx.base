<?php

use Bitrix\Main\Localization\Loc;
use BX\Base\Options\OptionsPage;


Loc::loadMessages(__FILE__);

$optionsPage = new OptionsPage();

// Вкладка "Настройки"
$settingsTab = $optionsPage->addTab('settings', Loc::getMessage("BX_BASE_OPTIONS_SETTINGS"));

$optionsPage->display();