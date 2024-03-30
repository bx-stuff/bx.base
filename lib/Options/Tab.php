<?php

declare(strict_types=1);

namespace BX\Base\Options;


/**
 *  Класс, организующий процесс отрисовки Вкладок (Tabs) на странице настроек модуля
 */
class Tab extends OptionsPageAbstract
{
    private string $div;
    private string $tab;
    private string $icon = '';
    private string $title;
    private string $onSelect = '';

    /**
     * @param string $code
     * @param string $name
     */
    public function __construct(string $code, string $name = '')
    {
        parent::__construct();
        $this->div = $code;
        $this->tab = $name ?: $code;
        $this->title = $name ?: $code;
    }

    public function toArray(): array
    {
        $groups = [];
        foreach ($this->groups as $group) {
            $groups[] = $group->toArray();
        }
        $options = [];
        foreach ($this->options as $option) {
            $options[] = $option->toArray();
        }
        return [
            'DIV' => $this->getDiv(),
            'TAB' => $this->getTab(),
            'GROUPS' => $groups,
            'OPTIONS' => $options,
            'ICON' => $this->getIcon(),
            'TITLE' => $this->getTitle(),
        ];
    }

    public function display(): void
    {
        /** @var \BX\Base\Options\Option $option */
        foreach ($this->getOptionsWoGroup() as $option) {
            $option->display();
        }
        /** @var \BX\Base\Options\Group $group */
        foreach ($this->groups as $group) {
            $group->display();
            foreach ($this->getGroupOptions($group->getCode()) as $option) {
                $option->display();
            }
        }
    }

    /**
     * @return string
     */
    public function getDiv(): string
    {
        return $this->div;
    }

    /**
     * @param string $div
     * @return Tab
     */
    public function setDiv(string $div): Tab
    {
        $this->div = $div;
        return $this;
    }

    /**
     * @return string
     */
    public function getTab(): string
    {
        return $this->tab;
    }

    /**
     * @param string $tab
     * @return Tab
     */
    public function setTab(string $tab): Tab
    {
        $this->tab = $tab;
        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return Tab
     */
    public function setIcon(string $icon): Tab
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Tab
     */
    public function setTitle(string $title): Tab
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return Tab
     */
    public function setOptions(array $options): Tab
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return string
     */
    public function getOnSelect(): string
    {
        return $this->onSelect;
    }

    /**
     * @param string $onSelect
     * @return Tab
     */
    public function setOnSelect(string $onSelect): Tab
    {
        $this->onSelect = $onSelect;
        return $this;
    }

    /**
     * @param string $code
     * @param string $type
     * @param string $name
     * @return \BX\Base\Options\Option
     */
    public function addOption(string $code, string $name = '', string $type = Option::TYPE_STRING): Option
    {
        $option = new Option($code, $name, $type);
        $this->options[] = $option;
        $this->optionsCodeList[] = $option->getCode();
        return $option;
    }

    public function addGroup(string $code, string $name = ''): Tab
    {
        $group = new Group($code, $name);
        $this->groups[] = $group;
        return $this;
    }

    private function getGroupOptions(string $code): array
    {
        $groupOptions = [];
        /** @var \BX\Base\Options\Option $option */
        foreach ($this->options as $option) {
            if ($option->getGroup() == $code) {
                $groupOptions[] = $option;
            }
        }
        return $groupOptions;
    }

    private function getOptionsWoGroup(): array
    {
        return $this->getGroupOptions('');
    }
}