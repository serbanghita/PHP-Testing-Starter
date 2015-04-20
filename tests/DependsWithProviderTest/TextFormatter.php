<?php
namespace UnitTests\DependsWithProviderTest;

class TextFormatter
{
    public function eliminateWhiteSpaces($text)
    {
        return preg_replace('/[\s]+/i', '', $text);
    }
}