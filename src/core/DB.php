<?php
namespace core;

class DB extends CoreAbstract 
{
	protected static $DB;

	public static function init()
	{
		self::$DB = new PDO('mysql:dbname='.self::$config['dbname'].';host='.self::$config['dbhost'].';charset=utf8', self::$config['dbuser'], self::$config['dbpass']);
		self::$DB->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		self::$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public static function raw($SQL, $parameters = array())
	{
		if (!isset(self::$DB)) {
			self::init();
		}

		$DB = self::$DB;
		$SQL = $DB->prepare($SQL);

		if (!empty($parameters)) {
			foreach ($parameters as $field => $value) {
				$SQL->bindParam(':'.$field, $value);
			}
		}

		$SQL->execute();
		$results = array();

		try {
			while ($data = $SQL->fetch(PDO::FETCH_ASSOC)) {
				$results[] = $data;
			}
		} catch (Exception $e) {
			
		}

		return $results;
	}
	
	public static function get($table = "", $where = array(), $fields = array(), $limit = 1, $orderBy = "", $orderDirection = "ASC")
	{
		if (!isset(self::$DB)) {
			self::init();
		}

		// prepare where fields
		$merged_fields_prepared = '';
		if (!empty($where)) {
			$merged_fields_prepared = ' where ';

			$cursor = 0;
			foreach ($where as $where_key => $where_value) {
				if ($cursor > 0) {
					$merged_fields_prepared .= " and ";
				}

				$cursor++;
				$merged_fields_prepared .= ' '.$where_key.' = :'.$where_key.' ';
			}
		}

		// prepare order settings
		$order_prepared = '';
		if (!empty($orderBy)) {
			$order_prepared .= ' order by '.$orderBy.' '.$orderDirection.' ';
		}

		// prepare limit settings
		$limit_prepared = ' limit '.$limit.' ';

		$DB = self::$DB;
		$SQL = $DB->prepare('SELECT '.implode(',', $fields).' FROM '.$table.' '.$merged_fields_prepared.' '.$order_prepared.' '.$limit_prepared);

		if (!empty($where)) {
			foreach ($where as $where_key => $where_value) {
				$SQL->bindParam(':'.$where_key, $where_value);
			}
		}

		$SQL->execute();

		$results = array();
		while ($data = $SQL->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $data;
		}

		if ($limit == 1 && !empty($results)) {
			$results = $results[0];
		}

		return $results;
	}
}
