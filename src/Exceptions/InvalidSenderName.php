<?php

namespace Humans\Semaphore\Exceptions;

use LogicException;

class InvalidSenderName extends LogicException
{
    public function __construct($sender)
    {
        parent::__construct(
            "The sender name [{$sender}] is not valid, or has not yet been approved."
        );
    }
}
