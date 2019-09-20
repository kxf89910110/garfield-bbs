<?php
    return [
        // HTTP request timeout (seconds)
        'timeout' => 5.0,

        // Default send configuration
        'default' => [
            // Gateway call policy, default: sequential call
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

            // Default available send gateway
            'gateways' => [
                'qcloud',
            ],
        ],
        // Available gateway configuration
        'gateways' => [
            'errorlog' => [
                'file' => '/tmp/easy-sms.log',
            ],
            'qcloud' => [
                'sdk_app_id' => env('QCLOUD_SMS_APP_ID'),
                'app_key' => env('QCLOUD_SMS_APP_KEY'),
            ],
        ],
    ];
