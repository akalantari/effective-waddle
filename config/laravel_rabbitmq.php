<?php
/** For documentation, see https://github.com/needle-project/laravel-rabbitmq */
return [
    'connections' => [
        'rabbitLocal' => [
            'hostname' => 'host.docker.internal',
            'port' => 5672,
            'username' => 'adminuser',
            'password' => 'adminpass',
            'vhost' => '/',
            'lazy' => true,
        ]
    ],
    'exchanges' => [
        'subscription_verify' => [
            'connection' => 'rabbitLocal',
            'name' => 'subscription_verify',
            'attributes' => [
                'auto_create' => true,
                'exchange_type' => 'direct',
                'throw_exception_on_redeclare' => false
            ]
        ],
        'subscription_verify_retry' => [
            'connection' => 'rabbitLocal',
            'name' => 'subscription_verify_retry',
            'attributes' => [
                'auto_create' => true,
                'exchange_type' => 'direct',
                'throw_exception_on_redeclare' => false
            ]
        ]
    ],
    'queues' => [
        'subscription_verify_queue' => [
            'connection' => 'rabbitLocal',
            'name' => 'subscription_verify_queue',
            'attributes' => [
                'auto_create' => true,
                'durable' => true,
                'bind' => [['exchange' => 'subscription_verify', 'routing_key' => '']],
                'throw_exception_on_redeclare' => false,
                'arguments' => [
                    'x-dead-letter-exchange' => ['S','subscription_verify_retry'],
                ]
            ]
        ],
        'subscription_verify_retry_queue' => [
            'connection' => 'rabbitLocal',
            'name' => 'subscription_verify_retry_queue',
            'attributes' => [
                'auto_create' => true,
                'durable' => true,
                'throw_exception_on_redeclare' => false,
                'bind' => [['exchange' => 'subscription_verify_retry','routing_key' => '*']],
                'arguments' => [
                    'x-dead-letter-exchange' => ['S','subscription_verify'],
                    'x-message-ttl' => ['I',10000]
                ]
            ]
        ]
    ],
    'publishers' => [
        'subscriptionVerifyPublisher' => 'subscription_verify',
        'subscriptionVerifyRetryPublisher' => 'subscription_verify_retry'
    ],
    'consumers' => [
        'subscriptionVerifyConsumer' => [
            'queue' => 'subscription_verify_queue',
            'prefetch_count' => 1,
            'message_processor' => \App\Queues\Processors\SubscriptionVerifyProcessor::class
        ],
        'subscriptionVerifyRetryConsumer' => [
            'queue' => 'subscription_verify_retry_queue',
            'prefetch_count' => 1,
            'message_processor' => \NeedleProject\LaravelRabbitMq\Processor\CliOutputProcessor::class
        ],
    ]
];
