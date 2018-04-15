<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
    ];
    public $js = [
        'angular/angular.min.js',
        'angular-route/angular-route.min.js',
        'angular-strap/dist/angular-strap.min.js',
        'angular-cookies/angular-cookies.min.js',
        'cleave-js/dist/cleave-angular.min.js',
        'cleave-js/dist/addons/cleave-phone.ru.js',
        'angular-img-cropper/dist/angular-img-cropper.min.js',
        
        //'angular-image-crop/image-crop.js'

    ];
   // public $jsOptions = [
   //     'position' => View::POS_HEAD,
    //];
}