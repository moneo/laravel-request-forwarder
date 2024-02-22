<?php

// config for Moneo/WebhookRelayer
return [
    'webhooks' => [
        [
            'url' => 'https://some-domain.com/webhook',
            'method' => 'POST'
        ],
        [
            'url' => 'https://discord.com/api/webhooks/1209955556656291860/LAaczT-Pg785d5OzBmi6ivx2Vl7wAoruOwcVnZpb2eE2x8tf7fMi6R7_sr0IV0WoK83S',
            'method' => 'POST',
            'provider' => \Moneo\WebhookRelayer\Providers\Discord::class,
        ]
    ],
];
