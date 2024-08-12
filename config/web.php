<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

use \yii\web\Request;

$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());

$config = [
    'id' => 'library-mangement-system',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'backup' => [
            'class' => 'amoracr\backup\Backup',
            'backupDir' => '@app/backups',
            'databases' => [
                [
                    'class' => 'amoracr\backup\components\MySqlBackup',
                    'dsn' => 'mysql:host=localhost;dbname=library_management_system',
                    'username' => 'root',
                    'password' => '',
                    'backupDir' => '@app/backups',
                    'fileName' => 'library_management_system_' . date('Ymd_His') . '.sql',
                    'compression' => 'gzip',
                    'tables' => [],
                ],
            ],
            'directories' => [
                'images' => '@app/web/images',
                'uploads' => '@app/web/uploads',
            ],
        ],

        // 'backup' => [
        //     'class' => 'amoracr\backup\Backup',
        //     'backupDir' => '/home/hak-coder/Downloads',
        //     'databases' => [
        //         [
        //             'class' => 'amoracr\backup\components\MySqlBackup',
        //             'dsn' => 'mysql:host=localhost;dbname=library_management_system',
        //             'username' => 'root',
        //             'password' => '',
        //             'backupDir' => '/home/hak-coder/Downloads',
        //             'fileName' => 'library_management_system_' . date('Ymd_His') . '.sql',
        //             'compression' => 'gzip',
        //             'tables' => [],
        //         ],
        //     ],
        //     'directories' => [
        //         'images' => '@app/web/images',
        //         'uploads' => '@app/web/uploads',
        //     ],
        // ],

        'fullcalendar' => [
            'class' => 'philippfrenzel\yii2fullcalendar\Fullcalendar',
        ],

        'master' => [
            'class' => 'app\components\Master',
        ],
        'setupdata' => [
            'class' => 'app\components\Setupdata',
        ],

        'formater' => [
            'class' => 'app\components\Formater',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'PRO_q*ky~S#8Q-<m8TTp',
            'baseUrl' => $baseUrl,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
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
        'db' => $db,
        'urlManager' => [
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'events/get-events' => 'site/get-events',
            ],
        ],
    ],

    'controllerMap' => [
        'backup' => 'app\commands\BackupController',
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'actions' => ['login', 'error'],
                'allow' => true,
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}
$config['timezone'] = 'Asia/Phnom_Penh';

return $config;
