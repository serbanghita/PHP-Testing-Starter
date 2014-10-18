<?php
namespace tests\Mailer;

class getInstance extends \PHPUnit_Framework_TestCase
{
	/**
	 * getInstance will return an instance of Mailer
	 */
	public function testGetinstanceWillReturnAnInstanceOfMailer()
	{
		$Mailer = new \Mailer();

		$response = $Mailer::getInstance();
		$this->assertInstanceOf('\Mailer', $response);

		// note: there was an error that the test catched: 
		// getInstance() contained "if (!is_null(self::$instance))" instead of "if (is_null(self::$instance))"
	}
	
	/**
	 * getInstance will store the created instance
	 */
	public function testGetinstanceWillStoreTheCreatedInstance()
	{
		$Mailer = new \Mailer();
		$this->assertNull(\PHPUnit_Framework_Assert::readAttribute($Mailer, 'instance'));

		$response = $Mailer::getInstance();
		$this->assertSame($response, \PHPUnit_Framework_Assert::readAttribute($Mailer, 'instance'));
	}
	
	/**
	 * if it already stored then will return same instance
	 */
	public function testIfItAlreadyStoredThenWillReturnSameInstance()
	{
		$Mailer = new \Mailer();

		$storedInstance = new \stdClass;

		$refObject   = new \ReflectionObject($Mailer);
		$refProperty = $refObject->getProperty('instance');
		$refProperty->setAccessible(true);
		$refProperty->setValue($Mailer, $storedInstance);

		$response = $Mailer::getInstance();
		$this->assertSame($storedInstance, $response);
	}

	public function setUp()
	{
		// cleaning is necessary to ensure no static cargo is left between the tests.

		$Mailer = new \Mailer();
		$refObject   = new \ReflectionObject($Mailer);
		$refProperty = $refObject->getProperty('instance');
		$refProperty->setAccessible(true);
		$refProperty->setValue($Mailer, null);
	}
}