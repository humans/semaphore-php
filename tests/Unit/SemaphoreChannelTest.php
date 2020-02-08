<?php

namespace Tests\Unit;

use Tests\TestCase;
use Facades\Humans\Semaphore\SemaphoreApi;
use Humans\Semaphore\SemaphoreChannel;
use Humans\Semaphore\SemaphoreMessage;
use Illuminate\Notifications\Notification;

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
