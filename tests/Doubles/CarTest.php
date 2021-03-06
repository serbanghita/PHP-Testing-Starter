<?php
namespace UnitTests\Doubles;

use Examples\Doubles\Car;

class CarTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Instantiating the constructor without passing a non-empty string as a name to the constructor will trigger an exception
     * @expectedException \Exception
     * @expectedExceptionMessage Please provide a name for the car.
     * @dataProvider providerInvalidCarNames
     *
     * case: bad case for constructor
     */
    public function testInstantiatingTheConstructorWithoutPassingANonEmptyStringAsANameToTheConstructorWillTriggerAnException($carName)
    {
        new Car($carName);
    }

    public function providerInvalidCarNames()
    {
        $carNameObject = new \stdClass();
        $carNameObject->name = 'wagon';

        return array(
            array(''),
            array(array(0 => 'name')),
            array($carNameObject),
            array(true)
        );
    }

	/**
	 * Instantiating the constructor by passing a non-empty string will set the name for the car
     * case: good case for constructor
	 */
    public function testInstantiatingTheConstructorByPassingANonEmptyStringWillSetTheNameForTheCar()
	{
        $expectedCarName = 'FamilyVan';
		$car = new Car('FamilyVan');

        $carName = $this->getProtectedValue($car, 'modelName');
        $this->assertEquals($expectedCarName, $carName);
	}

	/**
	 * Calling setOwner requires that the input parameter should be an instance of Owner
     * case: fake object
	 */
    public function testCallingSetOwnerRequiresThatTheInputParameterShouldBeAnInstanceOfOwner()
	{
		$car = new Car('BlueCar');

        $owner = $this->getMock('\Examples\Doubles\Owner'); // this is a dummy
        $car->setOwner($owner);

        $currentOwner = $this->getProtectedValue($car, 'owner');
        $this->assertSame($owner, $currentOwner);
	}

    protected function getProtectedValue($car, $propertyName)
    {
        $reflection = new \ReflectionClass($car);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($car);
    }
}
