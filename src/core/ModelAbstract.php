<?php
namespace core;

abstract class ModelAbstract
{
	protected $table;

	public function getItem()
	{
		return false;
	}

	protected function getTable()
	{
		return $this->table;
	}
}