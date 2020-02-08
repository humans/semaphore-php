<?php

namespace Humans\Semaphore\Exceptions;

use RuntimeException;

class NumberNotFoundException extends RuntimeException
{
    public function __construct($notifiable)
    {
        parent::__construct(
            'The phone number has not been set. Add a [routeNotificationForSemaphore] method to your ' . get_class($notifiable) . ' class'
        );
    }
}
