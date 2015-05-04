<?php
namespace Examples\ApiClientMock;

interface SettingsInterface
{
    public function set($key, $value);
    public function get($key);
}