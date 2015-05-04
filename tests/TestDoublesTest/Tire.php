<?php
namespace UnitTests\TestDoublesTest;

class Tire {
    protected $pressure;
    protected $maker;

    public function __construct($tirePressure, TireMaker $tireMaker)
    {
        $this->pressure = $tirePressure;
        $this->maker = $tireMaker;
    }

    public function getPressure()
    {
        return (float)$this->pressure;
    }

    public function getMaker()
    {
        if (!$this->isValidMaker()) {
            throw new \Exception("Invalid tire maker", 1);
        }
        return $this->maker;
    }

    protected function isValidMaker()
    {
        return (!is_null($this->maker) && ($this->maker instanceof TireMaker));
    }
}
