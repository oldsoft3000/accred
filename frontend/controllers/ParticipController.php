<?php

namespace app\controllers;

use Yii;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use app\models\Particip;
use app\models\ParticipSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use common\helpers\Formater;

class ParticipController extends Controller {

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

    public function actionView($id = null) {
        if ($id == null) {
            $modelSearch = new ParticipSearch();
            return $modelSearch->searchAll();
        } else {
            $model = $this->findModel($id);
            ParticipController::checkAccess('view', $model);

            $model->date_of_birth = Formater::convertOutput($model->date_of_birth);
            $model->visa_passport_validity = Formater::convertOutput($model->visa_passport_validity);

            return $model;
        }
    }

    public function actionCreate() {
        $model = new Particip();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        ParticipController::checkAccess('update', $model);

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionDelete($id) {

        $model = $this->findModel($id);

        ParticipController::checkAccess('delete', $model);

        Yii::$app->runAction('car/delete', ['id' => $id]);
        Yii::$app->runAction('flight/delete', ['id' => $id]);
        Yii::$app->runAction('hotel/delete', ['id' => $id]);
        Yii::$app->runAction('ticket/delete', ['id' => $id]);

        $model->delete();

        return $model;
    }

    public static function findModel($id) {
        if (($model = particip::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Cant find particip model by id = ' . $id);
    }

    public static function checkAccess($action, $model = null, $params = []) {
        if ($model == null && !empty($params)) {
            foreach ($params as $key => $value) {
                if ($key == 'id') {
                    $model = ParticipController::findModel($value); 
                }  
            }
           
        } 
        if ($model && !\Yii::$app->user->can($action, ['particip' => $model])) {
            throw new ForbiddenHttpException('Access denied');
        }
    }

}
