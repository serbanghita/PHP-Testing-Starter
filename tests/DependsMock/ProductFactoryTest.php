<?php
namespace UnitTests\DependsMock;

use Examples\DependsMock\ProductFactory;

class ProductFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Building a new product with random array returns an instance of Product
     */
    public function testBuildingANewProductWithRandomArrayReturnsAnInstanceOfProduct()
    {
        $inputSpecs = array(
            'code' => 'PR1',
            'price' => 100.30
        );
        $pf = new ProductFactory();

        $this->assertInstanceOf('Examples\DependsMock\Product', $pf->build($inputSpecs));
    }
}