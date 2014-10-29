<?php

class ArrayHelper
{
    /**
     * Return the first element in the array that's passed as an input to the method.
     * 
     * when a non empty array is passed as a parameter then will return first element from array
     * when an empty array is passed as a parameter then will return false
     * when input is object then expect first attribute value
     * when no value is passed then return null
     * when a scalar is passed as a parameter then return null
     * 
     * 
     * Example:
     * $input = array('a', 'b', 'c');
     * $response = ArrayHelper::first(array($input));
     * var_dump($response); // will display: string(1): "a"
     * 
     * @param array|object $input
     * @return mixed
     */
    public static function first($input = null)
    {
        if (is_null($input) || is_scalar($input)) {
            return null;
        }
        return end(array_reverse((array)$input));
    }
}