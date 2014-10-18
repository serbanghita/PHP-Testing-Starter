<?php
namespace Models;

class Administrator extends \core\ModelAbstract
{
	public $id;
	public $username;
	public $password;
	
	protected $table = "accounts_administrators";
}