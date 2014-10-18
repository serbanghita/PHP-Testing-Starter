<?php
namespace tests\core\CoreAbstract;

class CoreAbstract_setConfig extends \PHPUnit_Framework_TestCase
{
	/**
	 * (structure test) when the method is not called then config is an empty array
	 */
	public function testWhenTheMethodIsNotCalledThenConfigIsAnEmptyArray()
	{
		$emptyArray = array();
		$example = new Example_underTest_setConfig();

		$this->assertEquals($emptyArray, \PHPUnit_Framework_Assert::readAttribute($example, 'config'));
	}
	
	/**
	 * (best-case) when an array is passed as a parameter it is saved in the self::$config attribute.
	 */
	public function testWhenAnArrayIsPassedAsAParameterItIsSavedInTheSelfconfigAttribute()
	{
		$expected = array(
			'db.username' => 'user1',
			'db.password' => 'pass1',
			'db.hostname' => 'localhost'
		);
		
		$example = new Example_underTest_setConfig();
		$example::setConfig(array(
			'db.username' => 'user1',
			'db.password' => 'pass1',
			'db.hostname' => 'localhost'
		));

		$this->assertEquals($expected, \PHPUnit_Framework_Assert::readAttribute($example, 'config'));
	}
	
	/**
	 * (corner case) when a string is passed as a parameter then it is saved in the self::$config attribute
	 */
	public function testWhenAStringIsPassedAsAParameterThenItIsSavedInTheSelfconfigAttribute()
	{
		$expected = "test";

		$example = new Example_underTest_setConfig();
		$example::setConfig("test");

		$this->assertEquals($expected, \PHPUnit_Framework_Assert::readAttribute($example, 'config'));
	}
}

class Example_underTest_setConfig extends \core\CoreAbstract
{

}