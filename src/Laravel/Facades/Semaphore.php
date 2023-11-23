<?php

namespace Humans\Semaphore\Laravel\Facades;

use Humans\Semaphore\Client;

/**
 * @method \Humans\Semaphore\Message message()
 */
class Semaphore extends \Illuminate\Support\Facades\Facade
{
    public static function getFacadeAccessor()
    {
        return Client::class;
    }
}
