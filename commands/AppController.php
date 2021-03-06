<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\College;
use app\models\Degree;
use app\models\Formula;
use app\models\Service;
use app\models\Library;
use app\models\User;
use app\models\Pc;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 */
class AppController extends Controller
{
    private $_colleges = [];
    private $_degrees = [];
    private $_formulas = [];
    private $_services = [];
    private $_libraries = [];

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionInit()
    {
        $error = false;
        echo "Initializing college data...\n";

        $this->_colleges = [
            [
                'code' => 'CA',
                'description' => 'College Of Agriculture',
                'switch' => 0,
            ],
            [
                'code' => 'CACAS',
                'description' => 'CA-CAS Joint Program',
                'switch' => 0,
            ],
            [
                'code' => 'CAS',
                'description' => 'College Of Arts And Sciences',
                'switch' => 0,
            ],
            [
                'code' => 'CDC',
                'description' => 'College Of Development Communication',
                'switch' => 0,
            ],
            [
                'code' => 'CEAT',
                'description' => 'College Of Engineering And Agro-industrial Technology',
                'switch' => 0,
            ],
            [
                'code' => 'CEM',
                'description' => 'College Of Economics And Management',
                'switch' => 0,
            ],
            [
                'code' => 'CFNR',
                'description' => 'College Of Forestry And Natural Resources',
                'switch' => 0,
            ],
            [
                'code' => 'CHE',
                'description' => 'College Of Human Ecology',
                'switch' => 0,
            ],
            [
                'code' => 'CEM',
                'description' => 'College Of Veterinary Medicine',
                'switch' => 0,
            ],
            [
                'code' => 'GS',
                'description' => 'Graduate School',
                'switch' => 1,
            ],
        ];

        echo "Saving college data...\n";

        foreach ($this->_colleges as $college) {
            $model = new College();
            $model->code = $college['code'];
            $model->description = $college['description'];
            $model->switch = $college['switch'];

            if ($model->validate()) {
                echo "Inserting $model->code $model->description...\n";
                $model->insert(false);
            } else {
                echo "Something went wrong!\n";
                return Controller::EXIT_CODE_ERROR;
            }
        }

        echo "Done.\n\n";

        echo "Initializing degree data...\n";

        $this->_degrees = [
            [
                'code' => 'BACA',
                'description' => 'BA In Communication Arts',
            ],
            [
                'code' => 'BAPHLO',
                'description' => 'BA In Philosophy',
            ],
            [
                'code' => 'BASOC',
                'description' => 'BA In Sociology',
            ],
            [
                'code' => 'BSA',
                'description' => 'BS In Agriculture',
            ],
            [
                'code' => 'BSABM',
                'description' => 'BS In Agribusiness Management',
            ],
            [
                'code' => 'BSABT',
                'description' => 'BS Agricultural Biotechnology',
            ],
            [
                'code' => 'BSAC',
                'description' => 'BS In Agricultural Chemistry',
            ],
            [
                'code' => 'BSAE',
                'description' => 'BS In Agricultural Engineering',
            ],
            [
                'code' => 'BSAECO',
                'description' => 'BS In Agricultural Economics',
            ],
            [
                'code' => 'BSAM',
                'description' => 'BS In Applied Mathematics',
            ],
            [
                'code' => 'BSAP',
                'description' => 'BS In Applied Physics',
            ],
            [
                'code' => 'BSBIO',
                'description' => 'BS In Biology',
            ],
            [
                'code' => 'BSCE',
                'description' => 'BS In Civil Engineering',
            ],
            [
                'code' => 'BSCHE',
                'description' => 'BS In Chemical Engineering',
            ],
            [
                'code' => 'BSCHEM',
                'description' => 'BS In Chemistry',
            ],
            [
                'code' => 'BSCS',
                'description' => 'BS In Computer Science',
            ],
            [
                'code' => 'BSDC',
                'description' => 'BS In Development Communication',
            ],
            [
                'code' => 'BSECO',
                'description' => 'BS In Economics',
            ],
            [
                'code' => 'BSEE',
                'description' => 'BS In Electrical Engineering',
            ],
            [
                'code' => 'BSF',
                'description' => 'BS In Forestry',
            ],
            [
                'code' => 'BSFT',
                'description' => 'BS In Food Technology',
            ],
            [
                'code' => 'BSHE',
                'description' => 'BS In Human Ecology',
            ],
            [
                'code' => 'BSIE',
                'description' => 'BS In Industrial Engineering',
            ],
            [
                'code' => 'BSMATH',
                'description' => 'BS In Mathematics',
            ],
            [
                'code' => 'BSMST',
                'description' => 'BS In Mathematics And Science Teaching',
            ],
            [
                'code' => 'BSN',
                'description' => 'BS In Nutrition',
            ],
            [
                'code' => 'BSSTAT',
                'description' => 'BS In Statistics',
            ],
            [
                'code' => 'CERTFOR',
                'description' => 'Certificate In Forestry',
            ],
            [
                'code' => 'DVM',
                'description' => 'Doctor Of Veterinary Medicine',
            ],
            [
                'code' => 'MA',
                'description' => 'Master Of Arts',
            ],
            [
                'code' => 'MACA',
                'description' => 'Master Of Communication Arts',
            ],
            [
                'code' => 'MCA',
                'description' => 'Master Of Agriculture',
            ],
            [
                'code' => 'MDMG',
                'description' => 'Master Of Development Management And Governance',
            ],
            [
                'code' => 'MF',
                'description' => 'Master Of Forestry',
            ],
            [
                'code' => 'MIT',
                'description' => 'Master Of Information Technology',
            ],
            [
                'code' => 'MM',
                'description' => 'Master Of Management',
            ],
            [
                'code' => 'MPAF',
                'description' => 'Master In Public Affairs',
            ],
            [
                'code' => 'MS',
                'description' => 'Master Of Science',
            ],
            [
                'code' => 'MSAS',
                'description' => 'Master Of Animal Science',
            ],
            [
                'code' => 'ND',
                'description' => 'Non-Degree',
            ],
            [
                'code' => 'PHD',
                'description' => 'Doctor Of Philosophy',
            ],
            [
                'code' => 'PREVM',
                'description' => 'Pre-Veterinary Medicine',
            ],
            [
                'code' => 'SPEC',
                'description' => 'SPEC',
            ],
            [
                'code' => 'X-REG',
                'description' => 'Cross Registrant',
            ],
        ];

        echo "Saving degree data...\n";

        foreach ($this->_degrees as $degree) {
            $model = new Degree();
            $model->code = $degree['code'];
            $model->description = $degree['description'];

            if ($model->validate()) {
                echo "Inserting $model->code $model->description...\n";
                $model->insert(false);
            } else {
                echo "Something went wrong!\n";
                return Controller::EXIT_CODE_ERROR;
            }
        }

        echo "Done.\n\n";

        echo "Initializing formula data...\n";

        $this->_formulas = [
            [
                'unit' => 'per page',
                'formula' => '({service_amount}*{quantity})',
            ],
            [
                'unit' => 'per hour',
                'formula' => '(({hours}*{service_amount})+(({service_amount}/60)*{minutes}))',
            ],
            [
                'unit' => 'per hour',
                'formula' => '(0)',
            ],
        ];

        echo "Saving formula data...\n";

        foreach ($this->_formulas as $formula) {
            $model = new Formula();
            $model->unit = $formula['unit'];
            $model->formula = $formula['formula'];

            if ($model->validate()) {
                echo "Inserting $model->unit $model->formula...\n";
                $model->insert(false);
            } else {
                echo "Something went wrong!\n";
                return Controller::EXIT_CODE_ERROR;
            }
        }

        echo "Done.\n\n";

        echo "Initializing service data...\n";

        $this->_services = [
            [
                'name' => 'Research/Internet',
                'amount' => 20,
                'formula' => 2,
                'status' => Service::STATUS_FEATURED,
                'switch' => 1,
            ],
            [
                'name' => 'Typing',
                'amount' => 15,
                'formula' => 2,
                'status' => Service::STATUS_FEATURED,
                'switch' => 1,
            ],
            [
                'name' => 'CD-ROM/Database',
                'amount' => 0,
                'formula' => 3,
                'status' => Service::STATUS_FEATURED,
                'switch' => 0,
            ],
            [
                'name' => 'Microfilm',
                'amount' => 0,
                'formula' => 3,
                'status' => Service::STATUS_FEATURED,
                'switch' => 0,
            ],
            [
                'name' => 'Others (Service Only)',
                'amount' => 0,
                'formula' => 3,
                'status' => Service::STATUS_FEATURED,
                'switch' => 0,
            ],
            [
                'name' => 'eJournals',
                'amount' => 0,
                'formula' => 3,
                'status' => Service::STATUS_FEATURED,
                'switch' => 0,
            ],
            [
                'name' => 'eBooks',
                'amount' => 0,
                'formula' => 3,
                'status' => Service::STATUS_FEATURED,
                'switch' => 0,
            ],
            [
                'name' => 'Colored Printing (Half-Page)',
                'amount' => 5,
                'formula' => 1,
                'status' => Service::STATUS_REGULAR,
                'switch' => 1,
            ],
            [
                'name' => 'Colored Printing (Full-Page)',
                'amount' => 10,
                'formula' => 1,
                'status' => Service::STATUS_REGULAR,
                'switch' => 1,
            ],
            [
                'name' => 'Black Laser Printing',
                'amount' => 5,
                'formula' => 1,
                'status' => Service::STATUS_REGULAR,
                'switch' => 1,
            ],
            [
                'name' => 'Dot Matrix Printing',
                'amount' => 1,
                'formula' => 1,
                'status' => Service::STATUS_REGULAR,
                'switch' => 1,
            ],
            [
                'name' => 'Scanning',
                'amount' => 5,
                'formula' => 1,
                'status' => Service::STATUS_REGULAR,
                'switch' => 1,
            ],
            [
                'name' => 'CD Burning',
                'amount' => 10,
                'formula' => 1,
                'status' => Service::STATUS_REGULAR,
                'switch' => 1,
            ],
            [
                'name' => 'Colored/black Printing (Samsung)',
                'amount' => 5,
                'formula' => 1,
                'status' => Service::STATUS_REGULAR,
                'switch' => 1,
            ],
            [
                'name' => 'Black Printing (Epson)',
                'amount' => 1,
                'formula' => 1,
                'status' => Service::STATUS_REGULAR,
                'switch' => 1,
            ],
        ];

        echo "Saving service data...\n";

        foreach ($this->_services as $service) {
            $model = new Service();
            $model->name = $service['name'];
            $model->amount = $service['amount'];
            $model->status = $service['status'];
            $model->formula = $service['formula'];
            $model->switch = $service['switch'];

            if ($model->validate()) {
                echo "Inserting $model->name $model->amount...\n";
                $model->insert(false);
            } else {
                echo "Something went wrong!\n";
                return Controller::EXIT_CODE_ERROR;
            }
        }

        echo "Done.\n\n";

        echo "Initializing library data...\n";

        $this->_libraries = [
            [
                'location' => 'University Library',
            ],
            [
                'location' => 'SESAM',
            ],
            [
                'location' => 'CEAT',
            ],
            [
                'location' => 'CVM',
            ],
            [
                'location' => 'CFNR',
            ],
            [
                'location' => 'CDC',
            ],
            [
                'location' => 'CEM',
            ],
            [
                'location' => 'CHE',
            ],
            [
                'location' => 'ILC',
            ],
        ];

        echo "Saving library data...\n";

        foreach ($this->_libraries as $library) {
            $model = new Library();
            $model->location = $library['location'];

            if ($model->validate()) {
                echo "Inserting $model->location...\n";
                $model->insert(false);
            } else {
                echo "Something went wrong!\n";
                return Controller::EXIT_CODE_ERROR;
            }
        }

        echo "Done.\n";
    }

    public function actionInitRbac()
    {
        echo "Initializing RBAC...\n\n";
        $auth = Yii::$app->authManager;

        $configSetting = $auth->createPermission('configSetting');
        $configSetting->description = 'Configure administrator settings';
        $auth->add($configSetting);

        /*$accessBacklog = $auth->createPermission('accessBacklog');
        $accessBacklog->description = 'Access backlog';
        $auth->add($accessBacklog);*/

        $accessRent = $auth->createPermission('accessRent');
        $accessRent->description = 'Access rent time in/out functions';
        $auth->add($accessRent);

        $accessSale = $auth->createPermission('accessSale');
        $accessSale->description = 'Access sale';
        $auth->add($accessSale);

        $createStudent = $auth->createPermission('createStudent');
        $createStudent->description = 'Create a student account';
        $auth->add($createStudent);

        $setAcademicCalendar = $auth->createPermission('setAcademicCalendar');
        $setAcademicCalendar->description = 'Set the academic calendar';
        $auth->add($setAcademicCalendar);

        $viewDashboard = $auth->createPermission('viewDashboard');
        $viewDashboard->description = 'View dashboard';
        $auth->add($viewDashboard);

        


        /*$student = $auth->createRole('Student');
        $auth->add($student);
        echo "Student role added...\n";*/

        $studentAssistant = $auth->createRole('Student Assistant');
        $auth->add($studentAssistant);
        /*$auth->addChild($studentAssistant, $accessBacklog);*/
        $auth->addChild($studentAssistant, $accessRent);
        $auth->addChild($studentAssistant, $accessSale);
        $auth->addChild($studentAssistant, $viewDashboard);
        $auth->addChild($studentAssistant, $createStudent);
        echo "Student Assistant role added...\n";

        $staff = $auth->createRole('Staff');
        $auth->add($staff);
        $auth->addChild($staff, $setAcademicCalendar);
        $auth->addChild($staff, $studentAssistant);
        echo "Staff role added...\n";

        $administrator = $auth->createRole('Administrator');
        $auth->add($administrator);
        $auth->addChild($administrator, $configSetting);
        $auth->addChild($administrator, $staff);
        echo "Administrator role added...\n\n";

        echo "Done.\n";
    }

    public function actionInitAdmin($library, $role, $name, $username, $password)
    {
        echo "Initializing User data...\n\n";
        $modelLibrary = Library::find()->where(['location' => $library])->limit(1)->one();

        if (!$modelLibrary) {
            echo "Error \"$library\" library not found.\n";
            return Controller::EXIT_CODE_ERROR;
        }

        $model = new User();
        $model->setAttribute('library', $modelLibrary->id);
        $model->setAttribute('name', $name);
        $model->setAttribute('username', $username);
        $model->setAttribute('password_hash', $password);
        $model->setAttribute('timezone', 'Asia/Manila');

        $model->setAttribute('status', User::STATUS_ACTIVE);
        $model->generatePassword($password);
        $model->generateAuthKey();
        $model->generateAccessToken();
        $model->generateIpAddress();

        echo "Saving \"$username\" user...\n";
        if ($model->save()) {
            echo "Saving \"$role\" role...\n";
            $model->refresh();

            $auth = Yii::$app->authManager;
            $role = $auth->getRole($role);
            $auth->assign($role, $model->getId());
            echo "Done.\n";
        }
    }

    public function actionInitPc()
    {
        echo "Initializing PC data...\n\n";
        $prefix = 'PC';
        $min = 1;
        $max = 50;
        $library = 'University Library';
        $args = [];
        $args = func_get_args();

        if (isset($args[0])) {
            $prefix = $args[0];
        }
        if (isset($args[1])) {
            $min = $args[1];
        }
        if (isset($args[2])) {
            $max = $args[2];
        }
        if (isset($args[3])) {
            $library = $args[3];
        }

        $modelLibrary = Library::find()->where(['location' => $library])->limit(1)->one();

        if (!$modelLibrary) {
            echo "Error \"$args[3]\" library not found.\n";
            return Controller::EXIT_CODE_ERROR;
        }

        for ($min; $min <= $max; $min++) {
            $pc = $prefix . $min;
            echo "Saving \"$pc\" PC...\n";
            $model = new Pc();
            $model->setAttribute('library', $modelLibrary->id);
            $model->setAttribute('code', $pc);
            $model->setAttribute('status', Pc::STATUS_VACANT);
            $model->save();
        }
        echo "Done.\n";
    }

}
