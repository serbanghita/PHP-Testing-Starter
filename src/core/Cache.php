<?php
namespace core;

class Cache extends CoreAbstract
{
	public static function getCachePath()
	{
		return self::$config["cache_path"];
	}

	public static function get($key)
	{
		$file = static::getCachePath()."/".$key.".json";

		if (file_exists($file)) {
			return json_decode(file_get_contents($file));
		}

		return false;
	}

	public static function set($key, $storage, $life_seconds = 36000)
	{
		$file = static::getCachePath()."/".$key.".json";

		if (!file_exists(dirname($file))) {
			mkdir(dirname($file));
		}

		// $storage = array("data" => $storage, "ttl" => $life_seconds);
		file_put_contents($file, json_encode($storage));
	}

	public static function delete($key)
	{
		$file = static::getCachePath()."/".$key.".json";

		if (file_exists($file)) {
			unlink($file);
		}
	}
}
