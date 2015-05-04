<?php
namespace Examples\AbstractClass;

abstract class AbstractTransport implements TransportInterface
{
    protected $port;

    public function setPort($port)
    {
        $this->port = $port;
    }
    public function getPort()
    {
        return $this->port;
    }
}