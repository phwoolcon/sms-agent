<?php

return [
    'phwoolcon/sms-agent' => [
        'di' => [
            20 => 'di.php', // 20 stands for the loading sequence, bigger number will be loaded later
        ],
        'commands' => [
            // 20 stands for the loading sequence, bigger number will be loaded later
            20 => [
//                'your:command' => Phwoolcon\SmsAgent\Command\YourCommand::class,
            ],
        ],
        'class_aliases' => [
            // 20 stands for the loading sequence, bigger number will be loaded later
            20 => [
                'SmsAgent' => Phwoolcon\SmsAgent\SmsAgent::class,
            ],
        ],
    ],
];
