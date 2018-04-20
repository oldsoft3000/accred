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
use yii\web\ServerErrorHttpException;
use common\helpers\Formater;

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
    public function actionView($id = null) {
        if ($id == null) {
            $modelSearch = new ParticipSearch();
            return $modelSearch->searchHotelReservation();   
        } else {
            ParticipController::checkAccess('view', null, ['id' => $id]);
            $modelReserve = $this->findModelByParticip($id);
            if ($modelReserve) {
                $modelReserve->arrival_date = Formater::convertOutput($modelReserve->arrival_date);
                $modelReserve->departure_date = Formater::convertOutput($modelReserve->departure_date);
            }
            return $modelReserve;
        }
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
        $modelParticip = particip::findOne($id);
        ParticipController::checkAccess('update', $modelParticip);
        $modelReserveOld = $this->findModelByParticip($id); 
        $modelReserve = new HotelReservation();

        if ($modelReserve->load(Yii::$app->getRequest()->getBodyParams(), '') &&
            $modelReserve->save()) {
                $modelParticip->hotel_reservation_id = $modelReserve->id;
                if ($modelParticip->save()) {
                    if ($modelReserveOld) {
                        $modelReserveOld->delete();
                    }
                    return ['access_token' => Yii::$app->user->identity->getAuthKey()];
                } else {
                    throw new ServerErrorHttpException('Server error.');
                }
        } else {
            $modelReserve->validate(); 
            return $modelReserve; 
        }
    }

    public function actionDelete($id) {
        $modelParticip = particip::findOne($id);
        ParticipController::checkAccess('delete', $modelParticip);
        $modelReserve = $this->findModelByParticip($id); 
        if ($modelReserve) {
            $modelParticip->hotel_reservation_id = 0;
            $modelParticip->save();
            $modelReserve->delete();
        }
        return $modelReserve;
    }

    protected function findModelByParticip($id) {
        if (($modelParticip = particip::findOne($id)) !== null) {
            if ($modelParticip->hotel_reservation_id != null) {
                if (($modelHotelReservation = hotelReservation::findOne($modelParticip->hotel_reservation_id)) !== null) {
                    return $modelHotelReservation;
                }
            }
            return null;
        }
        return null;
    }
}
