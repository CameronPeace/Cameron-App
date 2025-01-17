<?php

namespace App\Services\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

abstract class Request
{

    /**
     * @var GuzzleHttp Client
     */
    private $client;
    
    private $authorizationToken;

    protected function __construct()
    {
        $this->client = new Client();
        $this->setAutorizationToken('');
    }

    /**
     * Use guzzle to make our request.
     *
     * @param string $method The reqeust method.
     * @param string $path The request path.
     * @param array $params The request query params
     *
     * @return array
     */
    public function call(string $method, string $path, array $params = array(), bool $useQueryString = false): array
    {
        try {
            $url = $this->getRequestUrl($path);

            $guzzleSettings = $this->getRequestSettings($method, $params, $useQueryString);

            $guzzleResponse = $this->client->request($method, $url, $guzzleSettings);

            $response = array(
                'body' => json_decode($guzzleResponse->getBody(), true),
                'status' => $guzzleResponse->getStatusCode()
            );

            return $response;
        } catch (ClientException $e) {
            \Log::error($e);
            $response = json_decode($e->getResponse()->getBody()->getContents(), true);
            return ['status' => false, 'message' => $response['message'] ?? $response['error'] ?? 'Error' ];
        } catch (GuzzleException $e) {
            \Log::error($e);
            return ['status' => false, 'message' => $e->getMessage()];
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    /**
     * Build our api request.
     *
     * @param string $method
     * @param array $params
     *
     * @return array
     */
    protected function getRequestSettings(string $method, array $params = array(), bool $useQueryString = false): array
    {
        $guzzleSettings = array(
            'connect_timeout' => 60,
            'timeout' => 240,
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->getAuthorizationToken(),
                'accept' => 'application/json',
            ),
        );

        // Add the query parameters or message body
        if (strtoupper($method) === 'GET' || $useQueryString === true) {
            $guzzleSettings['query'] = $params;
        } else {
            $guzzleSettings['json'] = $params;
        }

        $guzzleSettings['headers']['Content-Type'] = 'application/json; charset=utf-8';

        return $guzzleSettings;
    }

    /**
     * Builds the URL that requests should be sent to.
     *
     * @param string $path Path for the call.
     *
     * @return string URL of the request
     */
    abstract protected function getRequestUrl(string $path);

    /**
     * Set authorization token
     *
     * @param string $token
     *
     * @return void
     */
    protected function setAutorizationToken(string $token = '')
    {
        $this->authorizationToken = $token;
    }

    /**
     * Return authorization token.
     *
     * @return string
     */
    protected function getAuthorizationToken(): string
    {
        return $this->authorizationToken;
    }
}
