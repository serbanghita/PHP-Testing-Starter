<?php
namespace UnitTests\ApiClientMockTest;

interface MessageInterface
{
    public function setHeaders(array $headers);
    public function addHeader($header, $value);
    public function removeHeader($header);
    public function setBody($body);
    public function getBody();
}