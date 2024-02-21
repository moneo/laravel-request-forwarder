<?php

namespace Moneo\WebhookRelayer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Moneo\WebhookRelayer\WebhookRelayer
 */
class WebhookRelayer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Moneo\WebhookRelayer\WebhookRelayer::class;
    }
}
