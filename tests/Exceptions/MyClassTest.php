<?php
namespace UnitTests\Exceptions;

use Examples\Exceptions\MyClass;

class MyClassTest extends \PHPUnit_Framework_TestCase
{

    /**
     * instantiating the constructor with an empty string throws an exception
     * @expectedException \Exception
     */
    public function testInstantiatingTheConstructorWithAnEmptyStringThrowsAnException()
    {
        $myClass = new MyClass('');
    }


    /**
     * instantiating the constructor with a number and calling checkString will throw an exception
     * @expectedException \Exception
     */
    public function testInstantiatingTheConstructorWithANumberAndCallingCheckStringWillThrowAnException()
    {
        $myClass = new MyClass(11);
        $myClass->checkString();
    }


}