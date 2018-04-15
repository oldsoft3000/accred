<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'croppie/croppie.css',
        //'ngCroppie/ng-croppie.min.css'
    ];
    public $js = [
        'angular/angular.min.js',
        'angular-route/angular-route.min.js',
        'angular-strap/dist/angular-strap.min.js',
        'angular-cookies/angular-cookies.min.js',
        'cleave-js/dist/cleave-angular.min.js',
        'cleave-js/dist/addons/cleave-phone.ru.js',
        'croppie/croppie.min.js',
        'ngCroppie/ng-croppie.min.js',

    ];
   // public $jsOptions = [
   //     'position' => View::POS_HEAD,
    //];
}