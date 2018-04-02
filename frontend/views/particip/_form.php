<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\particip */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="particip-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_birth')->widget(
    \yii\jui\DatePicker::className(),[
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options' => ['style'=>'width:500px;height:38px;display:block;'], 
    ]) ?> 

    <?= $form->field($model, 'citizenship')->textInput() ?>

    <?= $form->field($model, 'passport_type')->textInput() ?>

    <?= $form->field($model, 'passport_number')->textInput() ?>

    <?= $form->field($model, 'organization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'designation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'registered_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fax_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visa_required')->textInput() ?>

    <?= $form->field($model, 'visa_passport_validity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visa_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visa_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dietary_preference')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
