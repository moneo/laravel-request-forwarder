<?php

namespace Moneo\RequestForwarder\Providers;

use Illuminate\Http\Client\Factory;

class DefaultProvider implements ProviderInterface
{
    public function __construct(
        private readonly Factory $client,
    ) {
    }

    public function send($url, $params, $webhook)
    {
        return $this->client
            ->send($webhook['method'] ?? 'POST', $webhook['url']);
    }
}
