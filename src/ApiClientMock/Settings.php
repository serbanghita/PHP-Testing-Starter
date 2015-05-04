<?php
namespace Examples\ApiClientMock;

class Settings implements SettingsInterface
{
    protected $config;

    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    public function get($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : null;
    }
}