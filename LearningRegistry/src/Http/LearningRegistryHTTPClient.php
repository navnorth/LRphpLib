<?php

namespace LearningRegistry\Http;

use \OAuth\Common\Http\Exception\TokenResponseException;
use \OAuth\Common\Http\Uri\UriInterface;
use \GuzzleHttp\Exception\RequestException;

/**
 * Client implementation for cURL
 */
class LearningRegistryHTTPClient extends \OAuth\Common\Http\Client\AbstractClient
{
 
    private $forceSSL3 = false;
    private $parameters = array();

    public function setCurlParameters(array $parameters)
    {
    }

    public function setForceSSL3($force)
    {
    }

    public function retrieveResponse(
        UriInterface $endpoint,
        $requestBody,
        array $extraHeaders = array(),
        $method = 'POST'
    ) {
    
        $client = new \GuzzleHttp\Client();
    
        if ($method == "POST") {
            try {
                $res = $client->post(
                    $endpoint,
                    [
                    'config' => [
                    'curl' => [
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    ]
                    ],
                    'headers' => $extraHeaders,
                    'body' => $requestBody,
                    ]
                );
                return (object) array(
                "statusCode" => $res->getStatusCode(),
                "response" => $res->getBody()
                );
            } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                if ($e->hasResponse()) {
                    return (object) array(
                    "statusCode" => $e->getResponse()->getStatusCode(),
                    "response" => $e->getResponse()->getBody()
                    );
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                return (object) array(
                "statusCode" => "",
                "response" => "Invalid URL"
                );
            }
    
        } else {
            try {
                $res = $client->get(
                    $endpoint,
                    [
                    'config' => [
                    'curl' => [
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSL_VERIFYPEER => false,
                    ]
                    ],
                    ]
                );
                return (object) array(
                "statusCode" => $res->getStatusCode(),
                "response" => $res->getBody()
                );
            } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                if ($e->hasResponse()) {
                    return (object) array(
                    "statusCode" => $e->getResponse()->getStatusCode(),
                    "response" => $e->getResponse()->getBody()
                    );
                }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                return (object) array(
                "statusCode" => "",
                "response" => "Invalid URL"
                );
            }
    
        }
        
    }
}
