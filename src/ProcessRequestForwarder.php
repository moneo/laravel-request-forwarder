<?php

namespace Moneo\RequestForwarder;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessRequestForwarder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $url,
        public readonly array $params,
        public readonly ?string $webhookName = null,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $requestForwarder = app(RequestForwarder::class);
        $requestForwarder->triggerHooks($this->url, $this->params, $this->webhookName);
    }
}
