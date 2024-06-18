<?php

declare(strict_types=1);

namespace BX\Base\Interfaces;

use Countable;
use IteratorAggregate;
use JsonSerializable;

interface ReadableCollectionInterface extends IteratorAggregate, Countable, JsonSerializable, MappableInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @return CollectionItemInterface|null
     */
    public function findByKey(string $key, mixed $value): ?CollectionItemInterface;

    /**
     * @param callable $fn - attribute CollectionItemInterface
     * @return CollectionItemInterface|null
     */
    public function find(callable $fn): ?CollectionItemInterface;

    /**
     * @param string $key
     * @param string|null $indexKey
     * @param callable|null $fnModifier - attribute is mixed value by the key of the collection item
     * @return array
     */
    public function column(string $key, string $indexKey = null, callable $fnModifier = null): array;

    /**
     * @param string $key
     * @param callable $fn - attribute is mixed value by the key of the collection item
     * @return array
     */
    public function unique(string $key, callable $fnModifier = null): array;

    /**
     * @param string $key
     * @return GroupCollectionInterface[]|ReadableCollectionInterface
     */
    public function groupByKey(string $key): ReadableCollectionInterface;

    /**
     * @param string $key
     * @param callable $fnCalcKeyValue - возвращает значение для группировки
     * @return GroupCollectionInterface[]|ReadableCollectionInterface
     */
    public function group(string $key, callable $fnCalcKeyValue): ReadableCollectionInterface;

    /**
     * @param string $key
     * @param mixed $value
     * @return \BX\Base\Interfaces\ReadableCollectionInterface
     */
    public function filterByKey(string $key, mixed $value): ReadableCollectionInterface;

    /**
     * @param callable $fn - attribute CollectionItemInterface
     * @return ReadableCollectionInterface
     */
    public function filter(callable $fn): ReadableCollectionInterface;

    public function first(): ?CollectionItemInterface;
}
