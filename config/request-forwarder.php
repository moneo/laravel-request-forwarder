<?php

// config for Moneo/RequestForwarder
return [
    // decides which webhook to use if no webhook group name is specified while use middleware
    'default_webhook_group_name' => 'default',

    'webhooks' => [
        'default' => [
            'targets' => [
                [
                    'url' => 'https://some-domain.com/webhook',
                    'method' => 'POST',
                ],
                [
                    'url' => 'https://discord.com/api/webhooks/1209955556656291860/LAaczT-Pg785d5OzBmi6ivx2Vl7wAoruOwcVnZpb2eE2x8tf7fMi6R7_sr0IV0WoK83S',
                    'method' => 'POST',
                    'provider' => \Moneo\RequestForwarder\Providers\Discord::class,
                ],
            ],
        ],
    ],

    'queue_name' => '',

    'queue_class' => Moneo\RequestForwarder\ProcessRequestForwarder::class,
];
