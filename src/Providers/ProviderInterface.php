<?php

namespace Moneo\RequestForwarder\Providers;

use Illuminate\Http\Client\Factory;

interface ProviderInterface
{
    public function __construct(Factory $client);

    public function send($url, $params, $webhook): \Illuminate\Http\Client\Response;
}
