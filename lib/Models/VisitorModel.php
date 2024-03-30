<?php


namespace BX\Base\Models;

use Bitrix\Main\Application;
use Bitrix\Main\Result;
use BX\Base\Abstractions\AbstractModel;

class VisitorModel extends AbstractModel
{
    public function getIp(): string
    {
        return $this['SESS_IP'];
    }

    public function getField(string $key)
    {
        return $this['BX_VISITOR_' . $key];
    }

    public function setField(string $key, $value): VisitorModel
    {
        $this['BX_VISITOR_' . $key] = $value;
        return $this;
    }

    public function save(): Result
    {
        $result = new Result();
        $data = $this->toArray();

        if (!empty($data)) {
            $session = Application::getInstance()->getSession();
            foreach ($data as $key => $value) {
                $session->set($key, $value);
            }
        }

        return $result;
    }
}