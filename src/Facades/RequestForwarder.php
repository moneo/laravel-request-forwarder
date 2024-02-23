<?php

namespace Moneo\RequestForwarder\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Moneo\RequestForwarder\RequestForwarder
 */
class RequestForwarder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Moneo\RequestForwarder\RequestForwarder::class;
    }
}
