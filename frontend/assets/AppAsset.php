<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
       
        'css/bootstrap.css',
        'css/styles.css',
        //'css/ngImgCrop-master/compile/minified/ng-img-crop.css'
    ];
    public $js = [
        //'assets/jquery/jquery.min.js',
        //'assets/jquery/jquery-3.3.1.min.js',
        //'assets/popper.js/umd/popper.min.js',
        //'assets/bootstrap/js/bootstrap.min.js',
        //'assets/cleave/cleave-angular.min.js',
        //'assets/ngImgCrop-master/compile/minified/ng-img-crop.js',
        'App.js',
        'controllers/SiteControllers.js',
        'controllers/ParticipControllers.js',
        'services/SiteServices.js',
        'services/ParticipServices.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'frontend\assets\AngularAsset',
    ];

    
}