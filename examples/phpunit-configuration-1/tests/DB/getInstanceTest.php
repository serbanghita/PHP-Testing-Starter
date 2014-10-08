<?php
namespace tests\DB;

class DB_getInstance extends \PHPUnit_Framework_TestCase
{
	/**
	 * getInstance will return a DB instance
	 */
	public function testGetinstanceWillReturnADbInstance()
	{
		$this->assertInstanceOf('\DB', DB::getInstance());
	}
}