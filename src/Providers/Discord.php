<?php

namespace Moneo\RequestForwarder\Providers;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Response;

class Discord implements ProviderInterface
{
    public function __construct(
        private readonly Factory $client,
    ) {
    }

    /**
     * @param $url
     * @param $params
     * @param $webhook
     * @throws \Exception
     */
    public function send($url, $params, $webhook): \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
    {
        $content = $url.PHP_EOL;
        $content .= json_encode($params);

        return $this->client
            ->send('POST', $webhook['url'], [
                'json' => ['content' => $content],
            ]);
    }
}
