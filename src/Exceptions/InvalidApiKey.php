<?php

namespace Humans\Semaphore\Exceptions;

use LogicException;

class InvalidApiKey extends LogicException
{
    public function __construct($apiKey)
    {
        parent::__construct(
            "The API key [{$apiKey}] provided was invalid. Please check the SEMAPHORE_KEY in your .env file."
        );
    }
}
