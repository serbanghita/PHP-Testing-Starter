<?php
namespace UnitTests\Spy;

use Examples\Spy\LoggerInterface;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test the number of invocations
     */
    public function testTestTheNumberOfInvocations()
    {
        /**
         * @var $logger LoggerInterface
         */
        $logger = $this->getMock('\Examples\Spy\LoggerInterface');
        $logger
            ->expects($spy = $this->any())
            ->method('debug');

        $logger->debug('whateva');
        $logger->debug('omg');
        $logger->debug('no way, this is an error!');

        $invocations = $spy->getInvocations();

        $this->assertCount(3, $invocations, 'Different count of invocations of the debug method');
    }
}