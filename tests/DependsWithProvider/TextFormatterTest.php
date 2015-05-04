<?php
namespace UnitTests\DependsWithProvider;

use Examples\DependsWithProvider\TextFormatter;

class TextFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function texts()
    {
        return array(
            array('input' => 'This is a  message', 'output' => 'Thisisamessage'),
            array('input' => ' This is another  message ! ', 'output' => 'Thisisanothermessage!')
        );
    }

    /**
     * eliminateWhiteSpaces eliminates all white spaces from the provided texts
     * @dataProvider texts
     * @param $inputText string
     * @param $outputText string
     */
    public function testEliminateWhiteSpacesEliminatesAllWhiteSpacesFromTheProvidedTexts($inputText, $outputText)
    {
        $formatter = new TextFormatter();
        $this->assertEquals($outputText, $formatter->eliminateWhiteSpaces($inputText));
    }


    /**
     * each item from texts provider has a non empty value in the output key
     * @dataProvider texts
     * @param $inputText string
     * @param $outputText string
     * @return array
     */
    public function testEachItemFromTextsProviderHasANonEmptyValueInTheOutputKey($inputText, $outputText)
    {
        $this->assertNotEmpty($outputText);

        return array('input' => $inputText, 'output' => $outputText);
    }

    /**
     * @depends testEachItemFromTextsProviderHasANonEmptyValueInTheOutputKey
     * @param $textArray NULL
     *
     * Because of https://github.com/sebastianbergmann/phpunit/issues/183#issuecomment-816066
     */
    public function testDynamicTexts($textArray)
    {
        $this->assertNull($textArray);
    }

}