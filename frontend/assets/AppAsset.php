<?php

namespace frontend\assets;

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
        'controllers/HotelControllers.js',
        'controllers/FlightControllers.js',
        'services/FlightServices.js',
        'services/SiteServices.js',
        'services/ParticipServices.js',
        'services/HotelServices.js',
        'services/Utils.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'frontend\assets\AngularAsset',
    ];

    
}