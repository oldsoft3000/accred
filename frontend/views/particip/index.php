<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\participSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'particips';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="particip-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create particip', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'first_name',
            'middle_name',
            'last_name',
            //'gender',
            //'email:email',
            //'date_of_birth',
            //'citizenship',
            //'passport_type',
            //'passport_number',
            //'organization',
            //'designation',
            //'registered_address',
            //'status',
            //'phone_number',
            //'fax_number',
            //'visa_required',
            //'visa_passport_validity',
            //'visa_country',
            //'visa_city',
            //'dietary_preference',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
