<?php

namespace Moneo\WebhookRelayer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessWebhookRelayer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $url,
        public readonly array $params,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $webhookRelayer = app(WebhookRelayer::class);
        $webhookRelayer->triggerHooks($this->url, $this->params);
    }
}
