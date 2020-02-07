<?php

namespace Humans\Semaphore\Exceptions;

use RuntimeException;

class InvalidNumber extends RuntimeException
{
    public function __construct($number)
    {
        parent::__construct(
            "The number [{$number}] is invalid. The allowed formats are +639XXXXXXXXX, 639XXXXXXXXX, or 09XXXXXXXXX"
        );
    }
}
