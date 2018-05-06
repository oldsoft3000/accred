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
        'datatables/media/css/jquery.dataTables.min.css',
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
        'datatables/media/js/jquery.dataTables.min.js',
        'datatables-light-columnfilter/dist/dataTables.lightColumnFilter.min.js',
        //'jquery-datatables-columnfilter/jquery.dataTables.columnFilter.js',
        'angular-datatables/dist/angular-datatables.min.js',
        //'angular-datatables/dist/plugins/columnfilter/angular-datatables.columnfilter.min.js'
        'angular-datatables/dist/plugins/light-columnfilter/angular-datatables.light-columnfilter.min.js',
        'alasql/dist/alasql.min.js',
        'js-xlsx/dist/xlsx.full.min.js'
        

    ];


    public $jsOptions = [
        //'position' => View::POS_HEAD,
    ];
}