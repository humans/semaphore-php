<?php

namespace Humans\Semaphore;

use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Facades\Humans\Semaphore\SemaphoreApi;
use Humans\Semaphore\Exceptions\NumberNotFoundException;

class SemaphoreChannel
{
    /**
     * Send the SMS notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSemaphore($notifiable);

        $response = SemaphoreApi::send([
            'number'     => $number = $this->number($notifiable),
            'message'    => $message->getContent(),
            'sendername' => $sender = $message->getFrom(),
            'apikey'     => $apiKey = Config::get('semaphore.key'),
        ]);

        if (array_key_exists('apikey', $response)) {
            // "apikey" => array:1 [
            //     0 => "The selected apikey is invalid."
            // ]
            throw new Exceptions\InvalidApiKey($apiKey);
        }

        if (array_key_exists(0, $response) && array_key_exists('senderName', $response[0])) {
            // 0 => array:1 [
            //     "senderName" => "The senderName supplied is not valid"
            // ]
            throw new Exceptions\InvalidSenderName($sender);
        }

        if (array_key_exists('number', $response)) {
            // "number" => array:1 [
            //     0 => "The number format is invalid."
            // ]
            throw new Exceptions\InvalidNumber($number);
        }


        // [
        //     [
        //         "message_id" => 77879141,
        //         "user_id" => XXXX,
        //         "user" => "some.email@email.com",
        //         "account_id" => XXX,
        //         "account" => "Some Account Name",
        //         "recipient" => "0917xxxxxxx"
        //         "message" => "Hello Message"
        //         "sender_name" => "Sender Name"
        //         "network" => "Globe|Smart|Sun"
        //         "status" => "Penng"
        //         "type" => "Single"
        //         "source" => "Api"
        //         "created_at" => "2020-02-08 21:28:27"
        //         "updated_at" => "2020-02-08 21:28:27"
        //     ]
        // ]
        return $response;
    }

    /**
     * Get the phone number from the notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    private function number($notifiable)
    {
        if ($notifiable instanceof AnonymousNotifiable) {
            return $notifiable->routes[self::class];
        }

        if (method_exists($notifiable, 'routeNotificationForSemaphore')) {
            return $notifiable->routeNotificationForSemaphore();
        }

        throw new NumberNotFoundException($notifiable);
    }
}
