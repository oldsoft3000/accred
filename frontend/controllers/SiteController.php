<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['dashboard', 'agreed'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['dashboard'],
            'rules' => [
                [
                    'actions' => ['dashboard'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actions() {
        return [
            /* 'error' => [
              'class' => 'yii\web\ErrorAction',
              ], */
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        return $this->renderContent(null);
    }

    public function actionLogin() {
        $model = new LoginForm();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {

            Yii::$app->user->identity->generateAuthKey();
            Yii::$app->user->identity->save();
            return ['access_token' => Yii::$app->user->identity->getAuthKey(),
                'is_agreed' => Yii::$app->user->identity->is_agreed];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionGetAgreed() {
        return ['is_agreed' => Yii::$app->user->identity->is_agreed];

    }

    public function actionSetAgreed() {
        Yii::$app->user->identity->setAgreed();
        return ['is_agreed' => Yii::$app->user->identity->is_agreed];
    }

    public function actionDashboard() {
        $response = [
            'username' => Yii::$app->user->identity->username,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
        ];

        return $response;
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                $response = [
                    'flash' => [
                        'class' => 'success',
                        'message' => 'Thank you for contacting us. We will respond to you as soon as possible.',
                    ]
                ];
            } else {
                $response = [
                    'flash' => [
                        'class' => 'error',
                        'message' => 'There was an error sending email.',
                    ]
                ];
            }
            return $response;
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        $model->validate();
        return $model;
    }

    public function actionCities() {

        $str = '
            SELECT name
            FROM bigcities
            WHERE population > 100000
            ORDER BY NAME';

        $command = Yii::$app->db->createCommand($str);
        $rows = $command->queryAll();

        return $rows;
    }

    public function actionError() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

}
