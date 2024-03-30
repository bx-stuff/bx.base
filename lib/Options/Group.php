<?php

declare(strict_types=1);

namespace BX\Base\Options;


/**
 *  Класс, организующий процесс отрисовки Групп (Groups) на странице настроек модуля
 */
class Group extends OptionsPageAbstract
{
    private string $code;
    private string $name;

    /**
     * @param string $code
     * @param string $name
     */
    public function __construct(string $code, string $name)
    {
        parent::__construct();
        $this->code = $code;
        $this->name = $name ?: $code;
    }

    public function toArray(): array
    {
        return [
            'CODE' => $this->code,
            'NAME' => $this->name,
        ];
    }

    public function display(): void
    {
        echo '<tr class="heading"><td colspan="2">'.$this->name.'</td></tr>';
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
     * @return Group
     */
    public function setCode(string $code): Group
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Group
     */
    public function setName(string $name): Group
    {
        $this->name = $name;
        return $this;
    }


}