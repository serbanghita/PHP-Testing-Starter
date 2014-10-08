<?php
namespace tests\ModelAbstract;

class ModelAbstract_getTable extends \PHPUnit_Framework_TestCase
{
	/**
	 * getTable is defined
	 */
	public function testGettableIsDefined()
	{
		$class = new \ReflectionClass('\core\ModelAbstract');
		$method = $class->hasMethod('getTable');

		$this->assertTrue($method);
	}

	/**
	 * default table value is null
	 * @depends testGettableIsDefined
	 */
	public function testDefaultTableValueIsNull()
	{
		$o = new ExampleModel_underTest_getTable();

		// prepare method so that we can access it
		$class = new \ReflectionClass(get_class($o));
		$method = $class->getMethod('getTable');
		$method->setAccessible(true);

		$response = $method->invokeArgs($o, array()); // second argument is the method's parameter list

		// make assert
		$this->assertNull($response);
	}

	/**
	 * when table value is filled then return that value
	 */
	public function testWhenTableValueIsFilledThenReturnThatValue()
	{
		$expected = 'accounts_administrators';
		$model = new \Models\Administrator();

		// prepare method so that we can access it
		$class = new \ReflectionClass(get_class($model));
		$method = $class->getMethod('getTable');
		$method->setAccessible(true);

		$response = $method->invokeArgs($model, array()); // second argument is the method's parameter list

		// make assert
		$this->assertEquals($expected, $response);
	}
}

// because ModelAbstract is non-instantiate
class ExampleModel_underTest_getTable extends \core\ModelAbstract {

}