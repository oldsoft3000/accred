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
use app\models\HotelReservation;
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
        return $model_search->searchHotelReservation();
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
        return HotelSearch::getRoomsByHotel($hotel);
    }

    public function actionRoomCategories($hotel) {
        return HotelSearch::getRoomCategoriesByHotel($hotel);
    }

    public function actionRoomTypes($hotel) {
        return HotelSearch::getRoomTypesByHotel($hotel);
    }
    
    public function actionReserve($id /* Particip id */) {
        $reserv_model = new HotelReservation();
        $particip_model = particip::findOne($id);

        if ($particip_model &&
            $reserv_model->load(Yii::$app->getRequest()->getBodyParams(), '') &&
            $reserv_model->save()) {
                $particip_model->hotel_reservation_id = $reserv_model->id;
                if (!\Yii::$app->user->can('update', ['particip' => $particip_model])) {
                    throw new ForbiddenHttpException('Access denied');
                }
                $particip_model->save();
                return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $reserv_model->validate();
            return $reserv_model;
        }
    }
}
