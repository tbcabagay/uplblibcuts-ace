<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\StudentNumberValidator;

/**
 * TimeInRentForm is the model behind the login form.
 *
 */
class TimeOutRentForm extends Model
{
    public $number;

    private $_student = false;
    private $_rent = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['number', 'required'],
            ['number', 'string', 'max' => 10],
            ['number', StudentNumberValidator::classname()],
            ['number', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{5}$/'],
            ['number', 'validateStudent'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => Yii::t('app', 'Student Number'),
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
                if (!$rent) {
                    $this->addError($attribute, Yii::t('app', 'Student is not logged in.'));
                }
            }
        }
    }

    public function getRent()
    {
        $student = $this->getStudent();
        if ($this->_rent === false) {
            $this->_rent = Rent::findOne([
                'student' => $student->id,
                'status' => Rent::STATUS_TIME_IN,
            ]);
        }
        return $this->_rent;
    }

    public function getStudent()
    {
        if ($this->_student === false) {
            $this->_student = Student::findByNumber($this->number);
        }
        return $this->_student;
    }

    public function signout()
    {
        $rent = $this->getRent();
        $student = $this->getStudent();

        $rent->touch('time_out');

        $rent->setAttribute('status', Rent::STATUS_TIME_OUT);
        $rent->setAttribute('time_diff', ($rent->time_out - $rent->time_in));

        $student->updateRentTime($rent->time_diff);
        if (!is_null($rent->pc)) {
            $rent->getPc()->setVacant();
        }
        $rent->update();
        $rent->updateAmount();
        return true;
    }
}
