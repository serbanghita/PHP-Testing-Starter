<?php
namespace Examples\DependsMock;

class ProductFactory
{
    public function build(array $specs) {
        return new Product($specs);
    }
}