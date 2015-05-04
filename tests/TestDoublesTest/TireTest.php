<?php
namespace UnitTests\TestDoublesTest\Tire;

class TireTest extends \PHPUnit_Framework_TestCase
{
    /**
     * building a stub and passing the constructor arguments will store the values to the stub
     */
    public function testBuildingAStubAndPassingTheConstructorArgumentsWillStoreTheValuesToTheStub()
    {
        $tireMakerDummy = $this->getMock('\UnitTests\TestDoublesTest\TireMaker');
        
        $tireStub = $this->getMockBuilder('\UnitTests\TestDoublesTest\Tire')
                     ->setConstructorArgs(array(2.5, $tireMakerDummy))
                     ->getMock();

        $this->assertEquals(2.5, $this->getProtectedValue($tireStub, 'pressure'));
    }

    /**
     * when mocking by ignoring the constructor then the attributes will not be set
     */
    public function testWhenMockingByIgnoringTheConstructorThenTheAttributesWillNotBeSet()
    {
        $tireStub = $this->getMockBuilder('\UnitTests\TestDoublesTest\Tire')
                     ->disableOriginalConstructor()
                     ->getMock();

        $this->assertNull($this->getProtectedValue($tireStub, 'pressure'));
    }

    /**
     * when mocking by using an extended object that overrides the behaviour then the value can be faked by the method definition
     */
    public function testWhenMockingByUsingAnExtendedObjectThatOverridesTheBehaviourThenTheValueCanBeFakedByTheMethodDefinition()
    {
        $tireUnderTestStub = new TireUnderTest(100);
        $this->assertEquals(123, $tireUnderTestStub->getPressure());
        $this->assertEquals(100, $this->getProtectedValue($tireUnderTestStub, 'pressure'));
    }

    /**
     * when mocking by using Mockery as a helper then protected methods can be faked
     */
    public function testWhenMockingByUsingMockeryAsAHelperThenProtectedMethodsCanBeFaked()
    {
        // makePartial will create a partial mock, ignoring the constructor
        $tireStub = \Mockery::mock('\UnitTests\TestDoublesTest\Tire')->makePartial();
        $tireStub->shouldAllowMockingProtectedMethods();

        $tireStub->shouldReceive('isValidMaker')->andReturn(true);

        $fakeMaker = new \stdClass();
        $fakeMaker->name = 'VW';

        $this->setProtectedValue($tireStub, 'maker', $fakeMaker);
        $this->assertSame($fakeMaker, $tireStub->getMaker());
    }

    protected function getProtectedValue($car, $propertyName)
    {
        $reflection = new \ReflectionClass($car);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        return $property->getValue($car);
    }

    protected function setProtectedValue($object, $attribute, $values = array())
    {
        $refObject   = new \ReflectionObject($object);
        $refProperty = $refObject->getProperty($attribute);
        $refProperty->setAccessible(true);
        $refProperty->setValue($object, $values);
    }
}

class TireUnderTest extends \UnitTests\TestDoublesTest\Tire
{
    public function __construct($tirePressure = 2, \UnitTests\TestDoublesTest\TireMaker $tireMaker = null)
    {
        $this->pressure = $tirePressure;
        $this->maker = $tireMaker;
    }

    public function getPressure()
    {
        return 123;
    }
}