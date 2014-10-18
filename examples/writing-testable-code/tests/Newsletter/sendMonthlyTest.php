<?php
namespace tests\Newsletter;

class sendMonthly extends \PHPUnit_Framework_TestCase
{
	/**
	 * sendMonthly will get the email body and pass it to the Mailers send method
	 */
	public function testSendmonthlyWillGetTheEmailBodyAndPassItToTheMailersSendMethod()
	{
		// in this test we'll control the getBody() response and catch it in the Mailer::send() method.
		// to simulate this, if the Mailer::send() doesn't receive the getBody() response that we mocked, then throw exception and use to fail the test.

		$newsletter = new Newsletter_underTest_sendMonthly();

		// mock MonthlySummary and specify that the getBody method will be stubbed (we'll control its behaviour)
		$mockMonthlySummary = $this->getMock('\MonthlySummary', array('getBody'));

		$mockMonthlySummary->expects($this->any())
			->method('getBody')->will($this->returnValue('<strong>This month ...</strong>'));

		Newsletter_underTest_sendMonthly::$mockMonthlySummary = $mockMonthlySummary;

		// mock Mailer instance
		$mockMailer = $this->getMock('\Mailer', array('getBody'));

		$mockMailer->expects($this->any())->method('send')->will($this->returnCallback(function($emailBody){
			if ($emailBody != '<strong>This month ...</strong>') {
				throw new \Exception("Error", 1);
			} else {
				// all good
				return func_get_args();
			}
		}));

		Newsletter_underTest_sendMonthly::$mockMailer = $mockMailer;

		// prepare
		try {
			$newsletter->sendMonthly();
			$this->assertTrue(true); // ugly but simple

		} catch (\Exception $e) {
			// if an Exception is thrown, the test should fail
			$this->fail('the getBody() response was not passed as Mailer::send()\'s argument.');
		}
	}
	
	/**
	 * sendMonthly will return the Mailers send() response
	 */
	public function testSendmonthlyWillReturnTheMailersSendResponse()
	{
		// this will not use mocks, but replacement classes with mocked responses
		$expected   = 'x8008';
		$newsletter = new Newsletter_underTest_sendMonthly_withClasses;

		$response = $newsletter->sendMonthly();
		$this->assertEquals($expected, $response);
	}
}

// method 1: mocks
class Newsletter_underTest_sendMonthly extends \Newsletter
{
	// hooks
	public static $mockMonthlySummary;
	public static $mockMailer;

	// overrides
	protected function getMonthlySummaryInstance()
	{
		return self::$mockMonthlySummary;
	}

	protected function getMailerInstance()
	{
		return self::$mockMailer;
	}
}

// method 2: classes / mocked method responses
class Newsletter_underTest_sendMonthly_withClasses extends \Newsletter
{
	protected function getMonthlySummaryInstance()
	{
		return new MonthlySummary_underTest_sendMonthly;
	}

	protected function getMailerInstance()
	{
		return new Mailer_underTest_sendMonthly;
	}
}

class MonthlySummary_underTest_sendMonthly
{
	public function getBody()
	{
		return '<span>mail message</span>';
	}
}

class Mailer_underTest_sendMonthly
{
	public static function send($input)
	{
		return 'x8008';
	}
}

