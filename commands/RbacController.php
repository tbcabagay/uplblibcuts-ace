<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        echo "Initializing RBAC...\n\n";
        $auth = Yii::$app->authManager;

        $student = $auth->createRole('Student');
        $auth->add($student);
        echo "Student role added...\n";

        $studentAssistant = $auth->createRole('Student Assistant');
        $auth->add($studentAssistant);
        $auth->addChild($studentAssistant, $student);
        echo "Student Assistant role added...\n";

        $staff = $auth->createRole('Staff');
        $auth->add($staff);
        $auth->addChild($staff, $studentAssistant);
        echo "Staff role added...\n";

        $administrator = $auth->createRole('Administrator');
        $auth->add($administrator);
        $auth->addChild($administrator, $staff);
        echo "Administrator role added...\n\n";
        echo "Done.\n";
    }
}