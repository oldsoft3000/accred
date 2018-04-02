<?php
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';

use Yii;

Yii::$app->security->generatePasswordHash($password);
?>
