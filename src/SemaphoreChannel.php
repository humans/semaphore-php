<?php

namespace Artisan\Semaphore;

use Zttp\Zttp;
use Illuminate\Notifications\Notification;

class SemaphoreChannel
{
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

        Zttp::post('http://api.semaphore.co/api/v4/messages', [
            'number'     => $notifiable->routeNotificationForSemaphore(),
            'message'    => $message,
            'apikey'     => config('services.semaphore.key'),
            'sendername' => config('services.semaphore.from_name')
        ]);
    }
}
