<?php
namespace Examples\DependsWithProvider;

class TextFormatter
{
    public function eliminateWhiteSpaces($text)
    {
        return preg_replace('/[\s]+/i', '', $text);
    }
}