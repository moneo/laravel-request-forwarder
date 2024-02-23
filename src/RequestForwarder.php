<?php

namespace Moneo\RequestForwarder;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Request;
use Moneo\RequestForwarder\Providers\DefaultProvider;
use Moneo\RequestForwarder\Providers\ProviderInterface;

class RequestForwarder
{
    public function __construct(
        private readonly Factory $client,
        private readonly array $webhooks,
    ) {
    }

    /**
     * @param Request $request
     */
    public function sendAsync(Request $request): void
    {
        ProcessRequestForwarder::dispatch($request->url(), $request->toArray());
    }

    /**
     * @param string $url
     * @param array $params
     */
    public function triggerHooks(string $url, array $params): void
    {
        foreach ($this->webhooks as $webhook) {
            try {
                /** @var ProviderInterface $provider */
                $providerClass = $webhook['provider'] ?? DefaultProvider::class;
                $provider = new $providerClass($this->client);
                $provider->send($url, $params, $webhook);
            } catch (\Exception $e) {
            }
        }
    }
}
