<?php

namespace Moneo\WebhookRelayer;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Request;
use Moneo\WebhookRelayer\Providers\DefaultProvider;
use Moneo\WebhookRelayer\Providers\ProviderInterface;

class WebhookRelayer
{
    public function __construct(
        private readonly Factory $client,
        private readonly array $webhooks,
    ) {
    }

    public function sendAsync(Request $request)
    {
        ProcessWebhookRelayer::dispatch($request->url(), $request->toArray());
    }

    public function triggerHooks(string $url, array $params)
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
