<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=accred',
            'username' => 'root',
            'password' => '818181',
            'charset' => 'utf8',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            //'on afterLogin' => ['app\events\AfterLoginEvent', 'handleNewUser'],
            'enableSession' => true,
            'enableAutoLogin' => true,
            'loginUrl' => null,

        ],
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => true,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
];
