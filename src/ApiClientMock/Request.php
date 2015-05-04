<?php
namespace Examples\ApiClientMock;

class Request extends AbstractMessage
{
    public function __construct($method, $url, $headers = [], $body = null)
    {
        $this->method = $method;
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }


}