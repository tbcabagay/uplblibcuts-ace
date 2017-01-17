<?php

return [
    'adminEmail' => 'admin@example.com',
    'appName' => 'Computer Usage Tracking System',
    'appOwner' => 'UP Los Banos',

    'autoConfirmAccount' => false,
    'rememberMeDuration' => 3600*24*30,
    'studentRentTime' => 20 * 60 * 60,

    'maskMoneyOptions' => [
        'prefix' => 'PHP ',
        'suffix' => '',
        'affixesStay' => true,
        'thousands' => ',',
        'decimal' => '.',
        'precision' => 2, 
        'allowZero' => false,
        'allowNegative' => false,
    ],
];
