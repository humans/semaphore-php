<?php

namespace Artisan\Semaphore\Exceptions;

use LogicException;

class InvalidSenderName extends LogicException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
