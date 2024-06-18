<?php


namespace BX\Base\Abstractions;

use Bitrix\Main\UI\PageNavigation;
use BX\Base\Interfaces\CollectionInterface;
use BX\Base\Interfaces\CollectionItemInterface;
use BX\Base\Interfaces\ModelCollectionInterface;
use BX\Base\Interfaces\ModelInterface;
use BX\Base\Interfaces\ReadableCollectionInterface;
use SplObjectStorage;
use Traversable;

class ModelCollection extends Collection implements ModelCollectionInterface
{
    /**
     * @var ModelInterface[]|CollectionItemInterface[]|SplObjectStorage
     */
    protected $items;
    /**
     * @var string
     */
    protected string $className;

    public int $count = 0;
    protected PageNavigation $nav;

    public function __construct($list, string $className)
    {
        $this->items = new SplObjectStorage();

        $this->className = $className;
        foreach ($list as $item) {
            if ($item instanceof $className) {
                $this->items->attach($item);
            } elseif (is_array($item) || $item instanceof Traversable) {
                $this->items->attach(new $className($item));
            }
        }
    }

    /**
     * @param ModelInterface $model
     * @return void
     * @deprecated
     */
    public function addModel(ModelInterface $model): void
    {
        $this->append($model);
    }

    /**
     * @param CollectionItemInterface $item
     * @return void
     */
    public function append(CollectionItemInterface $item): void
    {
        if ($item instanceof $this->className) {
            $this->items->attach($item);
        }
    }

    /**
     * @param string $key
     * @param string $className
     * @return ModelCollectionInterface
     */
    public function collection(string $key, string $className): ModelCollectionInterface
    {
        $result = new ModelCollection([], $className);
        $list = $this->column($key);
        foreach ($list as $item) {
            $this->addItemInCollection($result, $item);
        }

        return $result;
    }

    /**
     * @param ModelCollectionInterface $collection
     * @param mixed $item
     * @return void
     */
    private function addItemInCollection(ModelCollectionInterface $collection, $item): void
    {
        if ($item instanceof CollectionItemInterface) {
            $collection->append($item);
        } elseif (is_array($item)) {
            $collection->add($item);
        } elseif ($item instanceof CollectionInterface) {
            foreach ($item as $subItem) {
                $this->addItemInCollection($collection, $subItem);
            }
        }
    }

    public function add(array $modelData)
    {
        $this->append(new $this->className($modelData));
    }

    /**
     * @param string $fieldName
     * @param $value
     * @return ModelInterface|null
     */
    public function findByColumn(string $fieldName, $value): ?CollectionItemInterface
    {
        return $this->find(function ($item) use ($fieldName, $value)
        {
            return isset($item[$fieldName]) && $item[$fieldName] == $value;
        });
    }

    /**
     * @param int $index
     * @return ModelInterface|null
     */
    public function getByIndex(int $index): ?ModelInterface
    {
        $list = iterator_to_array($this->items) ?? [];
        return $list[$index] ?? null;
    }

    /**
     * @return array
     */
    public function getApiModel(): array
    {
        $result = [];
        foreach ($this as $item) {
            $result[] = $item->jsonSerialize();
        }

        return $result;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->getApiModel();
    }


    /**
     * @param $list
     * @return ReadableCollectionInterface
     */
    protected function newCollection($list): ReadableCollectionInterface
    {
        return new static($list, $this->className);
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getNav(): PageNavigation
    {
        return $this->nav;
    }

    public function setNav(PageNavigation $nav)
    {
        $this->nav = $nav;
    }
}
