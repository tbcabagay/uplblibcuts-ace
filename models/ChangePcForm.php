<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\StudentNumberValidator;

/**
 * TimeInRentForm is the model behind the login form.
 *
 */
class ChangePcForm extends Model
{
    public $number;
    public $pc;

    private $_student = false;
    private $_rent = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['number', 'pc'], 'required'],
            ['number', 'string', 'max' => 10],
            ['number', StudentNumberValidator::classname()],
            ['number', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{5}$/'],
            ['number', 'validateStudent'],
            ['pc', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => Yii::t('app', 'Student Number'),
            'pc' => Yii::t('app', 'PC'),
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

    public function change()
    {
        $result = true;
        $rent = $this->getRent();
        $formula = $rent->getService()->getFormula()->formula;
        $result = $result && ($rent->getPc()->setVacant() !== false);

        if ($formula !== '(0)') {
            $rent->setAttribute('pc', $this->pc);
            $result = $result && ($rent->update() !== false);
            $result = $result && ($rent->getPc()->setOccupied() !== false);
        }
        return $result;
    }
}
