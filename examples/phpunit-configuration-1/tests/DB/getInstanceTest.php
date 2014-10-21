<?php
namespace tests\DB;

class DB_getInstance extends \PHPUnit_Framework_TestCase
{
	/**
	 * getInstance will return a DB instance
	 */
	public function testGetinstanceWillReturnADbInstance()
	{
		$this->assertInstanceOf('\DB', \DB::getInstance());
	}

	/**
	 * default value for instance is null
	 * if this test fails then you should add backupStaticAttributes = true in phpunit.xml
	 */
	public function testDefaultValueForInstanceIsNull()
	{
		$db = new \DB;
		$this->assertNull(\PHPUnit_Framework_Assert::readAttribute($db, 'instance'));
	}
}