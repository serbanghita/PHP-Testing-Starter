<?php
namespace Examples\ApiClientMock;

class Response extends AbstractMessage
{
    public function __construct($statusCode, array $headers = [], $body = null)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;
    }
}