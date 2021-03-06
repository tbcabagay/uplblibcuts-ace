<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\AccessControl;

use app\models\TimeInRentForm;
use app\models\TimeOutRentForm;
use app\models\ChangePcForm;
use app\models\SaleForm;
use app\models\Pc;
use app\models\Service;
use app\models\Sale;
use app\models\AcademicCalendar;

use kartik\form\ActiveForm;

class DashboardController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['viewDashboard'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->checkSettings();
        $timeInRentModel = new TimeInRentForm();
        $timeOutRentModel = new TimeOutRentForm();
        $changePcModel = new ChangePcForm();
        $saleModel = new SaleForm();

        return $this->render('index', [
            'timeInRentModel' => $timeInRentModel,
            'timeOutRentModel' => $timeOutRentModel,
            'changePcModel' => $changePcModel,
            'saleModel' => $saleModel,
            'featuredServices' => Service::getServiceList(Service::STATUS_FEATURED),
            'regularServices' => Service::getServiceList(Service::STATUS_REGULAR),
        ]);
    }

    public function actionTimeIn()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

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
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new TimeOutRentForm();

        if ($model->load(Yii::$app->request->post()) && $model->signout()) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            return $response->data = [
                'result' => 'success',
            ];
        }
    }

    public function actionChangePc()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new ChangePcForm();

        if ($model->load(Yii::$app->request->post()) && $model->change()) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            return $response->data = [
                'result' => 'success',
            ];
        }
    }

    public function actionSale()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new SaleForm();

        if ($model->load(Yii::$app->request->post()) && $model->bill()) {
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

    public function actionValidateChangePc()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new ChangePcForm();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }

    public function actionValidateSale()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new SaleForm();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }

    protected function checkSettings()
    {
        $session = Yii::$app->session;

        if (!AcademicCalendar::findActive()) {
            $session->setFlash('flashTitle', '<i class="ace-icon fa fa-exclamation-circle"></i>
                ' . Yii::t('app', 'System Information'));
            $session->setFlash('setAcademicCalendar', Yii::t('app', 'Either the Academic Calendar has not been set or it has already ended.'));
            $this->redirect(['/academic-calendar/index']);
        }
    }
}
