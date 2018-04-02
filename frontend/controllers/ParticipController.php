<?php

namespace frontend\controllers;

use Yii;
use app\models\Particip;
use app\models\ParticipSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;



/**
 * participController implements the CRUD actions for particip model.
 */
class ParticipController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;
    
    /**
     * @inheritdoc
     */
    
    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }
    
    
    public function behaviors() {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['http://accred.frontend.client', 'https://www.myserver.com'],
                    'Access-Control-Request-Method' => ['POST', 'PUT', 'DELETE'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['*'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],
            ],
            /*'authenticator' => [
                'class' => HttpBearerAuth::className(),
                'except' => ['options'],
            ],*/
        ];
    }

    /**
     * Lists all particip models.
     * @return mixed
     */
    /*public function actionOptions()
    {
        Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
    } */  
    
    public function actionIndex()
    {
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $searchModel = new ParticipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $data = $searchModel->find()->asArray()->all();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        //Yii::$app->response->headers->set('Access-Control-Allow-Origin', '*');
        return $data;
    }

    /**
     * Displays a single particip model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new particip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Particip();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing particip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing particip model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        
        return $this->actionIndex();
    }

    /**
     * Finds the particip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return particip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = particip::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
