<?php

namespace Moneo\RequestForwarder;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Request;
use Moneo\RequestForwarder\Exceptions\WebhookGroupNameNotFoundException;
use Moneo\RequestForwarder\Providers\DefaultProvider;
use Moneo\RequestForwarder\Providers\ProviderInterface;

class RequestForwarder
{
    public function __construct(
        private Factory $client,
        private array $webhooks,
    ) {
    }

    public function sendAsync(Request $request, ?string $webhookGroupName = null): void
    {
        /** @var ProcessRequestForwarder $queueClass */
        $queueClass = config('request-forwarder.queue_class', ProcessRequestForwarder::class);
        $queueClass::dispatch($request->url(), $request->toArray(), $webhookGroupName)
            ->onQueue(config('request-forwarder.queue_name'));
    }

    /**
     * @throws WebhookGroupNameNotFoundException
     */
    public function triggerHooks(string $url, array $params, ?string $webhookGroupName = null): void
    {
        foreach ($this->getWebhookTargets($webhookGroupName) as $webhook) {
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
     * @throws WebhookGroupNameNotFoundException
     */
    private function getWebhookInfo(?string $webhookGroupName = null): array
    {
        if ($webhookGroupName === null || trim($webhookGroupName) === '') {
            $webhookGroupName = config('request-forwarder.default_webhook_group_name');
        }

        return $this->webhooks[$webhookGroupName] ?? throw new WebhookGroupNameNotFoundException('Webhook Group Name called '.$webhookGroupName.' is not defined in the config file');
    }

    /**
     * // todo: DTO for return type
     *
     * @throws WebhookGroupNameNotFoundException
     */
    private function getWebhookTargets(?string $webhookGroupName = null): array
    {
        return $this->getWebhookInfo($webhookGroupName)['targets'];
    }
}
