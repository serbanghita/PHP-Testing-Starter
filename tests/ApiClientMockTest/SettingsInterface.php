<?php
namespace UnitTests\ApiClientMockTest;

interface SettingsInterface
{
    public function set($key, $value);
    public function get($key);
}