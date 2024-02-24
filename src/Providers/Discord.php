<?php

namespace Moneo\RequestForwarder\Providers;

use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Response;

class Discord implements ProviderInterface
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
        $content = $url.PHP_EOL;
        $content .= json_encode($params);

        return $this->client
            ->send('POST', $webhook['url'], [
                'json' => ['content' => $content],
            ]);
    }
}
