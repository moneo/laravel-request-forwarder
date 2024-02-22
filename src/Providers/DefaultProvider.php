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
     * @param $url
     * @param $params
     * @param $webhook
     * @return PromiseInterface|Response
     * @throws \Exception
     */
    public function send($url, $params, $webhook): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        return $this->client
            ->send($webhook['method'] ?? 'POST', $webhook['url']);
    }
}
