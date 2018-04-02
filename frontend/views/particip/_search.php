<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\participSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="particip-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'date_of_birth') ?>

    <?php // echo $form->field($model, 'citizenship') ?>

    <?php // echo $form->field($model, 'passport_type') ?>

    <?php // echo $form->field($model, 'passport_number') ?>

    <?php // echo $form->field($model, 'organization') ?>

    <?php // echo $form->field($model, 'designation') ?>

    <?php // echo $form->field($model, 'registered_address') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'phone_number') ?>

    <?php // echo $form->field($model, 'fax_number') ?>

    <?php // echo $form->field($model, 'visa_required') ?>

    <?php // echo $form->field($model, 'visa_passport_validity') ?>

    <?php // echo $form->field($model, 'visa_country') ?>

    <?php // echo $form->field($model, 'visa_city') ?>

    <?php // echo $form->field($model, 'dietary_preference') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
