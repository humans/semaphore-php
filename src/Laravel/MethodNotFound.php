<?php

namespace Humans\Semaphore\Laravel;

use RuntimeException;

class MethodNotFound extends RuntimeException
{
    public function __construct($notifiable)
    {
        parent::__construct(
            'The phone number has not been set. Add a [routeNotificationForSemaphore] method to your ' . get_class($notifiable) . ' class.'
        );
    }
}
