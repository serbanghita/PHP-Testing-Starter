<?php
namespace UnitTests\ApiClientMockTest;

class HttpClient implements ClientInterface
{
    public function __construct()
    {

    }

    public function request(MessageInterface $request)
    {
        return new Response(200, [], null);
    }

    public function response()
    {

    }
}