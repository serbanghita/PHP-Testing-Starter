<?php

class Mailer
{
	public static $serverOnline = true;
	private static $instance;

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new static;
		}

		return self::$instance;
	}

	public static function send($body)
	{
		if (self::$serverOnline) {
			// ...
			return true;
		}

		return false;
	}
}