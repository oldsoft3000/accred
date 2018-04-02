<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\particip */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'particips', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="particip-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'first_name',
            'middle_name',
            'last_name',
            'gender',
            'email:email',
            'date_of_birth',
            'citizenship',
            'passport_type',
            'passport_number',
            'organization',
            'designation',
            'registered_address',
            'status',
            'phone_number',
            'fax_number',
            'visa_required',
            'visa_passport_validity',
            'visa_country',
            'visa_city',
            'dietary_preference',
        ],
    ]) ?>

</div>
