<?php

namespace Artisan\Semaphore\Exceptions;

use RuntimeException;

class InvalidNumber extends RuntimeException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
