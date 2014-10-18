<?php
namespace tests\core\CoreAbstract;

class CoreAbstract_getConfig extends \PHPUnit_Framework_TestCase
{

	/**
	 * (structure test) when the method is not called then config is an empty array
	 */
	public function testWhenTheMethodIsNotCalledThenConfigIsAnEmptyArray()
	{
		$emptyArray = array();
		$example = new Example_underTest_getConfig();

		$this->assertEquals($emptyArray, \PHPUnit_Framework_Assert::readAttribute($example, 'config'));
	}
}

class Example_underTest_getConfig extends \core\CoreAbstract
{

}