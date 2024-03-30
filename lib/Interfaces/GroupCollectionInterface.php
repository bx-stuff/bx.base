<?php

namespace BX\Base\Interfaces;

interface GroupCollectionInterface extends CollectionInterface, CollectionItemInterface
{
    /**
     * @return mixed
     */
    public function getKey();

    /**
     * @return mixed
     */
    public function getValue();
}
