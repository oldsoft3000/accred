<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use app\models\Flight;
use app\models\Particip;
use app\models\ParticipSearch;
use yii\web\ServerErrorHttpException;
use yii\web\ForbiddenHttpException;
use common\helpers\Formater;

class FlightController extends Controller {

    /**
     * @inheritdoc
     */
    /*public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }*/

    public function actionIndex() {
        return $this->actionView();
    }

    public function actionView($id = null) {
        if ($id == null) {
            $modelParticipSearch = new ParticipSearch();
            return $modelParticipSearch->searchFlight();     
        } else {
            ParticipController::checkAccess('view', null, ['id' => $id]);

            $modelFlight = $this->findModelByParticip($id);
            if ($modelFlight) {
                $modelFlight->arrival_date = Formater::convertOutput($modelFlight->arrival_date);
                $modelFlight->departure_date = Formater::convertOutput($modelFlight->departure_date);
            }
            return $modelFlight;
        }
    }

    public function actionCreate() {
        $idParticip = Yii::$app->getRequest()->getBodyParam("idParticip");

        $modelParticip = ParticipController::findModel($idParticip);

        ParticipController::checkAccess('update', $modelParticip);

        $modelFlight = new Flight();
        if ($modelFlight->load(Yii::$app->getRequest()->getBodyParams(), '') && $modelFlight->save()) {
            $modelParticip->flight_id = $modelFlight->id;
            if ($modelParticip->save()) {
                return ['access_token' => Yii::$app->user->identity->getAuthKey()];
            } else {
                throw new ServerErrorHttpException('Server error.');
            }
        } else {
            $modelFlight->validate();
            return $modelFlight;
        }
    }

    public function actionUpdate($id) {
        $modelParticip = ParticipController::findModel($id);

        ParticipController::checkAccess('update', $modelParticip);

        $modelFlight = $this->findModelByParticip($id); 
        if ($modelFlight == null) {
            throw new NotFoundHttpException('Cant find flight model by particip id = ' . $id);
        }

        if ($modelFlight->load(Yii::$app->getRequest()->getBodyParams(), '') &&
            $modelFlight->save()) {
                if ($modelParticip->save()) {
                    return ['access_token' => Yii::$app->user->identity->getAuthKey()];
                } else {
                    throw new ServerErrorHttpException('Server error.');
                }
        } else {
            $modelFlight->validate(); 
            return $modelFlight; 
        }
    }

    public function actionDelete($id) {
        $modelParticip = particip::findOne($id);
        ParticipController::checkAccess('delete', $modelParticip);
        $modelFlight = $this->findModelByParticip($id); 
        if ($modelFlight) {
            $modelFlight->delete();
            $modelParticip->flight_id = 0;
            $modelParticip->save();
        }
        return $modelFlight;
    }

    protected function findModelByParticip($id) {
        if (($modelParticip = particip::findOne($id)) !== null) {
            if ($modelParticip->flight_id != null) {
                if (($modelFlight = flight::findOne($modelParticip->flight_id)) !== null) {
                    return $modelFlight;
                }
            }
            return null;
        }
        return null;
    }


}
