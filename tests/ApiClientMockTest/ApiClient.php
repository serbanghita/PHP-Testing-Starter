<?php
namespace UnitTests\ApiClientMockTest;

class ApiClient
{
    protected $settings;
    protected $client;

    public function __construct(SettingsInterface $settings, ClientInterface $client)
    {
        $this->settings = $settings;
        $this->client = $client;
    }

    public function getProducts($limit = 0)
    {

    }

    public function getCategories($limit = 0)
    {

    }

    public function updateProduct(array $productData)
    {
        $response = $this->client->request(new Request(
            'post',
            $this->settings->get('url') . '/product/' . $productData['id'],
            json_encode($productData)
        ));


    }
}