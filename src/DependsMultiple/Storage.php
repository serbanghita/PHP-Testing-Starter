<?php
namespace Examples\DependsMultiple;

class Storage
{
    private $storage = array();

    public function __construct($storage = null)
    {
        if (is_array($storage)) {
            $this->storage = $storage;
        }
    }

    public function add($key, $value)
    {
        $this->storage[$key] = $value;
    }

    public function remove($key)
    {
        unlink($this->storage);
    }

    public function getAll()
    {
        return $this->storage;
    }

    public function isEmpty()
    {
        return empty($this->storage);
    }

    public function merge(Storage $storage)
    {
        $newStorage = array_merge($this->getAll(), $storage->getAll());
        return new Storage($newStorage);

    }

}
