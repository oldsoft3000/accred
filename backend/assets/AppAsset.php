<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/styles.css',
        'css/datatable.css',
        'css/badge.css',
    ];
    public $js = [
        'App.js',
        'controllers/SiteControllers.js',
        'controllers/ParticipControllers.js',
        'services/SiteServices.js',
        'services/ParticipServices.js',
        'services/Utils.js',
        'directives/Badge.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\BowerAsset'
    ];

}