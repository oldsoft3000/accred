<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class NpmAsset extends AssetBundle
{
    public $sourcePath = '@npm';
    public $css = [

    ];
    public $js = [

    ];


    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}