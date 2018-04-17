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
use app\models\ReservationHotel;
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
        /*$rows = (new \yii\db\Query())
            ->select(['*'])
            ->from('hotel_room')
            ->join('JOIN', 'room_category', 'room_category.id = hotel_room.category')
            ->join('JOIN', 'room_type', 'room_type.id = hotel_room.type')
            ->where(['hotel' => $hotel])
            ->all();*/

        /*$rows = Yii::$app->db->createCommand('
            SELECT  hotel_room.id,
                    hotel_room.cost,
                    room_category.id as category_id,
                    room_category.name as category_name,
                    room_type.id as type_id,
                    room_type.name as type_name
            FROM `hotel_room`
            JOIN room_category ON room_category.id = hotel_room.category
            JOIN room_type ON room_type.id = hotel_room.type
            WHERE hotel_room.hotel=:id')
            ->bindValue(':id', $hotel)
            ->queryAll();*/
        $rows = Yii::$app->db->createCommand('
            SELECT  *
            FROM `hotel_room`
            WHERE hotel_room.hotel=:id')
            ->bindValue(':id', $hotel)
            ->queryAll();

        return $rows;
        
    }

    public function actionRoomCategories($hotel) {
        $rows = Yii::$app->db->createCommand('
            SELECT  DISTINCT room_category.id, room_category.name
            FROM `hotel_room`
            JOIN room_category ON room_category.id = hotel_room.category
            WHERE hotel_room.hotel=:id')
            ->bindValue(':id', $hotel)
            ->queryAll();

        return $rows;
    }

    public function actionRoomTypes($hotel) {
        $rows = Yii::$app->db->createCommand('
            SELECT  DISTINCT room_type.id, room_type.name
            FROM `hotel_room`
            JOIN room_type ON room_type.id = hotel_room.type
            WHERE hotel_room.hotel=:id')
            ->bindValue(':id', $hotel)
            ->queryAll();

        return $rows;
    }
    /* Particip id */
    public function actionReserve($id) {
        $reserv_model = new ReservationHotel();
        $particip_model = particip::findOne($id);

        if ($particip_model &&
            $reserv_model->load(Yii::$app->getRequest()->getBodyParams(), '') &&
            $reserv_model->save()) {
                $particip_model->reservation_hotel = $reserv_model->id;
                $particip_model->save();
                return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $reserv_model->validate();
            return $reserv_model;
        }
    }
}
