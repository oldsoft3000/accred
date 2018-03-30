<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class UtilsController extends Controller
{
    public $password;
    
    public function options($actionID)
    {
        return ['password'];
    }

    public function actionIndex()
    {
        echo $this->password . "\n";
        $hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        echo $hash . "\n";
    }
}