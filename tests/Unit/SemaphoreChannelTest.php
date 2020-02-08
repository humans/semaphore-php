<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Facades\Humans\Semaphore\SemaphoreApi;
use Humans\Semaphore\Exceptions\InvalidApiKey;
use Humans\Semaphore\Exceptions\InvalidNumber;
use Humans\Semaphore\Exceptions\InvalidSenderName;
use Humans\Semaphore\Exceptions\NumberNotFound;
use Humans\Semaphore\SemaphoreChannel;
use Humans\Semaphore\SemaphoreMessage;

class SemaphoreChannelTest extends TestCase
{
    function test_send()
    {
        SemaphoreApi::shouldReceive('send')->andReturn([
            [
                "message_id"  => 12345,
                "user_id"     => 12345,
                "user"        => "some.email@email.com",
                "account_id"  => 12345,
                "account"     => "Some Account Name",
                "recipient"   => "0917xxxxxxx",
                "message"     => "Hello Message",
                "sender_name" => "Sender Name",
                "network"     => "Globe|Smart|Sun",
                "status"      => "Penng",
                "type"        => "Single",
                "source"      => "Api",
                "created_at"  => "2020-02-08 21:28:27",
                "updated_at"  => "2020-02-08 21:28:27",
            ],
        ]);

        $response = (new SemaphoreChannel)->send(new Person, new FakeNotification);

        $this->assertEquals(
            "some.email@email.com",
            $response[0]['user']
        );
    }

    function test_invalid_api_key()
    {
        SemaphoreApi::shouldReceive('send')->andReturn([
            'apikey' => [
                "The selected apikey is invalid."
            ],
        ]);

        Config::set('semaphore.key', 'abc-123');

        try {
            (new SemaphoreChannel)->send(new Person, new FakeNotification);
        } catch (InvalidApiKey $e) {
            $this->assertEquals(
                'The API key [abc-123] provided was invalid. Please check the SEMAPHORE_KEY in your .env file.',
                $e->getMessage()
            );
        }
    }

    function test_invalid_sender_name()
    {
        SemaphoreApi::shouldReceive('send')->andReturn([
            0 => [
                "senderName" => "The senderName supplied is not valid",
            ],
        ]);

        Config::set('semaphore.from_name', 'invalid sender name');

        try {
            (new SemaphoreChannel)->send(new Person, new FakeNotification);
        } catch (InvalidSenderName $e) {
            $this->assertEquals(
                'The sender name [invalid sender name] is not valid, or has not yet been approved.',
                $e->getMessage()
            );
        }
    }

    function test_invalid_phone_number()
    {
        SemaphoreApi::shouldReceive('send')->andReturn([
            'number' => [
                "The number format is invalid."
            ],
        ]);

        try {
            (new SemaphoreChannel)->send(new Person, new FakeNotification);
        } catch (InvalidNumber $e) {
            $this->assertEquals(
                'The number [09111111111] is invalid. The allowed formats are +639XXXXXXXXX, 639XXXXXXXXX, or 09XXXXXXXXX.',
                $e->getMessage()
            );
        }
    }

    function test_route_method_not_implemented()
    {
        try {
            (new SemaphoreChannel)->send(new ClassWithoutNumber, new FakeNotification);
        } catch (NumberNotFound $e) {
            $this->assertEquals(
                'The phone number has not been set. Add a [routeNotificationForSemaphore] method to your Tests\Unit\ClassWithoutNumber class.',
                $e->getMessage()
            );
        }
    }
}

class ClassWithoutNumber
{
}

class Person
{
    public function routeNotificationForSemaphore()
    {
        return '09111111111';
    }
}

class FakeNotification extends Notification
{
    public function toSemaphore()
    {
        return (new SemaphoreMessage);
    }
}
