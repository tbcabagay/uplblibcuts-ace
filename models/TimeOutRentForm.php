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
            ['number', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{5}$/', 'message' => Yii::t('app', 'Student number is invalid.')],
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
        $student = $this->getStudent();
        $rent = $this->getRent();
        $rent->setAttribute('status', Rent::STATUS_TIME_OUT);

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($rent->update() && Pc::setVacant($rent->pc)) {
                $rent->computeTimeDiff();
                $student->setRentTime($rent->time_diff);
                if ($student->isChargeable() || ($student->rent_time < 1)) {
                    $rent->computeRentFee();
                }

                $transaction->commit();
                return true;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            return false;
        }        
    }
}
