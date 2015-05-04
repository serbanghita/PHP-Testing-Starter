<?php
namespace Examples\Doubles;

class Car {
    protected $modelName;
    protected $owner;

    public function __construct($modelName)
    {
        if (!is_string($modelName) || empty($modelName)) {
            throw new \Exception('Please provide a name for the car.');
        }

        $this->modelName = $modelName;
    }

    public function setOwner(Owner $owner)
    {
        $this->owner = $owner;
    }
}
