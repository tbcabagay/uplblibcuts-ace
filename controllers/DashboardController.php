<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\TimeInRentForm;
use app\models\TimeOutRentForm;
use app\models\Pc;
use app\models\Service;

use yii\web\Response;
use kartik\form\ActiveForm;

class DashboardController extends Controller
{
    public function actionIndex()
    {
        $timeInRentModel = new TimeInRentForm();
        $timeOutRentModel = new TimeOutRentForm();

        return $this->render('index', [
            'timeInRentModel' => $timeInRentModel,
            'timeOutRentModel' => $timeOutRentModel,
            'services' => Service::getServiceList(Service::STATUS_FEATURED),
        ]);
    }

    public function actionTimeIn()
    {
        $model = new TimeInRentForm();

        if ($model->load(Yii::$app->request->post()) && $model->signin()) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            return $response->data = [
                'result' => 'success',
            ];
        }
    }

    public function actionTimeOut()
    {
        $model = new TimeOutRentForm();

        if ($model->load(Yii::$app->request->post()) && $model->signout()) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            return $response->data = [
                'result' => 'success',
            ];
        }
    }

    public function actionValidateTimeIn()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new TimeInRentForm();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }

    public function actionValidateTimeOut()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new TimeOutRentForm();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }
}
