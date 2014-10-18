<?php
namespace core;

abstract class CoreAbstract {

	protected static $config = array();

	// version 1
	public static function setConfig($config)
	{
		self::$config = $config;
	}

	public static function getConfig($key)
	{
		if (isset(self::$config[$key])) {
			return self::$config[$key];
		}
	}

	// version 2
	public static function setConfig2($config)
	{
		self::$config = $config;
	}

	public static function getConfig2($key)
	{
		if (isset(self::$config[$key])) {
			return self::$config[$key];
		}
	}
}
