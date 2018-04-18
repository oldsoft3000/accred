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

class FlightController extends Controller {

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
            $model_search = new ParticipSearch();
            return $model_search->searchFlight();     
        } else {
            ParticipController::checkAccess('view', null, ['id' => $id]);

            return $this->findModel($id);
        }
    }

    public function actionCreate() {
        $model = new Flight();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionUpdate($id_flight, $id_particip) {
        $particip_model = ParticipController::findModel($id_particip);

        ParticipController::checkAccess('update', $particip_model);

        $flight_model = $this->findModel($id_flight); 
        if ($flight_model->load(Yii::$app->getRequest()->getBodyParams(), '') &&
            $flight_model->save()) {
                $particip_model->flight_id = $flight_model->id;
                if ($particip_model->save()) {
                    return ['access_token' => Yii::$app->user->identity->getAuthKey()];
                } else {
                    throw new ServerErrorHttpException('Server error.');
                }
        } else {
            $flight->validate(); 
            return $flight; 
        }
    }

    protected function findModel($id) {
        if (($model = flight::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
