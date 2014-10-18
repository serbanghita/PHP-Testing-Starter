<?php

class Crypto
{
	public static function getHash($string, $algorithm = 'md5')
	{
		$available_algos = hash_algos();
		
		if (!in_array($algorithm, $available_algos)) {
			return false;
		}

		return hash($algorithm, $string);
	}
}