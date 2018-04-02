<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\particip */

$this->title = 'Create particip';
$this->params['breadcrumbs'][] = ['label' => 'particips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="particip-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
