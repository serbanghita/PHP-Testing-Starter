<?php

class MonthlySummary
{
	private $translation = array(
		'body' => 'default mail body'
	);

	public function getBody()
	{
		if (!isset($this->translation['body'])) {
			return false;
		}

		return $this->translation['body'];
	}
}