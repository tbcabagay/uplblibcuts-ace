<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\TimeInRentForm;
use app\models\Pc;
use app\models\Service;

use yii\web\Response;
use kartik\form\ActiveForm;

class DashboardController extends Controller
{
    public function actionIndex()
    {
    	$timeInRentModel = new TimeInRentForm();

        return $this->render('index', [
        	'timeInRentModel' => $timeInRentModel,
        	'pcs' => Pc::getPcList(),
        	'services' => Service::getServiceList(Service::STATUS_MAIN),
        ]);
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
}
