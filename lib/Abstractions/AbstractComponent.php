<?php

namespace BX\Base\Abstractions;

use BX\Log;
use CBitrixComponent;
use Throwable;

/**
 * Базовый компонент
 */
abstract class AbstractComponent extends CBitrixComponent
{
    protected Log $log;

    /**
     * @var bool Указывает необходимо ли кэшировать шаблон компонента (включено по-умолчанию)
     */
    protected bool $isCacheTemplate = true;

    protected array $cacheAdditionalId = [];
    protected string $cacheDir = '';

    /**
     * Выполнение компонента
     * @return $this Возвращает текущий экземпляр компонента
     */
    public function executeComponent(): static
    {
        $this->log = new Log();

        try {
            $this->run();
        } catch (Throwable $e) {
            $this->catchError($e);
        }
        return $this;
    }

    /**
     * Универсальный порядок выполнения простого компонента
     */
    final protected function run(): void
    {
        $this->executeProlog();

        if ($this->startCache()) {
            $this->executeMain();

            if ($this->isCacheTemplate) {
                $this->render();
            }

            $this->writeCache();
        }

        if (!$this->isCacheTemplate) {
            $this->render();
        }

        $this->executeEpilog();
    }

    /**
     * Выполняется до получения результатов. Не кэшируется
     */
    protected function executeProlog()
    {
    }

    /**
     * Инициализация кэширования
     * @return bool
     */
    private function startCache(): bool
    {
        global $USER;

        if (!empty($this->arParams['CACHE_TYPE']) &&
            $this->arParams['CACHE_TYPE'] !== 'N' &&
            $this->arParams['CACHE_TIME'] > 0) {
            if ($this->arParams['CACHE_GROUPS'] === 'Y') {
                $this->addCacheAdditionalId($USER->GetGroups());
            }

            if ($this->startResultCache($this->arParams['CACHE_TIME'], $this->cacheAdditionalId, $this->cacheDir)) {
                return true;
            }
            return false;
        }
        return true;
    }

    final protected function addCacheAdditionalId($id): void
    {
        $this->cacheAdditionalId[] = $id;
    }

    /**
     * Основная логика компонента.
     * Результат работы метода будет закэширован.
     */
    abstract protected function executeMain(): array;

    /**
     * Рендеринг шаблона компонента
     */
    private function render(): void
    {
        $this->includeComponentTemplate();
    }

    /**
     * Записывает результат кэширования на диск.
     */
    private function writeCache(): void
    {
        $this->endResultCache();
    }

    /**
     * Выполняется после получения результатов. Не кэшируется
     */
    protected function executeEpilog(): void
    {
    }

    protected function catchError(Throwable $exception): void
    {
        $this->abortCache();

        ShowError($exception->getMessage());
        $this->log->critical($exception->getMessage(), $exception->getTrace());
    }

    private function abortCache(): void
    {
        $this->abortResultCache();
    }
}
