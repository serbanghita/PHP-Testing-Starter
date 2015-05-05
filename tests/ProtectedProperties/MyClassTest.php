<?php
namespace UnitTests\ProtectedProperties;

use Examples\ProtectedProperties\MyClass;

class MyClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * mapProduct returns the expected product string
     */
    public function testMapProductReturnsTheExpectedProductString()
    {
        $r = new \ReflectionObject($myClass = new MyClass());
        $m = $r->getMethod('mapProduct');
        $m->setAccessible(true);

        $this->assertEquals('Product999', $m->invoke($myClass, 999));
    }

    /**
     * mapCategory returns the expected product string
     */
    public function testMapCategoryReturnsTheExpectedProductString()
    {
        $r = new \ReflectionObject($myClass = new MyClass());
        $m = $r->getMethod('mapCategory');
        $m->setAccessible(true);

        $this->assertEquals('Category999', $m->invoke($myClass, 999));
    }

}