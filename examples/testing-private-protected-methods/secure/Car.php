<?php

class Car
{
	protected $wheelsTotalCost = 0;

	protected $CAR_TYPE        = "";

	private static $WHEEL_PRICE = array(
		'TRUCK' => 100,
		'AUTO'  => 30,
		'BIKE'  => 5
	);

	public function __construct($type, $nrWheels)
	{
		if ($this->setType($TYPE)) {
			$this->init($nrWheels);
		}
	}

	/**
	 * Calculate and store wheels totals price.
	 * 
	 * @param int $nrWheels 	number of wheels. Default 4
	 * @return int 				total price of wheels
	 */
	protected function init($nrWheels = 4)
	{
		return $this->wheelsTotalCost = (int)$nrWheels * self::$WHEEL_PRICE[$this->CAR_TYPE];
	}

	/**
	 * Stores the input car type, if valid.
	 * Returns true when set and false if invalid.
	 * 
	 * @param string $type 	one of the valid car types
	 * @return bool
	 */
	private function setType($type)
	{
		if (is_string($type)) {
			if (in_array($type, array_keys(self::$WHEEL_PRICE))) {
				$this->CAR_TYPE = $type;
				return true;
			}
		}
		return false;
	}
}