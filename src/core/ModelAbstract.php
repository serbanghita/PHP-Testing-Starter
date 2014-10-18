<?php
namespace core;

abstract class ModelAbstract extends DB
{
	protected $table;
	public static $hasMany = array();
	public static $cache = true;
	public static $cacheEngine = null;

	protected function getTable()
	{
		return $this->table;
	}

	public static function setCacheEngine($cache)
	{
		self::$cacheEngine = $cache;
	}
	
	// getters for objects
	public static function getAll($limitation = "")
	{
		$modelGeneric = new static;
		$data = self::raw("SELECT ".$modelGeneric::$primaryKey." FROM ".$modelGeneric::$table." ".$limitation." order by 1 desc");

		$return = array();

		if (count($data)) {
			foreach ($data as $item) {
				$ID = $item[$modelGeneric::$primaryKey];
				$return[$ID] = static::getItem($ID);
			}
		}

		return $return;
	}

	public static function getItem($primaryKeyValue)
	{
		$modelGeneric = new static;
		$primaryKey = $modelGeneric::$primaryKey;

		$is_cache_exists = false;
		if ($modelGeneric::$cache) {
			
			$Cache = self::$cacheEngine;
			if ($data = $Cache::get($modelGeneric::$table.'/item_['.($primaryKeyValue).']')) {
				$is_cache_exists = true;
			}
		}
		if (!$is_cache_exists || !isset($data)) {
			$keys = array_keys(get_object_vars($modelGeneric));

			$found_at = array_search('additional_data', $keys);
			if($found_at >= 0) {
				unset($keys[$found_at]);
				$keys = array_filter($keys);
			}

			$data = self::raw(
				"SELECT ".implode(', ', $keys) ." FROM ".$modelGeneric::$table." where ".$primaryKey." = :".$primaryKey, 
				array($primaryKey => $primaryKeyValue)
			);

			if (count($data) == 0) {
				return false;
			}

			$data = $data[0];
		}

		foreach ($data as $field => $value) {
			if($field != 'additional_data'){
				$modelGeneric->{$field} = $value;
			} else {
				$modelGeneric->setAdditionalData($value);  
			}
		}

		$modelGeneric->getAdditionalData(); // just in case

		if ($modelGeneric::$cache && !$is_cache_exists) {
			
			$data_model = new stdClass;
			foreach ($modelGeneric as $field => $value) {
				$data_model->{$field} = $value;
			}
			$data_model->additional_data = $modelGeneric->getAdditionalData();
			
			$Cache = self::$cacheEngine;
			$Cache::set($modelGeneric::$table.'/item_['.$primaryKeyValue.']', $data_model);
		}

		return $modelGeneric;
	}

	public static function where($column, $comparison = "=", $value) // getAllWhere
	{
		$modelGeneric = new static;
		$primaryKey = $modelGeneric::$primaryKey;

		$data = self::raw(
			"SELECT ".$primaryKey." FROM ".$modelGeneric::$table." where ".$column." ".$comparison." :value", 
			array('value' => $value)
		);

		if (count($data) == 0) {
			return false;
		}

		$return = array();

		foreach ($data as $item) {
			$ID = $item[$modelGeneric::$primaryKey];
			$return[$ID] = static::getItem($ID);
		}

		return $return;
	}

	public static function delete($model)
	{
		if($model) {
			$primaryKey = $model::$primaryKey;

			if (!empty($model->{$primaryKey})) {
				$params = array();
				$params[$primaryKey] = $model->{$primaryKey};

				self::raw('delete from '.($model::$table).' where '.$primaryKey.' = :'.$primaryKey, $params);

				if ($model::$cache) {
					
					$Cache = self::$cacheEngine;
					$Cache::delete($model::$table.'/item_['.$model->{$primaryKey}.']');
				}
			}
		}
	}

	public static function forget($model)
	{
		if($model) {
			$primaryKey = $model::$primaryKey;

			if (!empty($model->{$primaryKey})) {
				$params = array();
				$params[$primaryKey] = $model->{$primaryKey};

				if ($model::$cache) {
					
					$Cache = self::$cacheEngine;
					$Cache::delete($model::$table.'/item_['.$model->{$primaryKey}.']');
				}
			}
		}
	}
	
	public static function update($model)
	{
		$primaryKey = $model::$primaryKey;

		$modelGeneric = new static;
		$fields = array_keys(get_object_vars($modelGeneric));

		$additional_data_index = array_search('additional_data', $fields);
		if($additional_data_index >= 0) {
			unset($fields[$additional_data_index]);
			$fields = array_filter($fields);
		}

		if (!isset(self::$DB)) {
			self::init();
		}

		// extract fields from model
		$fields_set = array();
		foreach ($fields as $field => $value) {
			if (isset($model->$value)) {
				$fields_set[$value] = $model->$value;
			}
		}
		
		$SQL_query_array = array();
		foreach ($fields_set as $i => $v) {
			if ($i != $primaryKey) {
				$SQL_query_array[] = $i."= :".$i;
			}
		}

		$SQL_query = "update ".$model::$table." set ".implode(', ', $SQL_query_array).' where '.$primaryKey.' = :'.$primaryKey;
		$SQL = self::$DB->prepare($SQL_query);

		// assign parameters
		$executionParams = array();
		foreach ($fields_set as $i => $v) {
			$executionParams[':'.$i] = $v;
		}

		if ($modelGeneric::$cache) {
			
			$Cache = self::$cacheEngine;
			$Cache::delete($modelGeneric::$table.'/item_['.($model->{$primaryKey}).']');
		}

		$SQL->execute($executionParams);
		return true;
	}

	public static function create($model)
	{
		$modelGeneric = new static;
		$fields = array_keys(get_object_vars($modelGeneric));

		$found_at = array_search('additional_data', $fields);
		if ($found_at >= 0) {
			unset($fields[$found_at]);
			$fields = array_filter($fields);
		}

		if (!isset(self::$DB)) {
			self::init();
		}

		// extract fields from model
		$fields_set = array();
		foreach ($fields as $field => $value) {
			if (isset($model->$value)) {
				$fields_set[$value] = $model->$value;
			}
		}

		// prepare SQL query
		$SQL_query = "INSERT INTO ".$model::$table." (".(implode(", ", array_keys($fields_set))).") values (:".(implode(", :", array_keys($fields_set))).")";
		// echo $SQL_query;
		$SQL = self::$DB->prepare($SQL_query);

		// assign parameters
		$executionParams = array();
		foreach ($fields_set as $i => $v) {
			$executionParams[':'.$i] = $v;
		}

		$SQL->execute($executionParams);
		return self::$DB->lastInsertId();
	}

	public static function validate($model)
	{
		$rules_broken = array();
		
		if (count($model)) {
			foreach ($model as $fieldName => $fieldValue) {

				if (isset($model::$rules[$fieldName])) {
					$rules = explode('|', $model::$rules[$fieldName]);
					
					foreach ($rules as $rule) {
						$respectsRule = ModelAbstract::respectsRule($rule, $fieldName, $fieldValue, $model);

						if (!$respectsRule) {
							$rules_broken[] = array(
								'field' => $fieldName,
								'rule' => $rule
							);
						}
					}
				}
			}
		}

		return (empty($rules_broken) ? true : $rules_broken);
	}

	private static function respectsRule($rule, $fieldName, $fieldValue, $model)
	{
		switch ($rule) {
			case 'alphanumeric':
				return ctype_alpha(str_replace(array('.', '_', '-', ' '), '', $fieldValue));
				break;
			case 'not_empty':
				return (trim($fieldValue) != "");
				break;
			case 'unique':
				$primaryKey = $model::$primaryKey;
				$results = DB::get($model::$table, array($fieldName => $fieldValue), array($primaryKey), 2);

				if (count($results)) {
					foreach ($results as $key => $value) {
						// var_dump(array((string)$value[$primaryKey], (string)$model->{$primaryKey}));
						if ((string)$value[$primaryKey] != (string)$model->{$primaryKey}) {
							return false;
						}
					}
				}

				return true;
				break;
			default:
				throw new Exception("Validation Rule not catched: ".$rule, 1);
				break;
		}
	}

	public static function prepareValidationString($messageList)
	{
		$mesaje = array();

		if (is_array($messageList)) {
			foreach ($messageList as $key => $value) {
				$mesaje[] = "regula ".$value['rule']." nu e respectata pentru campul ".$value['field'];
			}
		}

		return (empty($mesaje) ? '' : implode(', ', $mesaje));
	}


	private $additional_data = array();

	public function setAdditionalData($param = null)
	{
		$results = array();
		if (count($param) && !empty($param)) {
			$results = array();

			foreach ($param as $objectType => $list) {
				foreach ($list as $item) {
					// $newObject = $objectType::getItem($item->{$objectType::$primaryKey});

					$newObject = new $objectType;
					foreach ($item as $k => $v) {
						$newObject->{$k} = $v;
					}

					$results[$objectType][] = $newObject;
				}
			}
		}

		if (!empty($results)) {
			$this->additional_data = $results;
		}
	}
	
	public function getAdditionalData()
	{   
		if (isset($this->additional_data) && !empty($this->additional_data)) {
			return $this->additional_data;
		}

		$results = array();
		if (count(static::$hasMany)) {
			foreach (static::$hasMany as $objectType => $pivot) {

				$pivotResults = self::raw("select ".$pivot[3]." from ".$pivot[0]." where ".$pivot[1]." = :".$pivot[1], array($pivot[1] => $this->{$pivot[2]}));
				if (count($pivotResults)) {
					foreach ($pivotResults as $i => $j) {
						$newObject = $objectType::getItem($j[$pivot[3]]);
						$newObject->getAdditionalData(); // just in case
						$results[$objectType][] = $newObject;
					}
				}
			}
		}

		if (count($results)) {
			$this->additional_data = $results;
			return $results;
		}

		return false;
	}
}
