<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use app\models\Pc;
use app\models\Rent;

class AjaxController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list-pc' => ['get'],
                    'rent-list-student' => ['get'],
                ],
            ],
        ];
    }

    public function actionListPc($library = null, $status = null)
    {
        if (!Yii::$app->request->isAjax) {
            $this->redirect(['/dashboard/index']);
        }

        $model = Pc::getPcList($library, $status);
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;

        return $response->data = [
            'model' => $model,
        ];
    }

    public function actionRecent()
    {
        if (!Yii::$app->request->isAjax) {
            $this->redirect(['/dashboard/index']);
        }

        return $this->renderAjax('recent', [
            'students' => $this->searchRentTimeInModel(),
        ]);
    }

    protected function searchRentTimeInModel($limit = 5)
    {
        return Rent::find()->where(['status' => Rent::STATUS_TIME_IN])->orderBy('time_in DESC')->limit(5)->all();
    }

}
