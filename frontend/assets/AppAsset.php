<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/styles.css',
        //'css/custom.css',
        'assets/bootstrap/css/bootstrap.min.css',
    ];
    public $js = [
        //'assets/jquery/jquery.min.js',
        'assets/popper.js/umd/popper.min.js',
        'assets/bootstrap/js/bootstrap.min.js',
        'assets/cleave/cleave-angular.min.js',
        'assets/cleave/addons/cleave-phone.ru.js',
        'App.js',
        'controllers/SiteControllers.js',
        'controllers/ParticipControllers.js',
        'services/SiteServices.js',
        'services/ParticipServices.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapAssetPlugins',
        'frontend\assets\AngularAsset',
    ];

    
}