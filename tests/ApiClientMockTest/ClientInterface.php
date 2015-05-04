<?php
namespace UnitTests\ApiClientMockTest;

interface ClientInterface
{
    public function request(MessageInterface $request);
    public function response();
}