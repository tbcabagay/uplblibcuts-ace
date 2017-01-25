<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\data\ActiveDataProvider;

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

    public function actionRentListStudent($status)
    {
        if (!Yii::$app->request->isAjax) {
            $this->redirect(['/dashboard/index']);
        }

        $query = Rent::find();
        $query->where(['status' => $status]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => ['time_in' => SORT_ASC],
            ],
        ]);

        return $this->renderAjax('rent-list-student', [
            'dataProvider' => $dataProvider,
        ]);
    }

}
