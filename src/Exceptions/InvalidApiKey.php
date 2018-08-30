<?php

namespace Artisan\Semaphore\Exceptions;

use LogicException;

class InvalidApiKey extends LogicException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
