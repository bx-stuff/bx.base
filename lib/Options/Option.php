<?php

declare(strict_types=1);

namespace BX\Base\Options;


/**
 *  Класс, организующий процесс отрисовки Вкладок (Tabs) на странице настроек модуля
 */
class Option extends OptionsPageAbstract
{
    public const TYPE_STRING = 'STRING';
    public const TYPE_MULTI_STRING = 'MULTI_STRING';
    public const TYPE_CHECKBOX = 'CHECKBOX';
    public const TYPE_TEXT = 'TEXT';
    public const TYPE_SELECT = 'SELECT';
    public const TYPE_FILE = 'FILE';
    public const TYPE_INT = 'INT';

    private string $code;
    private string $type;
    private string $title;
    private string $group = '';
    private string $default = '';
    private int $size = 30;
    private int $maxlength = 255;
    private int $sort = 100;

    /**
     * @param string $code
     * @param string $name
     * @param string $type
     */
    public function __construct(string $code, string $name, string $type)
    {
        parent::__construct();
        $this->code = $code;
        $this->type = $type;
        $this->title = $name ?: $code;
    }

    public function toArray(): array
    {
        return [
            'CODE' => $this->getCode(),
            'TITLE' => $this->getTitle(),
            'DEFAULT' => $this->getDefault(),
            'TYPE' => $this->getType(),
            'SORT' => $this->getSort(),
            'SIZE' => $this->getSize(),
            'MAXLENGTH' => $this->getMaxlength(),
            'GROUP' => $this->getGroup(),
        ];
    }

    public function display(): void
    {
        switch ($this->getType()) {
            case self::TYPE_TEXT:
                $field = $this->getTextField();
                break;
            case self::TYPE_MULTI_STRING:
                $field = $this->getMultiInputField();
                break;
            default:
                $field = $this->getInputField();
        }

        echo '<tr><td>'.$this->getTitle().'</td><td nowrap>'.$field.'</td></tr>';
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Option
     */
    public function setCode(string $code): Option
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Option
     */
    public function setType(string $type): Option
    {
        $this->type = $type;
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
     * @return Option
     */
    public function setTitle(string $title): Option
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     * @return Option
     */
    public function setGroup(string $group): Option
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefault(): string
    {
        return $this->default;
    }

    /**
     * @param string $default
     * @return Option
     */
    public function setDefault(string $default): Option
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return Option
     */
    public function setSize(int $size): Option
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxlength(): int
    {
        return $this->maxlength;
    }

    /**
     * @param int $maxlength
     * @return Option
     */
    public function setMaxlength(int $maxlength): Option
    {
        $this->maxlength = $maxlength;
        return $this;
    }



    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     * @return Option
     */
    public function setSort(int $sort): Option
    {
        $this->sort = $sort;
        return $this;
    }

    private function getInputField(): string
    {
        $value = \Bitrix\Main\Config\Option::get($this->moduleId, $this->getCode());

        return '<input type="'.($this->getType() == self::TYPE_INT ? 'number' : 'text').'" size="'.$this->getSize().'" maxlength="'.$this->getMaxlength().'" value="'.$value.'" name="options['.htmlspecialchars($this->getCode()).']">';
    }

    private function getTextField(): string
    {
        $value = \Bitrix\Main\Config\Option::get($this->moduleId, $this->getCode());

        return '<textarea style="width: 500px; height: 300px;" name="options['.htmlspecialchars($this->getCode()).']">'.$value.'</textarea>';
    }

    private function getMultiInputField()
    {
        \Bitrix\Main\Loader::includeModule('iblock');
        \Bitrix\Main\Page\Asset::getInstance()->addJs('/bitrix/js/iblock/iblock_edit.js');
        require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/iblock/prolog.php');

        $value =  unserialize(\Bitrix\Main\Config\Option::get($this->moduleId, $this->getCode()));

        $fieldParams = [
            'NAME' => $this->getTitle(),
            'ACTIVE' => 'Y',
            'DEFAULT_VALUE' => '',
            'PROPERTY_TYPE' => 'S',
            'MULTIPLE' => 'Y',
            'MULTIPLE_CNT' => 3
        ];
        ob_start();
        _ShowPropertyField('options['.$this->getCode().']', $fieldParams, $value,false, false, 50000, $this->moduleId);

        return ob_get_clean();
    }
}