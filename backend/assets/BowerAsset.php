<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'croppie/croppie.css',
        'pace/themes/black/pace-theme-minimal.css',
        'angular-moment-picker/dist/angular-moment-picker.min.css',
        'datatables.net-dt/css/jquery.dataTables.css',
        'angular-datatables/dist/css/angular-datatables.min.css'
        //'ngCroppie/ng-croppie.min.css'
    ];
    public $js = [
        'angular/angular.min.js',
        'angular-route/angular-route.min.js',
        'angular-strap/dist/angular-strap.min.js',
        'angular-cookies/angular-cookies.min.js',
        'angular-resource/angular-resource.min.js',
        'angular-sanitize/angular-sanitize.min.js',
        'cleave-js/dist/cleave-angular.min.js',
        'cleave-js/dist/addons/cleave-phone.ru.js',
        'croppie/croppie.min.js',
        'pace/pace.min.js',
        'moment/min/moment-with-locales.min.js',
        'angular-moment-picker/dist/angular-moment-picker.min.js',
        'datatables.net/js/jquery.dataTables.js',
        'angular-datatables/dist/angular-datatables.min.js'

    ];


    public $jsOptions = [
        //'position' => View::POS_HEAD,
    ];
}