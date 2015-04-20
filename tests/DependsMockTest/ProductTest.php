<?php
use UnitTests\DependsMockTest\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{

    /**
     * passing empty array to the constructor generates null valued product properties
     */
    public function testPassingEmptyArrayToTheConstructorGeneratesNullValuedProductProperties()
    {
        $p = new Product(array());
        $this->assertNull($p->getId());
        $this->assertNull($p->getCode());
        $this->assertNull($p->getPrice());
    }

    /**
     * passing a non empty array to the constructor returns the expected values from getters
     */
    public function testPassingANonEmptyArrayToTheConstructorReturnsTheExpectedValuesFromGetters()
    {
        $inputSpecs = array(
            'id' => 111,
            'code' => 'PR1',
            'price' => 100.30
        );
        $p = new Product($inputSpecs);
        $this->assertEquals(111, $p->getId());
        $this->assertEquals('PR1', $p->getCode());
        $this->assertEquals(100.30, $p->getPrice());
    }

    /**
     * setting a custom code is returned by get code
     */
    public function testSettingACustomCodeIsReturnedByGetCode()
    {
        $inputSpecs = array(
            'id' => 123,
            'code' => 'PR1',
            'price' => 100.30
        );
        $p = new Product($inputSpecs);
        $this->assertEquals('PR1', $p->getCode());

        $p->setCode('PR1.1');
        $this->assertEquals('PR1.1', $p->getCode());
    }


    /**
     * setting a custom price is returned by get price
     */
    public function testSettingACustomPriceIsReturnedByGetPrice()
    {
        $inputSpecs = array(
            'id' => 123,
            'code' => 'PR1',
            'price' => 100.30
        );
        $p = new Product($inputSpecs);
        $this->assertEquals(100.30, $p->getPrice());

        $p->setPrice(200);
        $this->assertEquals(200, $p->getPrice());
    }



}