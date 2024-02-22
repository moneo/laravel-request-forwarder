<?php

namespace Moneo\WebhookRelayer;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebhookRelayerMiddleware
{
    public function __construct(
        public readonly WebhookRelayer $webhookRelayer,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->webhookRelayer->sendAsync($request);

        return $next($request);
    }
}
