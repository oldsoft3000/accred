<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

$this->title = 'Add';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="particip-add">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Add particip:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-add']); ?>

                <?= $form->field($model, 'first_name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'middle_name')->textInput() ?>

                <?= $form->field($model, 'date_of_birth')->widget(\yii\jui\DatePicker::className(), [
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Add', ['class' => 'btn btn-primary', 'name' => 'add-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
