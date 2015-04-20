<?php
namespace UnitTests\DependsMockTest;

class ProductManagerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Saving all products passed to the manager returns true
     */
    public function testSavingAllProductsPassedToTheManagerReturnsTrue()
    {
        $mockStorage = $this->getMockBuilder('\UnitTests\DependsMockTest\Storage')
                        ->setMethods(array('save'))
                        ->getMock();
        $mockStorage->method('save')->willReturn(true);

        $inputFirstProductSpecs = array(
            'id' => 11000,
            'code' => 'FP1',
            'price' => 10000
        );
        $inputSecondProductSpecs = array(
            'id' => 21000,
            'code' => 'FP2',
            'price' => 20000
        );
        $products = new Products(new ProductFactory());
        $products->addProduct($inputFirstProductSpecs);
        $products->addProduct($inputSecondProductSpecs);

        $productManager = new ProductsManager($products, $mockStorage);
        $this->assertTrue($productManager->saveAll());

        return $mockStorage;
    }

    /**
     * Saving one specific product from the products list to the manager returns true
     * @depends testSavingAllProductsPassedToTheManagerReturnsTrue
     * @param $mockStorage Storage
     * @return ProductsManager
     */
    public function testSavingOneSpecificProductFromTheProductsListToTheManagerReturnsTrue($mockStorage)
    {
        $inputProductSpecs = array(
            'id' => 13000,
            'code' => 'FP3',
            'price' => 30000
        );
        $products = new Products(new ProductFactory());
        $products->addProduct($inputProductSpecs);

        $productsManager = new ProductsManager($products, $mockStorage);
        // Because of https://github.com/sebastianbergmann/phpunit-mock-objects/issues/219
        $this->assertNull($productsManager->saveOne(13000));

        return $productsManager;
    }


    /**
     * Saving one specific product with a non existent id from the products list to the manager throws an exception
     * @depends testSavingOneSpecificProductFromTheProductsListToTheManagerReturnsTrue
     * @expectedException \RuntimeException
     * @param $productsManager ProductsManager
     */
    public function testSavingOneSpecificProductWithANonExistentIdFromTheProductsListToTheManagerThrowsAnException($productsManager)
    {
        $productsManager->saveOne(7777);
    }



}