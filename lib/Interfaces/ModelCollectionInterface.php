<?php

namespace BX\Base\Interfaces;


interface ModelCollectionInterface extends CollectionInterface
{
    /**
     * @param string $key
     * @param string $className
     * @return ModelCollectionInterface
     */
    public function collection(string $key, string $className): ModelCollectionInterface;

    /**
     * @param array $modelData
     * @return void
     */
    public function add(array $modelData);
}
