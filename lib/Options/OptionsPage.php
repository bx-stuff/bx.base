<?php

declare(strict_types=1);

namespace BX\Base\Options;


use Bitrix\Main\Localization\Loc;
use CAdminTabControl;

/**
 *  Класс, организующий процесс отрисовки страницы настроек (Options) модуля
 */

Loc::loadMessages($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/options.php');

class OptionsPage extends OptionsPageAbstract
{
    /**
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    public function __construct()
    {
        parent::__construct();
        if ($this->request->getRequestMethod() == 'POST') {
            $this->saveOptions();
        }
    }

    /**
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    private function saveOptions()
    {
        if (check_bitrix_sessid()) {
            foreach ($this->request->getPost('options') as $optionCode => $optionValue) {
                if (is_array($optionValue)) {
                    TrimArr($optionValue);
                    $optionValue = serialize(array_values($optionValue));
                }
                \Bitrix\Main\Config\Option::set($this->moduleId, $optionCode, $optionValue);
            }
        }

        LocalRedirect($this->request->getRequestUri() . '&message=' . urlencode((string)Loc::getMessage("BX_BASE_OPTIONS_PAGE_DATA_SAVED")));
    }

    public function addTab(string $code, string $name = ''): Tab
    {
        $tab = new Tab($code, $name);
        $this->tabs[$code] = $tab;
        return $tab;
    }

    public function display(): void
    {
        $tabsListForTabControl = $this->prepareTabsArray();
        $this->displaySelf();
        $tabControl = new CAdminTabControl('tabControl', $tabsListForTabControl);
        $tabControl->Begin();
        /** @var Tab $tab */
        foreach ($this->tabs as $tab) {
            $tabControl->BeginNextTab();
            $tab->display();
        }
        $tabControl->Buttons([]);
        $tabControl->End();
    }

    private function prepareTabsArray(): array
    {
        $tabs = [];
        /**
         * @var $string $key
         * @var Tab $tab
         */
        foreach ($this->tabs as $tab) {
            $tabs[] = $tab->toArray();
        }
        return $tabs;
    }

    public function displaySelf(): void
    {
        global $APPLICATION;

        $html = '<form name="' . $this->moduleId . '" method="POST" action="' . $APPLICATION->GetCurPage() . '?mid=' . $this->moduleId . '&lang=' . LANGUAGE_ID . '" enctype="multipart/form-data">' . bitrix_sessid_post();

        echo $html;
    }
}