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
        if (!\Yii::$app->user->can('admin') && $model->card_locked_date != null) {
            throw new ForbiddenHttpException('Access denied');
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

        ParticipController::checkAccess('delete', $model);

        Yii::$app->runAction('car/delete', ['id' => $id]);
        Yii::$app->runAction('flight/delete', ['id' => $id]);
        Yii::$app->runAction('hotel/delete', ['id' => $id]);
        Yii::$app->runAction('ticket/delete', ['id' => $id]);

        $model->delete();

        return $model;
    }

    public function actionGenerate() {
        $model = new Particip();
        ParticipController::checkAccess('unlock', $model);
        $faker = \Faker\Factory::create('ru_RU');
        $faker_latin = \Faker\Factory::create('en_EN');

        $name = explode(" ", $faker->name);
        $name_latin = explode(" ", $faker_latin->name);
        $model->title = 1;
        $model->gender = 1;
        $model->passport_series = $faker->randomNumber(4);
        $model->passport_number = $faker->randomNumber(6);
        $model->last_name = $name[0];
        $model->first_name = $name[1];
        $model->middle_name = $name[2];
        $model->email = $faker->email;
        $model->date_of_birth = $faker->dateTimeThisCentury();
        $model->registration_address = $faker->address;
        $model->phone_number = $faker->phoneNumber;
        $model->place_of_birth = $faker->city;
        $model->first_name_latin = $name_latin[1];
        $model->last_name_latin = $name_latin[0];

        $model->organization = $faker->company;
        $model->organization_latin = $faker_latin->company;
        $model->position = $faker->jobTitle;
        $model->position_latin = $faker_latin->jobTitle;
        $model->citizenship = 'RU';
        $model->photo = 'data:image/jpg;base64,' . base64_encode(file_get_contents($faker->imageUrl(100, 100, 'cats')));
        $model->visa_required = 0;
        
        if (!$model->save()) {
            $model->validate();
        }
        
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
