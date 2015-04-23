<?php
namespace UnitTests\ExceptionsTest;

class MyClass
{
    protected $aString;

    public function __construct($aString)
    {
        if (empty($aString)) {
            throw new \Exception('Empty string provided.');
        }

        $this->aString = $aString;
    }

    public function checkString()
    {
        if (is_string($this->aString)) {
            return true;
        } else {
            throw new \Exception('This is not a string!');
        }
    }
}