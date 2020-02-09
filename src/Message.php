<?php

namespace Humans\Semaphore;

class Message
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send($number, $message)
    {
        $response = $this->client->send('POST', '/api/v4/messages', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'number'     => $number,
                'message'    => $message,
                'sendername' => $sender = $this->client->getSender(),
                'apikey'     => $apiKey = $this->client->getApiKey(),
            ],
        ]);

        if (array_key_exists('apikey', $response)) {
            throw new Exceptions\InvalidApiKey($apiKey);
        }

        if (array_key_exists('number', $response)) {
            throw new Exceptions\InvalidNumber($number);
        }

        if (array_key_exists('senderName', $response[0])) {
            throw new Exceptions\InvalidSenderName($sender);
        }

        return $response;
    }
}
