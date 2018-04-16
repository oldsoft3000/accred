<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class HeadAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'pace/themes/black/pace-theme-minimal.css'
    ];
    public $js = [
        'pace/pace.min.js',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}