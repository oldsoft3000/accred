<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $js = [
        'angular/angular.min.js',
        'angular-route/angular-route.min.js',
        'angular-strap/dist/angular-strap.min.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}