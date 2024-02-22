<?php

namespace Moneo\RequestForwarder;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestForwarderMiddleware
{
    public function __construct(
        public readonly RequestForwarder $requestForwarder,
    ) {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $name = null): Response
    {
        $this->requestForwarder->sendAsync($request, $name);

        return $next($request);
    }
}
