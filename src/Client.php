<?php

namespace Humans\Semaphore;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;

class Client
{
    /**
     * The base URL for the Semaphore API.
     *
     * @var string
     */
    const BASE_API = 'http://api.semaphore.co';

    /** * The API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The HTTP client.
     *
     * @var \Symfony\HttpClient\HttpClientInterface
     */
    protected $client;

    /**
     * The sender name
     *
     * @var string
     */
    protected $sender;

    /**
     * Create a new Sempahore client instance.
     *
     * @param  string  $apiKey
     * @param  string  $sender
     * @return \Humans\Semaphore\Client
     */
    public function __construct($apiKey, $sender = null)
    {
        $this->apiKey = $apiKey;
        $this->sender = $sender;
        $this->client = HttpClient::createForBaseUri(self::BASE_API);
    }

    /**
     * Set a different http client.
     *
     * @param  \Symfony\HttpClient\HttpClientInterface  $client
     * @return void
     */
    public function setHttpClient(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Send a request to the Semaphore API.
     *
     * @param  string  $method
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function send($method, $url, $parameters = [])
    {
        return $this->client->request($method, $url, $parameters)->toArray();
    }

    /**
     * Get the API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Get the sender name.
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Get the message client.
     *
     * @return \Humans\Semaphore\Message
     */
    public function message()
    {
        return new Message($this);
    }
}
