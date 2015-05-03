<?php
namespace UnitTests\ApiClientMockTest;

class Request implements MessageInterface
{
    public function __construct($method, $url, $headers = [], $body = null)
    {

    }

    public function setHeaders(array $headers)
    {

    }

    public function addHeader($header, $value)
    {

    }

    public function removeHeader($header)
    {

    }

    public function setBody($body)
    {

    }

    public function getBody()
    {

    }

}