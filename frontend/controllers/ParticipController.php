<?php

namespace frontend\controllers;

use Yii;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use app\models\Particip;
use app\models\ParticipSearch;
use yii\web\ForbiddenHttpException;

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
            $model_search = new ParticipSearch();
            $dataProvider = $model_search->searchCreated();
            return $dataProvider->query->all(); 
        } else {
            $model = $this->findModel($id);
            if (!\Yii::$app->user->can('view', ['particip' => $model])) {
                throw new ForbiddenHttpException('Access denied index');
            }
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

        if (!\Yii::$app->user->can('update', ['particip' => $model])) {
            throw new ForbiddenHttpException('Access denied update');
        }

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionDelete($id) {

        $model = $this->findModel($id);

        if (!\Yii::$app->user->can('delete', ['particip' => $model])) {
            throw new ForbiddenHttpException('Access denied delete');
        }

        $model->delete();

        return $model;
    }

    protected function findModel($id) {
        if (($model = particip::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
