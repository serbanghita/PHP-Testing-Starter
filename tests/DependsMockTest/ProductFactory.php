<?php
namespace UnitTests\DependsMockTest;

class ProductFactory
{
    public function build(array $specs) {
        return new Product($specs);
    }
}