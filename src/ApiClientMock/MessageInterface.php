<?php
namespace Examples\ApiClientMock;

interface MessageInterface
{
    public function setMethod($method);
    public function getMethod();

    public function setUrl($url);
    public function getUrl();

    public function setHeaders(array $headers);
    public function addHeader($header, $value);
    public function removeHeader($header);
    public function getHeaders();

    public function setBody($body);
    public function getBody();

}