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
        /*return array_merge(parent::actions(), [
            'index' => null,
            'view' => null,
            'create' => null,
            'update' => null,
            'delete' => null,
        ]);*/
        $actions = parent::actions();
        $actions['view']['findModel'] = [$this, 'findModel', 1];
        return $actions;
    }

    public function actionView($number)
    {
        return $this->findModel($number);
    }

    public function findModel($id)
    {
        //$model = $this->modelClass::findOne(['number' => $number]);
        $model = $this->modelClass::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Object not found: $number");
        }
        return $model;
    }

}
