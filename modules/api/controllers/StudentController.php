<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\web\NotFoundHttpException;
use app\models\Student;

class StudentController extends ActiveController
{
    public $modelClass = 'app\models\Student';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['create'], $actions['update'], $actions['delete']);

        return $actions;
    }

    public function actionView($number)
    {
        return $this->findModel($number);
    }

    public function findModel($number)
    {
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne(['number' => $number]);
        if (!$model) {
            throw new NotFoundHttpException("Object not found: $number");
        }
        return $model;
    }

}
