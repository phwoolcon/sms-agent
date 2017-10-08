<?php

use Phwoolcon\SmsAgent\Adapter\SelfHostedAgent;
use Phwoolcon\SmsAgent\Adapter\SmsCn;

return [
    'default'     => 'sms-cn',

    /* sms.cn */
    'sms-cn'      => [
        'adapter'       => SmsCn::class,
        'username'      => '',
        'password_hash' => '',
    ],

    /* self-hosted sms agent */
    'self-hosted' => [
        'adapter'    => SelfHostedAgent::class,
        'url'        => '',
        'client_id'  => '',
        'client_key' => '',
    ],
];
