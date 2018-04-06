<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Particip */
/* @var $form ActiveForm */
?>
<div class="ParticipView">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'first_name') ?>
        <?= $form->field($model, 'middle_name') ?>
        <?= $form->field($model, 'last_name') ?>
        <?= $form->field($model, 'gender') ?>
        <?= $form->field($model, 'citizenship') ?>
        <?= $form->field($model, 'passport_type') ?>
        <?= $form->field($model, 'passport_number') ?>
        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'date_of_birth') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'organization') ?>
        <?= $form->field($model, 'designation') ?>
        <?= $form->field($model, 'registered_address') ?>
        <?= $form->field($model, 'phone_number') ?>
        <?= $form->field($model, 'fax_number') ?>
        <?= $form->field($model, 'visa_passport_validity') ?>
        <?= $form->field($model, 'visa_country') ?>
        <?= $form->field($model, 'visa_city') ?>
        <?= $form->field($model, 'dietary_preference') ?>
        <?= $form->field($model, 'visa_required') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- ParticipView -->
