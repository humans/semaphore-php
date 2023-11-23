<?php

namespace Humans\Semaphore\Laravel\Contracts;

use Humans\Semaphore\Laravel\SemaphoreMessage;

interface UsesSemaphore
{
    public function toSemaphore($notifiable): SemaphoreMessage;
}
