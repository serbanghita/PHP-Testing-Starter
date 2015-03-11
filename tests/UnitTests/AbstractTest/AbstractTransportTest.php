<?php
namespace UnitTests\AbstractTest;

class AbstractTransportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * set port sets the desired port
     */
    public function testSetPortSetsTheDesiredPort()
    {
        $inputPort = 8080;
        /**
         * @var $mock AbstractTransport
         */
        $mock = $this->getMockForAbstractClass('UnitTests\AbstractTest\AbstractTransport');
        $mock->setPort($inputPort);

        $this->assertEquals($inputPort, $mock->getPort());
    }
}