<?php
namespace Examples\ApiClientMock;

class HttpClient implements ClientInterface
{
    protected $settings;
    protected $request;
    protected $response;

    public function __construct(Settings $settings) {
        $this->settings = $settings;
    }

    /**
     * @param MessageInterface $request
     * @return Response
     */
    public function request(MessageInterface $request)
    {
        // Store the initial request for later.
        $this->request = $request;

        // Create a stream
        $streamOptions = array(
            'http' => array(
                'method' => $request->getMethod(),
                'header' => implode("\r\n", $request->getHeaders()),
                'user_agent' => 'Testing Client 1.0',
                'proxy' => $this->settings->get('proxy'),
                'request_fulluri' => $this->settings->get('request_fulluri'),
                'content' => $request->getBody()
            )
        );

        $streamContext = stream_context_create($streamOptions);

        // Go live and request.
        $responseBody = file_get_contents($request->getUrl(), false, $streamContext);

        // Store the response for later.
        $this->response = new Response(
                                        $this->extractStatusFromResponseHeaders($http_response_header),
                                        $this->extractHeadersFromResponseHeaders($http_response_header),
                                        $responseBody
                            );

        return $this->response;
    }

    public function response()
    {
        return $this->response;
    }

    protected function extractStatusFromResponseHeaders(array $responseHeadersArray)
    {
        $status = null;

        if (isset($responseHeadersArray[0])) {
            $firstHeaderFragments = explode(' ', $responseHeadersArray[0], 2);
            $status = (int)$firstHeaderFragments[1];
        }

        return $status;
    }

    protected function extractHeadersFromResponseHeaders(array $responseHeadersArray)
    {
        $headers = array();

        foreach ($responseHeadersArray as $headerLineString) {
            $headerLineString = trim($headerLineString);
            if (!empty($headerLineString) && strpos($headerLineString, ':') !== false) {
                $headerLineArray = explode(':', $headerLineString, 2);
                $headerLineArray[0] = ucfirst(strtolower($headerLineArray[0]));
                $headers[$headerLineArray[0]] = ltrim($headerLineArray[1]);
            }
        }

        return $headers;
    }

}