<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Url;

use app\models\User;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\Library;
use kartik\form\ActiveForm;
use kartik\widgets\Growl;

class SiteController extends Controller
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
                    'logout' => ['post'],
                    'set_timezone' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // Yii::$app->session['timeZone'] = 'Asia/Manila';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/dashboard/index']);
        }

        $this->layout = 'login';

        $loginModel = new LoginForm();
        $registerModel = new RegisterForm();

        $response = Yii::$app->response;

        if (Yii::$app->request->isAjax && $registerModel->load(Yii::$app->request->post()) && $registerModel->signup()) {
            $body = Yii::$app->params['autoConfirmAccount'] ?
                Yii::t('app', 'The account has been successfully created. You may now login to the system using the registered credentials.'): Yii::t('app', 'The account has been successfully created. Please wait while the administrator approves your request.');
            Yii::$app->session->setFlash('success', [
                'title' => 'Congratulations!',
                'body' => $body,
            ]);
            $response->format = Response::FORMAT_JSON;
            return $response->data = [
                'result' => 'success',
                'href' => Url::toRoute(['/site/index'], true),
            ];
        } else if (/*Yii::$app->request->isAjax && */$loginModel->load(Yii::$app->request->post()) && $loginModel->login()) {
            $response->format = Response::FORMAT_JSON;
            return $response->data = [
                'result' => 'success',
                'href' => Url::toRoute(['/site/index'], true),
            ];
        }
        
        return $this->render('index', [
            'loginModel' => $loginModel,
            'registerModel' => $registerModel,
            'libraries' => Library::getLibraryList(),
            'roles' => User::getRoleList(),
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->destroy();

        return $this->goHome();
    }

    /**
     * Validate Signup action.
     *
     * @return string
     */
    public function actionValidateSignup()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }

    /*
     *
     */
    public function actionSetTimezone($timezone)
    {
        $timezones = [
            'Manila' => 'Asia/Manila',
            'UTC' => 'UTC',
        ];
        if (isset($timezones[$timezone])) {
            $model = User::findOne(Yii::$app->user->identity->getId());
            $model->setAttribute('timezone', $timezones[$timezone]);
            if ($model->update() !== false) {
                $response = Yii::$app->response;
                $response->format = Response::FORMAT_JSON;

                return $response->data = [
                    'result' => 'success',
                    'message' => Yii::t('app', 'Successfully changed time zone to {timezone}', [
                        'timezone' => $timezones[$timezone],
                    ]),
                ];
            }
        }
    }

    /**
     * Validate Login action.
     *
     * @return string
     */
    public function actionValidateLogin()
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
    }
}
