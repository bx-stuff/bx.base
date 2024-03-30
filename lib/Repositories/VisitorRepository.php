<?php


namespace BX\Base\Repositories;

use Bitrix\Main\Application;
use Bitrix\Main\Session\SessionInterface;
use BX\Base\Abstractions\AbstractRepository;
use BX\Base\Interfaces\ModelCollectionInterface;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Models\VisitorModel;

class VisitorRepository extends AbstractRepository
{
    private SessionInterface $session;

    public function __construct()
    {
        $this->session = Application::getInstance()->getSession();
    }

    public function getSessionField(string $field): string
    {
        return $this->session->get($field);
    }

    /**
     * @return VisitorModel
     * @throws \Exception
     */
    public function getCurrentVisitor(): ?ModelInterface
    {
        $sessionData = [];

        foreach ((array)$this->session as $key => $data) {
            if (is_array($data) && !empty($data['fixed_session_id'])) {
                $sessionData = $data;
                break;
            }
        }

        return new VisitorModel($sessionData);
    }

    public function getById(int $id): ?ModelInterface
    {
        return null;
    }

    public function getList(array $params): ?ModelCollectionInterface
    {
        return null;
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
