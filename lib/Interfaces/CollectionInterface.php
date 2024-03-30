<?php

namespace BX\Base\Interfaces;

interface CollectionInterface extends ReadableCollectionInterface
{
    /**
     * @param ModelInterface $item
     * @return void
     */
    public function append(ModelInterface $item);

    /**
     * @param ModelInterface $item
     * @return void
     */
    public function remove(ModelInterface $item);
}
