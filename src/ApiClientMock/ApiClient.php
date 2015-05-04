<?php
namespace Examples\ApiClientMock;

class ApiClient
{
    protected $settings;
    protected $client;

    public function __construct(SettingsInterface $settings, ClientInterface $client)
    {
        $this->settings = $settings;
        $this->client = $client;
    }

    /**
     * @param $id
     * @return Response
     */
    public function getPostById($id)
    {
        $request = new Request(
                                'GET',
                                $this->settings->get('url') . '/posts/' . $id,
                                array(
                                        'Accept-language' => 'en',
                                        'X-Auth-Token' => $this->settings->get('token')
                                )
        );
        return $this->client->request($request);
    }
}