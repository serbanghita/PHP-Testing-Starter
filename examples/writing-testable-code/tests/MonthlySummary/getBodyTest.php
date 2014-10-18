<?php
namespace tests\MonthlySummary;

class getBody extends \PHPUnit_Framework_TestCase
{
	/**
	 * default value for getBody() is known
	 */
	public function testDefaultValueForGetbodyIsKnown()
	{
		$expected = 'default mail body';
		$MonthlySummary = new \MonthlySummary();

		$response = $MonthlySummary->getBody();
		$this->assertEquals($expected, $response);
	}


	// because the getBody() method uses a private attribute, we'll have to change its value in order to test some corner cases
	
	/**
	 * when the translation is loaded then return the message
	 */
	public function testWhenTheTranslationIsLoadedThenReturnTheMessage()
	{
		$expected = 'custom mail message';
		$MonthlySummary = new \MonthlySummary();

		$refObject   = new \ReflectionObject($MonthlySummary);
		$refProperty = $refObject->getProperty('translation');
		$refProperty->setAccessible(true);
		$refProperty->setValue($MonthlySummary, array(
			'body' => 'custom mail message'
		));

		$response = $MonthlySummary->getBody();
		$this->assertEquals($expected, $response);
	}
	
	/**
	 * when the translation is not loaded then return false
	 */
	public function testWhenTheTranslationIsNotLoadedThenReturnFalse()
	{
		$expected = 'custom mail message';
		$MonthlySummary = new \MonthlySummary();

		$refObject   = new \ReflectionObject($MonthlySummary);
		$refProperty = $refObject->getProperty('translation');
		$refProperty->setAccessible(true);
		$refProperty->setValue($MonthlySummary, array(
			'subject' => 'Test'
		));

		$response = $MonthlySummary->getBody();
		$this->assertFalse($response);
	}
}