<?php

namespace app\controllers;

use Yii;
use app\models\Student;
use app\models\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Response;
use kartik\form\ActiveForm;
use app\models\College;
use app\models\Degree;
use app\models\Service;
use app\models\RentSearch;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
        ];
    }

    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'colleges' => College::getCollegeList(),
            'degrees' => Degree::getDegreeList(),
        ]);
    }

    /**
     * Displays a single Student model.
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
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Student();

        $model->number = '2011-97548';
        $model->firstname = 'tomas';
        $model->middlename = 'b';
        $model->lastname = 'cabagay';
        $model->sex = 'M';
        $model->college = 3;
        $model->degree = 2;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return $response->data = [
                'result' => 'success',
            ];
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'colleges' => College::getCollegeList(),
                'degrees' => Degree::getDegreeList(),
            ]);
        }
    }

    /**
     * Updates an existing Student model.
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
                'colleges' => College::getCollegeList(),
                'degrees' => Degree::getDegreeList(),
            ]);
        }
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionValidate()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new Student();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }

    public function actionRentHistory($number)
    {
        $searchModel = new RentSearch();
        $dataProvider = $searchModel->searchHistory(Yii::$app->request->queryParams);

        return $this->render('rent-history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'studentModel' => Student::findByNumber($number),
            'services' => Service::getServiceList(),
        ]);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
