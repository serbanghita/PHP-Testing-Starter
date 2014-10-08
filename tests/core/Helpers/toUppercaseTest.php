<?php
namespace tests\core\Helpers;
use \core\Helpers as Helpers;

class ModelAbstract_getItem extends \PHPUnit_Framework_TestCase
{
	/**
	 * when passing valid a string then expect the return will be the uppercased version
	 * @dataProvider stringList
	 */
	public function testWhenPassingValidAStringThenExpectTheReturnWillBeTheUppercasedVersion($original_text)
	{
		$expected = strtoupper($original_text); // not great practice
		$result   = Helpers::toUppercase($original_text);
		$this->assertEquals($expected, $result);
	}

	public function stringList()
	{
		return array(
			array('aaaaa'),
			array('aaaab'),
			array('aaaac'),
			array('aXX00')
		);
	}
}