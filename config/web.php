<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'nYfJDBy0sEni9_PUgyp96W7z7hT1OWT3',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/site/index'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/student',
                    'tokens' => [
                        '{number}' => '<number:[\\w+-]*>',
                    ],
                    'patterns' => [
                        'PUT,PATCH {number}' => 'update',
                        'DELETE {number}' => 'delete',
                        'GET,HEAD {number}' => 'view',
                        'POST' => 'create',
                        'GET,HEAD' => 'index',
                        '{number}' => 'options',
                        '' => 'options',
                    ],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'session' => [
            // 'class' => 'app\components\CustomDbSession',
            'class' => 'yii\web\DbSession',
            'sessionTable' => '{{%session}}',
            'writeCallback' => function($session) {
                return [
                    'user' => (Yii::$app->user->getIdentity(false) === null) ? null : Yii::$app->user->getIdentity(false)->id,
                    'ip_address' => Yii::$app->request->userIP,
                ];
            }
        ],
        'formatter' => [
            'currencyCode' => 'PHP',
       ],
    ],
    'params' => $params,
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ],
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
    ],
    'on beforeRequest' => function () {        
        $user = Yii::$app->user->getIdentity();
        if ($user && $user->timezone) {
            Yii::$app->setTimeZone($user->timezone);
        }
    },
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
