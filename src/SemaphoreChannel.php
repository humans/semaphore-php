<?php

namespace Artisan\Semaphore;

use Zttp\Zttp;
use Illuminate\Notifications\Notification;

class SemaphoreChannel
{
    /**
     * Semaphore's API endpoint to send messages.
     */
    const MESSAGE_API = 'http://api.semaphore.co/api/v4/messages';

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

        $response = Zttp::post(static::MESSAGE_API, [
            'number'     => $number = $notifiable->routeNotificationForSemaphore(),
            'message'    => $message->getContent(),
            'sendername' => $sender = $message->getFrom(),
            'apikey'     => $apiKey = config('semaphore.key'),
        ])->json();

        if (array_key_exists('apikey', $response)) {
            // "apikey" => array:1 [
            //     0 => "The selected apikey is invalid."
            // ]
            throw new Exceptions\InvalidApiKey("The API key [{$apiKey}] provided was invalid. Please check the SEMAPHORE_KEY in your .env file.");
        }

        if (array_key_exists(0, $response) && array_key_exists('senderName', $response[0])) {
            // 0 => array:1 [
            //     "senderName" => "The senderName supplied is not valid"
            // ]
            throw new Exceptions\InvalidSenderName("The sender name [{$sender}] is not valid, or has not yet been approved.");
        }

        if (array_key_exists('number', $response)) {
            // "number" => array:1 [
            //     0 => "The number format is invalid."
            // ]
            throw new Exceptions\InvalidNumber("The number [{$number}] is invalid. The allowed formats are +639XXXXXXXXX, 639XXXXXXXXX, or 09XXXXXXXXX");
        }
    }
}
