<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
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
        'frontend\assets\AngularAsset',
    ];
}