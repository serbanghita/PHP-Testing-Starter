<?php
include dirname(__FILE__) . '/../../tests/bootstrap.php';

use Examples\ApiClientMock\Settings;
use Examples\ApiClientMock\HttpClient;
use Examples\ApiClientMock\ApiClient;

$settings = new Settings();
    $settings->set('proxy', 'tcp://proxy.avangate.local:8080');
    $settings->set('request_fulluri', true);
$httpClient = new HttpClient($settings);

$settings = new Settings();
    $settings->set('url', 'http://jsonplaceholder.typicode.com');
    $settings->set('token', 'whatever');
$client = new ApiClient($settings, $httpClient);

$response = $client->getPostById(1);

var_dump($response->getStatusCode());
var_dump($response->getHeaders());
var_dump($response->getBody());