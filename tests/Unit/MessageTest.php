<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Humans\Semaphore\Exceptions\InvalidApiKey;
use Humans\Semaphore\Exceptions\InvalidNumber;
use Humans\Semaphore\Exceptions\InvalidSenderName;
use Humans\Semaphore\Client;

class MessageTest extends TestCase
{
    function test_send()
    {
        $response = new MockResponse(json_encode([
            [
                "message_id"  => 12345,
                "user_id"     => 12345,
                "user"        => "some.email@email.com",
                "account_id"  => 12345,
                "account"     => "Some Account Name",
                "recipient"   => "0917xxxxxxx",
                "message"     => "Some Text Message",
                "sender_name" => "Some Sender Name",
                "network"     => "Globe|Smart|Sun",
                "status"      => "Penng",
                "type"        => "Single",
                "source"      => "Api",
                "created_at"  => "2020-02-08 21:28:27",
                "updated_at"  => "2020-02-08 21:28:27",
            ],
        ]));

        $client = new Client('some api token');
        $client->setHttpClient(
            new MockHttpClient($response, 'http://api-for-semaphore.co')
        );

        $response = $client->message()->send('0917xxxxxxx', 'Some Text Message');

        $this->assertEquals($response[0]['sender_name'], 'Some Sender Name');
        $this->assertEquals($response[0]['recipient'], '0917xxxxxxx');
        $this->assertEquals($response[0]['message'], 'Some Text Message');
    }

    function test_invalid_api_key()
    {
        $response = new MockResponse(json_encode([
            'apikey' => [
                "The selected apikey is invalid."
            ],
        ]));

        $client = new Client('invalid api token');
        $client->setHttpClient(
            new MockHttpClient($response, 'http://api-for-semaphore.co')
        );

        try {
            $client->message()->send('0917xxxxxxx', 'Some Text Message');

            $this->fail('InvalidApiKey exception not thrown');
        } catch (InvalidApiKey $e) {
            $this->assertEquals(
                'The API key [invalid api token] provided was invalid.',
                $e->getMessage()
            );
        }
    }

    function test_invalid_sender_name()
    {
        $response = new MockResponse(json_encode([
            [
                "senderName" => 'The senderName supplied is not valid',
            ],
        ]));

        $client = new Client('some valid token', 'invalid sender name');
        $client->setHttpClient(
            new MockHttpClient($response, 'http://api-for-semaphore.co')
        );

        try {
            $client->message()->send('0917xxxxxxx', 'Some Text Message');

            $this->fail('InvalidSenderName exception not thrown');
        } catch (InvalidSenderName $e) {
            $this->assertEquals(
                'The sender name [invalid sender name] is not valid, or has not yet been approved.',
                $e->getMessage()
            );
        }
    }

    function test_invalid_phone_number()
    {
        $response = new MockResponse(json_encode([
            'number' => [
                "The number format is invalid."
            ],
        ]));

        $client = new Client('some valid token', 'some sender name');
        $client->setHttpClient(
            new MockHttpClient($response, 'http://api-for-semaphore.co')
        );

        try {
            $client->message()->send('invalid number', 'Some Text Message');

            $this->fail('InvalidNumber exception not thrown');
        } catch (InvalidNumber $e) {
            $this->assertEquals(
                'The number [invalid number] is invalid. The allowed formats are +639XXXXXXXXX, 639XXXXXXXXX, or 09XXXXXXXXX.',
                $e->getMessage()
            );
        }
    }
}
