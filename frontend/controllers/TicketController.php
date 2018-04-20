<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use app\models\Ticket;
use app\models\Particip;
use app\models\ParticipSearch;
use yii\web\ServerErrorHttpException;
use yii\web\ForbiddenHttpException;
use common\helpers\Formater;

class TicketController extends Controller {

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
            return $modelParticipSearch->searchTicket();     
        } else {
            ParticipController::checkAccess('view', null, ['id' => $id]);

            $modelTicket = $this->findModelByParticip($id);
            if ($modelTicket) {
                $modelTicket->departure_date = Formater::convertInput($modelTicket->departure_date);
                $modelTicket->passport_validity = Formater::convertInput($modelTicket->passport_validity);
            }
            return $modelTicket;
        }
    }

    public function actionCreate() {
        $idParticip = Yii::$app->getRequest()->getBodyParam("idParticip");

        $modelParticip = ParticipController::findModel($idParticip);

        ParticipController::checkAccess('update', $modelParticip);

        $modelTicket = new Ticket();
        if ($modelTicket->load(Yii::$app->getRequest()->getBodyParams(), '') && $modelTicket->save()) {
            $modelParticip->ticket_id = $modelTicket->id;
            if ($modelParticip->save()) {
                return ['access_token' => Yii::$app->user->identity->getAuthKey()];
            } else {
                throw new ServerErrorHttpException('Server error.');
            }
        } else {
            $modelTicket->validate();
            return $modelTicket;
        }
    }

    public function actionUpdate($id) {
        $modelParticip = ParticipController::findModel($id);

        ParticipController::checkAccess('update', $modelParticip);

        $modelTicket = $this->findModelByParticip($id); 
        if ($modelTicket == null) {
            throw new NotFoundHttpException('Cant find flight model by particip id = ' . $id);
        }

        if ($modelTicket->load(Yii::$app->getRequest()->getBodyParams(), '') &&
            $modelTicket->save()) {
                if ($modelParticip->save()) {
                    return ['access_token' => Yii::$app->user->identity->getAuthKey()];
                } else {
                    throw new ServerErrorHttpException('Server error.');
                }
        } else {
            $flight->validate(); 
            return $flight; 
        }
    }

    public function actionDelete($id) {
        $modelParticip = particip::findOne($id);
        ParticipController::checkAccess('delete', $modelParticip);
        $modelTicket = $this->findModelByParticip($id); 
        if ($modelTicket) {
            $modelTicket->delete();
            $modelParticip->ticket_id = 0;
            $modelParticip->save();
        }
        return $modelTicket;
    }

    protected function findModelByParticip($id) {
        if (($modelParticip = particip::findOne($id)) !== null) {
            if ($modelParticip->ticket_id != null) {
                if (($modelTicket = ticket::findOne($modelParticip->ticket_id)) !== null) {
                    return $modelTicket;
                }
            }
            return null;
        }
        return null;
    }


}
