<?php

namespace Humans\Semaphore\Laravel;

use Illuminate\Support\Facades\Config;

class SemaphoreMessage
{
    /**
     * The name that the recepient will see in their message.
     *
     * @var string
     */
    protected $sender;

    /**
     * Set the message to send.
     *
     * @param  string  $message
     * @return SemaphoreMessage
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the message to send to the user.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
