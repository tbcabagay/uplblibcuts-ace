<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $studentAssistant = $auth->createRole('Student Assistant');
        $auth->add($studentAssistant);

        $staff = $auth->createRole('Staff');
        $auth->add($staff);
        $auth->addChild($staff, $studentAssistant);

        $administrator = $auth->createRole('Administrator');
        $auth->add($administrator);
        $auth->addChild($administrator, $staff);
    }
}