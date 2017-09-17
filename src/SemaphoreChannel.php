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
     * Send the sms notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSemaphore($notifiable);

        Zttp::post(static::MESSAGE_API, [
            'number'     => $notifiable->routeNotificationForSemaphore(),
            'message'    => $message,
            'apikey'     => config('semaphore.key'),
            'sendername' => config('semaphore.from_name')
        ]);
    }
}
