<?php
namespace tests\Mailer;

class sendTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * if conditions are met will return true
	 */
	public function testIfConditionsAreMetWillReturnTrue()
	{
		$mailer = new \Mailer;
		$mailer::$serverOnline = true;

		$this->assertTrue($mailer->send('test content'));
	}
	
	/**
	 * if conditions are not met will return false
	 */
	public function testIfConditionsAreNotMetWillReturnFalse()
	{
		$mailer = new \Mailer;
		$mailer::$serverOnline = false;

		$this->assertFalse($mailer->send('test content'));
	}
}