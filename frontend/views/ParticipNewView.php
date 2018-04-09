<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ParticipNew */
/* @var $form ActiveForm */
?>
<div class="ParticipNewView">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'gender') ?>
        <?= $form->field($model, 'passport_series') ?>
        <?= $form->field($model, 'passport_number') ?>
        <?= $form->field($model, 'first_name') ?>
        <?= $form->field($model, 'middle_name') ?>
        <?= $form->field($model, 'last_name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'date_of_birth') ?>
        <?= $form->field($model, 'organization') ?>
        <?= $form->field($model, 'registration_address') ?>
        <?= $form->field($model, 'phone_number') ?>
        <?= $form->field($model, 'visa_passport_validity') ?>
        <?= $form->field($model, 'visa_country') ?>
        <?= $form->field($model, 'visa_city') ?>
        <?= $form->field($model, 'place_of_birth') ?>
        <?= $form->field($model, 'first_name_latin') ?>
        <?= $form->field($model, 'last_name_latin') ?>
        <?= $form->field($model, 'position') ?>
        <?= $form->field($model, 'organization_latin') ?>
        <?= $form->field($model, 'position_latin') ?>
        <?= $form->field($model, 'photo') ?>
        <?= $form->field($model, 'citizenship') ?>
        <?= $form->field($model, 'visa_required') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- ParticipNewView -->
