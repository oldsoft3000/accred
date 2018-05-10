<?php

namespace app\controllers;

use Yii;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use app\models\Hotel;
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
            return $modelSearch->searchHotel();
        } else {
            ParticipController::checkAccess('view', null, ['id' => $id]);
            $modelHotel = $this->findModelByParticip($id);
            if ($modelHotel) {
                $modelHotel->arrival_date = Formater::convertOutput($modelHotel->arrival_date);
                $modelHotel->departure_date = Formater::convertOutput($modelHotel->departure_date);
            }
            return $modelHotel;
        }
    }

    public function actionReserve($id /* Particip id */) {
        $modelParticip = particip::findOne($id);
        ParticipController::checkAccess('update', $modelParticip);
        $modelHotelOld = $this->findModelByParticip($id);
        $modelHotel = new Hotel();

        if ($modelHotel->load(Yii::$app->getRequest()->getBodyParams(), '') &&
                $modelHotel->save()) {
            $modelParticip->hotel_id = $modelHotel->id;
            if ($modelParticip->save()) {
                if ($modelHotelOld) {
                    $modelHotelOld->delete();
                }
                $this->sendReserveForm($modelParticip);
                return ['access_token' => Yii::$app->user->identity->getAuthKey()];
            } else {
                throw new ServerErrorHttpException('Server error.');
            }
        } else {
            $modelHotel->validate();
            return $modelHotel;
        }
    }

    public function actionDelete($id) {
        $modelParticip = particip::findOne($id);
        ParticipController::checkAccess('delete', $modelParticip);
        $modelHotel = $this->findModelByParticip($id);
        if ($modelHotel) {
            $modelParticip->hotel_id = 0;
            $modelParticip->save();
            $modelHotel->delete();
        }
        return $modelHotel;
    }

    private function sendReserveForm($modelParticip) {
        Yii::$app->mailer->compose()
    ->setFrom('from@domain.com')
    ->setTo('oldsoft3000@gmail.com')
    ->setSubject('Message subject')
    ->setTextBody('Plain text content')
    ->setHtmlBody('<b>HTML content</b>')
    ->send();
    }   

    protected function findModelByParticip($id) {
        if (($modelParticip = particip::findOne($id)) !== null) {
            if ($modelParticip->hotel_id != null) {
                if (($modelHotel = hotel::findOne($modelParticip->hotel_id)) !== null) {
                    return $modelHotel;
                }
            }
            return null;
        }
        return null;
    }

}
