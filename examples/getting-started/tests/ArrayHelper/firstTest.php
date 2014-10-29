<?php

/**
 * The "first" method's purpose is to return the first element in the array that's passed as an input to the method.
 * 
 * ex:
 * $input = array('a', 'b', 'c');
 * $response = ArrayHelper::first(array($input));
 * var_dump($response); // will display: string(1): "a"
 * 
 */
class ArrayHelper_first extends PHPUnit_Framework_TestCase
{
    /**
     * when a non empty array is passed as a parameter then will return first element from array
     */
    public function testWhenANonEmptyArrayIsPassedAsAParameterThenWillReturnFirstElementFromArray()
    {
        // set expected
        $expected = "a";
        // prepare
        $input    = array("a", "b", "c");
        // make call
        $response = ArrayHelper::first($input);
        // make assert
        $this->assertEquals($expected, $response);
    }

    /**
     * when an empty array is passed as a parameter then will return false
     */
    public function testWhenAnEmptyArrayIsPassedAsAParameterThenWillReturnFalse()
    {
        $input    = array();
        $response = ArrayHelper::first($input);

        $this->assertFalse($response);
    }

    /**
     * when the first element of the array is zero then return zero
     */
    public function testWhenTheFirstElementOfTheArrayIsZeroThenReturnZero()
    {
        $input    = array(0, 1, 2, 3);
        $response = ArrayHelper::first($input);

        $this->assertSame(0, $response);
        $this->assertEquals(false, $response); // notice the difference. will pass
        // $this->assertFalse($response); // will fail
        // $this->assertSame('0', $response); // will fail
        $this->assertEquals('0', $response); // will pass
    }

    /**
     * when the first element of the array is false then return false
     */
    public function testWhenTheFirstElementOfTheArrayIsFalseThenReturnFalse()
    {
        $input    = array(false, 1, 2, 3);
        $response = ArrayHelper::first($input);

        $this->assertSame(false, $response);
        // $this->assertEquals(0, $response); // will pass. it's recommended to keep one assert per test
    }

    /**
     * when first element is null then return null
     */
    public function testWhenFirstElementIsNullThenReturnNull()
    {
        $input    = array(null, 1, 2, 3);

        $response = ArrayHelper::first($input);
        $this->assertNull($response);
    }

    /**
     * when input is a nonempty associative array then return first element
     */
    public function testWhenInputIsANonemptyAssociativeArrayThenReturnFirstElement()
    {
        $expected = 100;

        $input    = array(
            'ID'    => 100,
            'Make'  => 'nyan',
            'Color' => 'grey'
        );

        $response = ArrayHelper::first($input);
        $this->assertEquals($expected, $response);
    }

    /**
     * when input is object then expect first attribute value
     */
    public function testWhenInputIsObjectThenExpectFirstAttributeValue()
    {
        $expected = 'KT';

        $input        = new stdClass;
        $input->Code  = "KT";
        $input->Make  = "nyan";
        $input->Color = "grey";

        $response = ArrayHelper::first($input);
        $this->assertEquals($expected, $response);
    }

    /**
     * when no value is passed then return null
     */
    public function testWhenNoValueIsPassedThenReturnNull()
    {
        $response = ArrayHelper::first();
        $this->assertNull($response);
    }

    /**
     * when a scalar is passed as a parameter then return null
     * @dataProvider feedScalarValues
     */
    public function testWhenAScalarIsPassedAsAParameterThenReturnNull($parameter_1)
    {
        $input = $parameter_1;

        $response = ArrayHelper::first($input);
        $this->assertNull($response);
    }

    public function feedScalarValues()
    {
        return array(
            array("aaaa"),
            array(""),
            array(" "),
            array(0),
            array(1000)
        );
    }
}