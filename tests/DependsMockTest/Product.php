<?php
namespace UnitTests\DependsMockTest;

class Product
{
    private $id;
    private $code;
    private $price;

    public function __construct(array $specs)
    {
        $this->id = isset($specs['id']) ? $specs['id'] : null;
        $this->code = isset($specs['code']) ? $specs['code'] : null;
        $this->price = isset($specs['price']) ? (float)$specs['price'] : null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }
}