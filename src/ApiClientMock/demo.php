<?php
include dirname(__FILE__) . '/../../tests/bootstrap.php';

use Examples\ApiClientMock\Settings;
use Examples\ApiClientMock\HttpClient;
use Examples\ApiClientMock\ApiClient;

$settings = new Settings();
    $settings->set('url', 'http://jsonplaceholder.typicode.com');
    $settings->set('token', 'whatever');
$httpClient = new HttpClient();
$client = new ApiClient($settings, $httpClient);
$response = $client->getPostById(1);

var_dump($response->getStatusCode());
var_dump($response->getHeaders());
var_dump($response->getBody());