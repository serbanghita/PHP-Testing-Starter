<?php
namespace UnitTests\DependsTest;

class ProductsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * setting a valid array of products from constructor is returned by get all method
     */
    public function testSettingAValidArrayOfProductsFromConstructorIsReturnedByGetAllMethod()
    {
        $inputProducts = array(
            'PR1' => 'First Product Name',
            'PR2' => 'Second Product Name'
        );
        $products = new Products($inputProducts);

        $this->assertEquals($products->getAll(), $inputProducts);

        return $products;
    }

    /**
     * adding a new product to the existing products array is returned by get method
     * @depends testSettingAValidArrayOfProductsFromConstructorIsReturnedByGetAllMethod
     * @param $products Products
     */
    public function testAddingANewProductToTheExistingProductsArrayIsReturnedByGetMethod($products)
    {
        $products->add('PR3', 'Third Product Name');
        $this->assertEquals($products->get('PR3'), 'Third Product Name');
        $this->assertCount(3, $products->getAll());
    }


    /**
     * removing the first product from the products array is reflected by the get method
     * @depends testSettingAValidArrayOfProductsFromConstructorIsReturnedByGetAllMethod
     * @param $products Products
     */
    public function testRemovingTheFirstProductFromTheProductsArrayIsReflectedByTheGetMethod($products)
    {
        $products->remove('PR1');
        $this->assertCount(2, $products->getAll());
    }


    /**
     * getting a product by a key that no longer exists will return null
     * @depends testSettingAValidArrayOfProductsFromConstructorIsReturnedByGetAllMethod
     * @param $products Products
     */
    public function testGettingAProductByAKeyThatNoLongerExistsWillReturnNull($products)
    {
        $this->assertNull($products->get('PR1'));
    }


    /**
     * getting a product by an empty key value will throw an exception
     * @depends testSettingAValidArrayOfProductsFromConstructorIsReturnedByGetAllMethod
     * @expectedException \InvalidArgumentException
     * @param $products Products
     */
    public function testGettingAProductByAnEmptyKeyValueWillThrowAnException($products)
    {
        $products->get('');
    }



}