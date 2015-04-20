<?php
namespace UnitTests\DependsMockTest;

class ProductsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Adding a product to the list is found by get product by id.
     */
    public function testAddingAProductToTheListIsFoundByGetProductById()
    {
        $inputProductSpecs = array(
            'id' => 1234,
            'code' => 'PR1',
            'price' => 100.10
        );
        $inputProductObj = new Product($inputProductSpecs);

        $products = new Products(new ProductFactory());
        $products->addProduct($inputProductSpecs);

        $this->assertEquals($inputProductObj, $products->getProduct(1234));

        return $products;
    }

    /**
     * Adding multiple products using an empty array as a product list throws an exception.
     * @depends testAddingAProductToTheListIsFoundByGetProductById
     * @expectedException \InvalidArgumentException
     * @param $products Products
     */
    public function testAddingMultipleProductsUsingAnEmptyArrayAsAProductListThrowsAnException($products)
    {
        $inputProductsSpecs = array();
        $products->addProducts($inputProductsSpecs);
    }

    /**
     * Adding multiple products to the existing product list works and the products are found by getProduct by id.
     * @depends testAddingAProductToTheListIsFoundByGetProductById
     * @param $products Products
     */
    public function testAddingMultipleProductsToTheExistingProductListWorksAndTheProductsAreFoundByGetProductById($products)
    {
        $inputProductsSpecs = array(
            array('id' => 2345, 'code' => 'PR2', 'price' => 200),
            array('id' => 5678, 'code' => 'PR3', 'price' => 300)
        );
        $products->addProducts($inputProductsSpecs);

        $inputProductObj = new Product($inputProductsSpecs[0]);
        $this->assertEquals($inputProductObj, $products->getProduct(2345));

        $inputProductObj = new Product($inputProductsSpecs[1]);
        $this->assertEquals($inputProductObj, $products->getProduct(5678));

        $this->assertCount(3, $products->getProducts());
    }


    /**
     * Getting an existing product by an invalid id from the existing product list throws an exception.
     * @depends testAddingAProductToTheListIsFoundByGetProductById
     * @expectedException \InvalidArgumentException
     * @param $products Products
     */
    public function testGettingAnExistingProductByAnInvalidIdFromTheExistingProductListThrowsAnException($products)
    {
        $products->getProduct(-99);
    }


    /**
     * Reset prices resets all the prices to zero from the existing product list
     * @depends testAddingAProductToTheListIsFoundByGetProductById
     * @param $products Products
     */
    public function testResetPricesResetsAllThePricesToZeroFromTheExistingProductList($products)
    {
        $products->resetPrices();
        $this->assertEquals(0, $products->getProduct(1234)->getPrice());
        $this->assertEquals(0, $products->getProduct(2345)->getPrice());
        $this->assertEquals(0, $products->getProduct(5678)->getPrice());
    }

}