<?php

namespace Humans\Semaphore\Laravel;

use Humans\Semaphore\Client;

class Facade extends \Illuminate\Support\Facades\Facade
{
    public static function getFacadeAccessor()
    {
        return Client::class;
    }
}
