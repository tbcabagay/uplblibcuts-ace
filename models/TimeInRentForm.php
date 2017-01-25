<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\StudentNumberValidator;

/**
 * TimeInRentForm is the model behind the login form.
 *
 */
class TimeInRentForm extends Model
{
    public $number;
    public $pc;
    public $service;
    public $topic;

    private $_student = false;
    private $_rent = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['number', 'pc', 'service'], 'required'],
            ['number', 'string', 'max' => 10],
            ['number', StudentNumberValidator::classname()],
            ['number', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{5}$/', 'message' => Yii::t('app', 'Student number is invalid.')],
            ['number', 'validateStudent'],
            [['pc', 'service'], 'integer'],
            ['topic', 'string', 'max' => 30],
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
            'service' => Yii::t('app', 'Service'),
            'topic' => Yii::t('app', 'Topic'),
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

    public function signin()
    {
        $student = $this->getStudent();
        $service = Service::findOne($this->service);
        $academicYear = AcademicYear::findActiveAcademicYear();

        $transaction = Yii::$app->db->beginTransaction();

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
        $rent->setAttribute('academic_year', $academicYear->id);
        $rent->setAttribute('library', Yii::$app->user->identity->library);

        try {
            if ($rent->save() && Pc::setOccupied($this->pc)) {
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
