<?php

namespace app\controllers;

use Yii;
use app\models\AcademicCalendar;
use app\models\AcademicCalendarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Student;
use yii\web\Response;
use kartik\form\ActiveForm;

/**
 * AcademicCalendarController implements the CRUD actions for AcademicCalendar model.
 */
class AcademicCalendarController extends Controller
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
                    'toggle-status' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['setAcademicCalendar'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all AcademicCalendar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AcademicCalendarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AcademicCalendar model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AcademicCalendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AcademicCalendar();
        $model->scenario = AcademicCalendar::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Student::resetRentTime();
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return $response->data = [
                'result' => 'success',
            ];
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'semesters' => AcademicCalendar::getSemesterList(),
            ]);
        }
    }

    /**
     * Updates an existing AcademicCalendar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return $response->data = [
                'result' => 'success',
            ];
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'semesters' => AcademicCalendar::getSemesterList(),
            ]);
        }
    }

    /**
     * Deletes an existing AcademicCalendar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionValidate($id = null)
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($id === null) {
            $model = new AcademicCalendar();
            $model->scenario = AcademicCalendar::SCENARIO_CREATE;
        } else {
            $model = $this->findModel($id);
        }

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }

    public function actionToggleStatus($id)
    {
        $model = $this->findModel($id);
        $model->setAttribute('status', AcademicCalendar::STATUS_INACTIVE);
        $model->update();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AcademicCalendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AcademicCalendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AcademicCalendar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
