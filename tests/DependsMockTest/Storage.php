<?php
namespace UnitTests\DependsMockTest;

class Storage
{
    public function save($products)
    {
        $productsOutput = json_encode($products);
        $fp = fopen(dirname(__FILE__) . '/data.txt', 'w');
        fwrite($fp, $productsOutput);
        fclose($fp);

        return true;
    }
}