<?php
namespace UnitTests\DependsMockTest;

use UnitTests\DependsMockTest\ProductFactory;

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

        $this->assertInstanceOf('UnitTests\\DependsMockTest\\Product', $pf->build($inputSpecs));
    }

}