<?php


namespace BX\Base\Repositories;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Bitrix\Main\UserTable;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Abstractions\ModelCollection;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Models\UserModel;

class UserRepository extends AbstractRepository
{
    protected \BX\Log $log;

    public function __construct()
    {
        $this->log = new \BX\Log();
    }


    /**
     * @return UserModel
     */
    public function getCurrentUser(): ?UserModel
    {
        global $USER;
        $userId = (int)$USER->GetID();
        if (!$userId) {
            return null;
        }

        $user = $this->getById($userId);
        if (!($user instanceof UserModel)) {
            return null;
        }

        return $user;
    }

    /**
     * @param int $id
     * @return UserModel|\BX\Base\Interfaces\CollectionItemInterface|null
     */
    public function getById(int $id): ?ModelInterface
    {
        $params = [
            'filter' => [
                '=ID' => $id
            ],
            'limit' => 1,
        ];

        try {
            $fileList = $this->getList($params);
            return $fileList->first();
        } catch (ObjectPropertyException|ArgumentException|SystemException $e) {
            $this->log->error($e->getMessage(), $e->getTrace());
        }

        return null;
    }

    /**
     * @param array $params
     * @return \BX\Base\Abstractions\ModelCollection
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getList(array $params): ModelCollection
    {
        if (empty($params['select'])) {
            $params['select'] = [
                '*', 'UF_*'
            ];
        }
        $userList = UserTable::getList($params)->fetchAll();
        return new ModelCollection($userList, UserModel::class);
    }

    /**
     * @return bool
     */
    public function isAuthorized(): bool
    {
        global $USER;
        return (bool)($USER->IsAuthorized() ?? false);
    }
}
