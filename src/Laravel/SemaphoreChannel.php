<?php

namespace Humans\Semaphore\Laravel;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Humans\Semaphore\Laravel\Facade as Semaphore;

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

        $response = Semaphore::message()->send(
            $this->number($notifiable), $message->getMessage()
        );

        if (array_key_exists('apikey', $response)) {
            throw new Exceptions\InvalidApiKey($apiKey);
        }

        if (array_key_exists(0, $response) && array_key_exists('senderName', $response[0])) {
            throw new Exceptions\InvalidSenderName($sender);
        }

        if (array_key_exists('number', $response)) {
            throw new Exceptions\InvalidNumber($number);
        }

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

        throw new MethodNotFound($notifiable);
    }
}
