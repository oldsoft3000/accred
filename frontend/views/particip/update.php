<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\particip */

$this->title = 'Update particip: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'particips', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="particip-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
