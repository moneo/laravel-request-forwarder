<?php

namespace Moneo\RequestForwarder\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Moneo\RequestForwarder\RequestForwarder
 */
class RequestForwarder extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Moneo\RequestForwarder\RequestForwarder::class;
    }
}
