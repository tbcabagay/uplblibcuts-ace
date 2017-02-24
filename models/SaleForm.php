<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\StudentNumberValidator;

/**
 * SaleForm is the model behind the login form.
 *
 */
class SaleForm extends Model
{
    public $number;
    public $service;
    public $quantity;

    private $_student = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['number', 'service', 'quantity'], 'required'],
            ['number', 'string', 'max' => 10],
            ['number', StudentNumberValidator::classname()],
            ['number', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{5}$/'],
            ['number', 'validateStudent'],
            [['service', 'quantity'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => Yii::t('app', 'Student Number'),
            'service' => Yii::t('app', 'Service'),
            'quantity' => Yii::t('app', 'Quantity'),
        ];
    }

    public function validateStudent($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $student = $this->getStudent();

            if (!$student) {
                $this->addError($attribute, Yii::t('app', 'Student number does not exist.'));
            } else {
                $rent = $this->getRent();
                if ($rent) {
                    $this->addError($attribute, Yii::t('app', 'Student is already logged in.'));
                }
            }
        }
    }

    public function getStudent()
    {
        if ($this->_student === false) {
            $this->_student = Student::findByNumber($this->number);
        }
        return $this->_student;
    }

    public function signin()
    {
        $student = $this->getStudent();
        $service = Service::findOne($this->service);
        $academicCalendar = AcademicCalendar::findActive();

        $rent = new Rent();
        $rent->setAttribute('student', $student->id);
        $rent->setAttribute('college', $student->college);
        $rent->setAttribute('degree', $student->degree);
        $rent->setAttribute('pc', $this->pc);
        $rent->setAttribute('service', $this->service);
        $rent->setAttribute('topic', !$this->topic ? $service->name : $this->topic);
        $rent->setAttribute('amount', 0);
        $rent->setAttribute('rent_time', $student->rent_time);
        $rent->setAttribute('time_diff', 0);
        $rent->setAttribute('academic_calendar', $academicCalendar->id);
        $rent->setAttribute('library', Yii::$app->user->identity->library);

        return $rent->save() && ($rent->getPc()->setOccupied() !== false);
    }
}
