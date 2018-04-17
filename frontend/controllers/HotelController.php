<?php

namespace frontend\controllers;

use Yii;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use app\models\Hotel;
use app\models\HotelSearch;
use app\models\Particip;
use app\models\ParticipSearch;
use yii\web\ForbiddenHttpException;

class HotelController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        return $behaviors;
    }

    public function actionIndex() {
        return $this->actionView();
    }

    // Список участников
    public function actionView() {
        $model_search = new ParticipSearch();
        $dataProvider = $model_search->searchCreated();
        return $dataProvider->query->all(); 
    }

    // Список отелей
    public function actionHotels($id = null) {
        if ($id == null) {
            return Hotel::find()->all();
        } else {
            return Hotel::findOne($id); 
        }
    }

    // Список Номеров
    public function actionRooms($hotel) {
        $rows = (new \yii\db\Query())
            ->select(['*'])
            ->from('hotel_room')
            ->where(['hotel' => $hotel])
            ->all();

        return $rows;
        
    }
}
