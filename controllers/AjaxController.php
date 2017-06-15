<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Pc;
use app\models\Rent;
use app\models\Service;
use yii\helpers\ArrayHelper;

class AjaxController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'list-vacant-pc' => ['get'],
                    'recent' => ['get'],
                    'sale-chart' => ['get'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionListVacantPc($library = null)
    {
        if (!Yii::$app->request->isAjax) {
            $this->redirect(['/dashboard/index']);
        }
        $model = Pc::getPcList(Pc::STATUS_VACANT, $library);
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

    public function actionServiceChart($year = null)
    {
        if (!Yii::$app->request->isAjax) {
            $this->redirect(['/dashboard/index']);
        }
        $services = ArrayHelper::getColumn(
            Service::find()
                ->where(['status' => Service::STATUS_FEATURED])
                ->asArray()->all(),
            'name');

        return $this->renderAjax('service-chart', [
            'services' => $services,
            'series' => $this->searchServices($services, $year),
        ]);
    }

    public function actionSaleChart($year = null)
    {
        if (!Yii::$app->request->isAjax) {
            $this->redirect(['/dashboard/index']);
        }
        $services = ArrayHelper::getColumn(
            Service::find()
                ->where(['status' => Service::STATUS_REGULAR])
                ->asArray()->all(),
            'name');

        return $this->renderAjax('sale-chart', [
            'services' => $services,
            'series' => $this->searchSales($services, $year),
        ]);
    }

    protected function searchServices($services, $year)
    {
        $data = []; $yearColumn = []; $totalServices = []; $temp = [];
        foreach ($services as $service) {
            $totalServices[$service] = 0;
        }

        $sql = 'SELECT COUNT(*) AS `total`, FROM_UNIXTIME(`a`.`time_in`, "%Y") AS `year`, `b`.`name` AS `service_name` FROM {{%rent}} `a` LEFT JOIN {{%service}} `b` ON `a`.`service` = `b`.`id` WHERE `a`.`status` = :status GROUP BY `a`.`service`, `year`';
        $sales = Yii::$app->db->createCommand($sql)->bindValue(':status', Rent::STATUS_TIME_OUT)->queryAll();
        if (!empty($sales)) {
            foreach ($sales as $sale) {
                $temp[$sale['year']] = $totalServices;
            }
            foreach ($sales as $sale) {
                $temp[$sale['year']][$sale['service_name']] = intval($sale['total']);
            }
            foreach ($temp as $year => $total) {
                $data[] = [
                    'name' => $year,
                    'data' => array_values($total),
                ];
            }
        }
        return $data;
    }

    protected function searchSales($services, $year)
    {
        $data = []; $yearColumn = []; $totalServices = []; $temp = [];
        foreach ($services as $service) {
            $totalServices[$service] = 0;
        }

        $sql = 'SELECT COUNT(*) AS `total`, FROM_UNIXTIME(`a`.`created_at`, "%Y") AS `year`, `b`.`name` AS `service_name` FROM {{%sale}} `a` LEFT JOIN {{%service}} `b` ON `a`.`service` = `b`.`id` GROUP BY `a`.`service`, `year`';
        $sales = Yii::$app->db->createCommand($sql)->queryAll();
        if (!empty($sales)) {
            foreach ($sales as $sale) {
                $temp[$sale['year']] = $totalServices;
            }
            foreach ($sales as $sale) {
                $temp[$sale['year']][$sale['service_name']] = intval($sale['total']);
            }
            foreach ($temp as $year => $total) {
                $data[] = [
                    'name' => $year,
                    'data' => array_values($total),
                ];
            }
        }
        return $data;

    }

    protected function searchRentTimeInModel($limit = 5)
    {
        return Rent::find()->where(['status' => Rent::STATUS_TIME_IN])->orderBy('time_in DESC')->limit(5)->all();
    }

}
