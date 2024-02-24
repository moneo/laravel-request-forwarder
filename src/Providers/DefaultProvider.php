<?php

namespace Moneo\RequestForwarder\Providers;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Response;

class DefaultProvider implements ProviderInterface
{
    public function __construct(
        private readonly Factory $client,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function send(string $url, array $params, array $webhook): Response
    {
        return $this->client
            ->send($webhook['method'] ?? 'POST', $webhook['url']);
    }
}
