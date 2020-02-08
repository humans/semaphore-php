<?php

namespace Humans\Semaphore;

use Zttp\Zttp;

class SemaphoreApi
{
    /**
     * Semaphore's API endpoint to send messages.
     */
    const MESSAGE_API = 'http://api.semaphore.co/api/v4/messages';

    public function send($options = [])
    {
        return Zttp::post(static::MESSAGE_API, $options)->json();
    }
}
