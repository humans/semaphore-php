<?php

namespace Humans\Semaphore\Laravel;

use Humans\Semaphore\Client;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Humans\Semaphore\Laravel\Facade as Semaphore;

class SemaphoreChannel
{
    public function __construct(private Client $client)
    {
    }

    /**
     * Send the SMS notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        /** @var SemaphoreMessage $message */
        $message = $notification->toSemaphore($notifiable);

        $response = $this->client->message()->send(
            $this->number($notifiable),
            $message->getMessage(),
            $message->getFrom(),
        );

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
