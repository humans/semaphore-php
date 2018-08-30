<?php

namespace Artisan\Semaphore;

class SemaphoreMessage
{
    /**
     * The content the recepient will get.
     *
     * @var string
     */
    protected $content;

    /**
     * The name that the recepient will see in their message.
     *
     * @var string
     */
    protected $from;

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
     * Set the content to send.
     *
     * @param  string  $content
     * @return SemaphoreMessage
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the name to use they will receive.
     *
     * @return string
     */
    public function getFrom()
    {
        if (! $this->from) {
            return config('semaphore.from_name');
        }

        return $this->from;
    }

    /**
     * Get the content to send to the user.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
