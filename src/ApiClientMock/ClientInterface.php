<?php
namespace Examples\ApiClientMock;

interface ClientInterface
{
    public function request(MessageInterface $request);
    public function response();
}