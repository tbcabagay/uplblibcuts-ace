<?php

namespace app\controllers;

use Yii;
use app\models\Rent;
use app\models\RentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\web\Response;
use kartik\form\ActiveForm;
use app\models\Pc;
use app\models\Service;
use app\models\BacklogForm;
use app\models\BacklogBatchForm;

/**
 * RentController implements the CRUD actions for Rent model.
 */
class RentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['accessRent'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Rent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pcs' => Pc::getPcList(null, Yii::$app->user->identity->library),
            'services' => Service::getServiceList(Service::STATUS_FEATURED),
        ]);
    }

    /**
     * Displays a single Rent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Rent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBacklog()
    {
        $model = new BacklogForm();

        if ($model->load(Yii::$app->request->post()) && $model->backlog()) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return $response->data = [
                'result' => 'success',
            ];
        } else {
            return $this->renderAjax('backlog', [
                'model' => $model,
                'featuredServices' => Service::getServiceList(Service::STATUS_FEATURED),
                'pcs' => Pc::getPcList(Pc::STATUS_VACANT),
            ]);
        }
    }

    /**
     * Creates a new Rent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBacklogBatch()
    {
        $searchModel = new RentSearch();
        $dataProvider = $searchModel->searchBacklog(Yii::$app->request->queryParams);
        $model = new BacklogBatchForm();

        if ($model->load(Yii::$app->request->post()) && ($result = $model->backlogBatch())) {
            if ($result['count'] > 0) {
                $session = Yii::$app->getSession();
                $session->setFlash('flashTitle', '<i class="ace-icon fa fa-check-circle"></i>
                ' . Yii::t('app', 'Backlog Batch'));
                $session->setFlash('backlogBatch', Yii::t('app', '{result} rent {count,plural,=1{record} other{records}} has been successfully backlog.', ['result' => $result['count'], 'count' => $result['count']]));
                $this->refresh();
            }
            return $this->refresh();
        } else {
            return $this->render('backlog-batch', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Rent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Rent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->rentRollBack();

        return $this->redirect(['index']);
    }

    public function actionValidateBacklog() 
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new BacklogForm();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }

    public function actionValidateBacklogBatch() 
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new BacklogBatchForm();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }

    /**
     * Finds the Rent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
