<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

use yii\web\Response;

return [
    'language' => 'ru-RU',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [ 
        /*[
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],

            'languages' => [
                'ru',
                'en',
            ],

        ],*/
        'log'
    ],
    'controllerNamespace' => 'app\controllers',

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['particip', 'hotel', 'flight', 'ticket', 'car'],
                ],
                '/' => 'site/index',
                '<action:\w+>' => 'site/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ]
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
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'css' => ['css/bootstrap.css'],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => '@bower/bootstrap/dist',
                    'js' => ['js/bootstrap.min.js']
                ],
                'yii\web\JqueryAsset' => [
                    'js' => ['jquery.min.js'],
                    'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
                ],
            ],
            'appendTimestamp' => true,
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
    'params' => $params,
];
