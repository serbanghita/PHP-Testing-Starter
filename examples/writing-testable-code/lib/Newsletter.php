<?php

/* * /
class Newsletter
{
	public function sendMonthly()
	{
		$MonthlySummary = new MonthlySummary();
		$emailBody      = $MonthlySummary->getBody();

		return Mailer::send($emailBody);
	}
}
/* */

class Newsletter
{
	public function sendMonthly()
	{
		$emailBody = $this->getMonthlySummaryInstance()->getBody();
		$Mailer    = $this->getMailerInstance();

		return $Mailer::send($emailBody);
	}

	protected function getMonthlySummaryInstance()
	{
		return new MonthlySummary();
	}

	protected function getMailerInstance()
	{
		return Mailer::getInstance();
	}
}