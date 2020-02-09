<?php

namespace Humans\Semaphore\Laravel;

use Illuminate\Support\Facades\Config;

class SemaphoreMessage
{
    /**
     * The message the recepient will get.
     *
     * @var string
     */
    protected $message;

    /**
     * The name that the recepient will see in their message.
     *
     * @var string
     */
    protected $sender;

    /**
     * Assign a name for this specific message that will be sent.
     *
     * @param  string  $from
     * @return SemaphoreMessage
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

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
     * Get the name to use they will receive.
     *
     * @return string
     */
    public function getFrom()
    {
        if (! $this->sender) {
            return Config::get('semaphore.sender_name');
        }

        return $this->sender;
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
