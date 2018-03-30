<?php
namespace frontend\controllers;

 
use yii\rest\ActiveController;
 
class ParticipiantController extends ActiveController
{
    // указываем класс модели, который будет использоваться
    public $modelClass = 'app\models\Participiant';
 
    public function behaviors()
    {
        return 
        \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ]);
    }
}