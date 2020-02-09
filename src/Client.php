<?php

namespace Humans\Semaphore;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;

class Client
{
    const BASE_API = 'http://api.semaphore.co/';

    protected $apiKey;

    protected $client;

    protected $sender;

    public function __construct($apiKey, $sender = null)
    {
        $this->apiKey = $apiKey;
        $this->sender = $sender;
        $this->client = HttpClient::createForBaseUri(self::BASE_API);
    }

    public function setHttpClient(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function send($method, $url, $parameters = [])
    {
        return $this->client->request($method, $url, $parameters)->toArray();
    }

    public function message()
    {
        return new Message($this);
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getSender()
    {
        return $this->sender;
    }
}
