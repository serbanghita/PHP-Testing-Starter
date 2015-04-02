<?php
namespace UnitTests\AbstractTest;

interface TransportInterface
{
    public function setPort($port);
    public function getPort();
}