<?php

namespace Moneo\RequestForwarder\Providers;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Response;

interface ProviderInterface
{
    public function __construct(Factory $client);

    public function send(string $url, array $params, array $webhook): Response;
}
