<?php
namespace UnitTests\DependsTest;

class Products
{
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function add($key, $value)
    {
        $this->products[$key] = $value;
    }

    public function remove($key)
    {
        unset($this->products[$key]);
    }

    public function get($key)
    {
        if (empty($key)) {
            throw new \InvalidArgumentException('Invalid key provided.');
        }
        return isset($this->products[$key]) ? $this->products[$key] : null;
    }

    public function getAll()
    {
        return $this->products;
    }
}