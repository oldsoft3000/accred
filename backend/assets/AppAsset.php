<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/bootstrap.css',
        'css/styles.css',
    ];
    public $js = [
        'App.js',
        'controllers/SiteControllers.js',
        'controllers/ParticipControllers.js',
        'services/SiteServices.js',
        'services/ParticipServices.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'app\assets\AngularAsset',
    ];

    
}