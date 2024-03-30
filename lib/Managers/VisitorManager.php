<?php


namespace BX\Base\Managers;

use Bitrix\Main\Application;
use Bitrix\Main\Error;
use Bitrix\Main\Result;
use BX\Base\Abstractions\AbstractManager;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Models\VisitorModel;

class VisitorManager extends AbstractManager
{
    /**
     * @param VisitorModel $model
     * @return Result
     */
    public function save(ModelInterface $model): Result
    {
        $data = current((array)$model);
        return $this->update($model, $data);
    }

    /**
     * @param VisitorModel $model
     * @param array $data
     * @return void
     */
    public function update(ModelInterface $model, array $data): Result
    {
        foreach ($data as $key => $value) {
            if (!$model->hasValueKey($key)) {
                unset($data[$key]);
            }
        }

        return $this->updateWithNulls($model, $data);
    }

    /**
     * @param VisitorModel $model
     * @param array $data
     * @return Result
     */
    public function updateWithNulls(ModelInterface $model, array $data): Result
    {
        $data = $this->processFields($data);

        $result = new Result();

        if (!empty($data)) {
            $session = Application::getInstance()->getSession();
            foreach ($data as $key => $value) {
                $session->set($key, $value);
            }
        }

        return $result;
    }

    private function processFields(array $data): array
    {
        foreach ($data as $key => $value) {
            if (strpos($key, 'BX_VISITOR_') === false) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    public function delete(int $id): Result
    {
        $result = new Result();
        return $result->addError(new Error("Невозможно удалить данные посетителя"));
    }
}
