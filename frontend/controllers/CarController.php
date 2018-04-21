<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use app\models\Car;
use app\models\Particip;
use app\models\ParticipSearch;
use yii\web\ServerErrorHttpException;
use yii\web\ForbiddenHttpException;
use common\helpers\Formater;

class CarController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
        return $behaviors;
    }

    public function actionIndex() {
        return $this->actionView();
    }

    public function actionView($id = null) {
        if ($id == null) {
            $modelParticipSearch = new ParticipSearch();
            return $modelParticipSearch->searchCar();     
        } else {
            ParticipController::checkAccess('view', null, ['id' => $id]);

            $modelCar = $this->findModelByParticip($id);
            if ($modelCar) {
                $modelCar->date_of_birth = Formater::convertOutput($modelCar->date_of_birth);
            }
            return $modelCar;
        }
    }

    public function actionCreate() {
        $idParticip = Yii::$app->getRequest()->getBodyParam("idParticip");

        $modelParticip = ParticipController::findModel($idParticip);

        ParticipController::checkAccess('update', $modelParticip);

        $modelCar = new Car();
        if ($modelCar->load(Yii::$app->getRequest()->getBodyParams(), '') && $modelCar->save()) {
            $modelParticip->car_id = $modelCar->id;
            if ($modelParticip->save()) {
                return ['access_token' => Yii::$app->user->identity->getAuthKey()];
            } else {
                throw new ServerErrorHttpException('Server error.');
            }
        } else {
            $modelCar->validate();
            return $modelCar;
        }
    }

    public function actionUpdate($id) {
        $modelParticip = ParticipController::findModel($id);

        ParticipController::checkAccess('update', $modelParticip);

        $modelCar = $this->findModelByParticip($id); 
        if ($modelCar == null) {
            throw new NotFoundHttpException('Cant find car model by particip id = ' . $id);
        }

        if ($modelCar->load(Yii::$app->getRequest()->getBodyParams(), '') &&
            $modelCar->save()) {
                if ($modelParticip->save()) {
                    return ['access_token' => Yii::$app->user->identity->getAuthKey()];
                } else {
                    throw new ServerErrorHttpException('Server error.');
                }
        } else {
            $modelCar->validate(); 
            return $modelCar; 
        }
    }

    public function actionDelete($id) {
        $modelParticip = particip::findOne($id);
        ParticipController::checkAccess('delete', $modelParticip);
        $modelCar = $this->findModelByParticip($id); 
        if ($modelCar) {
            $modelCar->delete();
            $modelParticip->car_id = 0;
            $modelParticip->save();
        }
        return $modelCar;
    }

    protected function findModelByParticip($id) {
        if (($modelParticip = particip::findOne($id)) !== null) {
            if ($modelParticip->car_id != null) {
                if (($modelCar = car::findOne($modelParticip->car_id)) !== null) {
                    return $modelCar;
                }
            }
            return null;
        }
        return null;
    }


}
