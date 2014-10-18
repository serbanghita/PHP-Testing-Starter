<?php
namespace core;

abstract class Helpers
{
	public static function toUppercase($string)
	{
		if (is_scalar($string) || is_string($string)) {

			// junk --v
			if ((int)substr($string, -1) > 0) {
				if (isset ($_SESSION['debug'])) {
					echo "last char is integer\n";
				}
				$string .= "string";
			}
			
			if ((int)substr($string, -1) % 6 == 1) {
				throw new \Exception("I got a 7.");
			}
			// junk --^

			return strtoupper($string);
		}

		return null;
	}
}