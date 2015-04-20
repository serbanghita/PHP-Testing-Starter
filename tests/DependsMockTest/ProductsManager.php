<?php
namespace UnitTests\DependsMockTest;

class ProductsManager
{
    private $products;
    private $storage;

    public function __construct(Products $products, Storage $storage)
    {
        $this->products = $products;
        $this->storage = $storage;
    }

    public function saveOne($id)
    {
        $productInstance = $this->products->getProduct($id);
        if (!($productInstance instanceof Product)) {
            throw new \RuntimeException('Invalid product.');
        }
        return $this->storage->save($productInstance);
    }

    public function saveAll()
    {
        return $this->storage->save($this->products);
    }
}