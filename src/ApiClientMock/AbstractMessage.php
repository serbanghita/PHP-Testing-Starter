<?php
namespace Examples\ApiClientMock;

abstract class AbstractMessage implements MessageInterface
{
    protected $statusCode;
    protected $method;
    protected $url;
    protected $headers = [];
    protected $body;

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function addHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    public function removeHeader($header)
    {
        unset($this->headers[$header]);
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
}