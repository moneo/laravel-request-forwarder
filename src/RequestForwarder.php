<?php

namespace Moneo\RequestForwarder;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Request;
use Moneo\RequestForwarder\Exceptions\WebhookNameNotFoundException;
use Moneo\RequestForwarder\Providers\DefaultProvider;
use Moneo\RequestForwarder\Providers\ProviderInterface;

class RequestForwarder
{
    public function __construct(
        private readonly Factory $client,
        private readonly array $webhooks,
    ) {
    }

    public function sendAsync(Request $request, ?string $webhookName = null): void
    {
        ProcessRequestForwarder::dispatch($request->url(), $request->toArray(), $webhookName);
    }

    /**
     * @throws WebhookNameNotFoundException
     */
    public function triggerHooks(string $url, array $params, string $webhookName = null): void
    {
        foreach ($this->getWebhookTargets($webhookName) as $webhook) {
            try {
                /** @var ProviderInterface $provider */
                $providerClass = $webhook['provider'] ?? DefaultProvider::class;
                $provider = new $providerClass($this->client);
                $provider->send($url, $params, $webhook);
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * @throws WebhookNameNotFoundException
     */
    private function getWebhookInfo(?string $webhookName = null): array
    {
        $webhookName =  $webhookName ?? config('request-forwarder.default_webhook_name');

        return $this->webhooks[$webhookName] ?? throw new WebhookNameNotFoundException('Webhook name called ' . $webhookName . ' is not defined in the config file');
    }

    /**
     * @throws WebhookNameNotFoundException
     */
    private function getWebhookTargets(?string $webhookName = null): array
    {
        return $this->getWebhookInfo($webhookName)['targets'];
    }
}
