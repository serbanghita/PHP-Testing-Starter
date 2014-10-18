<?php
namespace tests\core\CoreAbstract;

class CoreAbstract_getConfig2 extends \PHPUnit_Framework_TestCase
{
	/**
	 * (structure test) when the method is not called then config is an empty array
	 */
	public function testWhenTheMethodIsNotCalledThenConfigIsAnEmptyArray()
	{
		$emptyArray = array();
		$example = new Example_underTest_getConfig2();

		$this->assertEquals($emptyArray, \PHPUnit_Framework_Assert::readAttribute($example, 'config'));
	}
}

class Example_underTest_getConfig2 extends \core\CoreAbstract
{

}