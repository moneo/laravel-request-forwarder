<?php

namespace Moneo\RequestForwarder\Providers;

use Illuminate\Http\Client\Factory;

class Discord implements ProviderInterface
{
    public function __construct(
        private readonly Factory $client,
    ) {
    }

    public function send($url, $params, $webhook)
    {
        $content = $url.PHP_EOL;
        $content .= json_encode($params);

        return $this->client
            ->send('POST', $webhook['url'], [
                'json' => ['content' => $content],
            ]);
    }
}
