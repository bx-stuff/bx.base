<?php
declare(strict_types=1);

namespace BX\Base\Options;


use Bitrix\Main\Application;

/**
 *  Интерфейс, организующий процесс отрисовки страницы настроек (Options) модуля
 */
abstract class OptionsPageAbstract implements OptionsPageInterface
{
    protected array $tabs = [];
    protected array $options = [];
    protected array $groups = [];
    protected array $optionsCodeList = [];
    protected string $moduleId;
    /**
     * @var \Bitrix\Main\HttpRequest|\Bitrix\Main\Request
     */
    protected $request;

    public function __construct()
    {
        $this->request = Application::getInstance()->getContext()->getRequest();
        $this->moduleId = $this->request->get('mid');
    }

    public abstract function display(): void;

    public function displaySelf(): void {}
}