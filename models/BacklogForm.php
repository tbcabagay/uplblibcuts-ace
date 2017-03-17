<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\StudentNumberValidator;

/**
 * TimeInRentForm is the model behind the login form.
 *
 */
class BacklogForm extends Model
{
    public $number;
    public $pc;
    public $service;
    public $topic;
    public $date_in;
    public $time_in;
    public $date_out;
    public $time_out;

    private $_student = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['number', 'pc', 'service', 'date_in', 'time_in', 'date_out', 'time_out'], 'required'],
            ['number', StudentNumberValidator::classname()],
            ['number', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{5}$/'],
            ['number', 'validateStudent'],
            [['date_in', 'date_out'], 'date', 'format' => 'php:Y-m-d'],
            [['time_in', 'time_out'], 'date', 'format' => 'php:H:i:s'],
            ['date_out', 'compare', 'compareAttribute' => 'date_in', 'operator' => '>='],
            ['time_out', 'compare', 'compareAttribute' => 'time_in', 'operator' => '>='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => Yii::t('app', 'Student Number'),
            'date_in' => Yii::t('app', 'Date In'),
            'time_in' => Yii::t('app', 'Time In'),
            'date_out' => Yii::t('app', 'Date Out'),
            'time_out' => Yii::t('app', 'Time Out'),

        ];
    }

    public function validateStudent($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $student = $this->getStudent();

            if (!$student) {
                $this->addError($attribute, Yii::t('app', 'Student number does not exist.'));
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

    public function backlog()
    {
        $result = true;
        $student = $this->getStudent();
        $academicCalendar = AcademicCalendar::findActive();
        $service = Service::findOne($this->service);
        $formula = $service->getFormula()->formula;

        if (Yii::$app->user->identity->timezone !== 'UTC') {
            $timestampIn = Yii::$app->formatter->asTimestamp($this->date_in . ' ' . $this->time_in . ' ' . Yii::$app->user->identity->timezone);
        }

        if (Yii::$app->user->identity->timezone !== 'UTC') {
            $timestampOut = Yii::$app->formatter->asTimestamp($this->date_out . ' ' . $this->time_out . ' ' . Yii::$app->user->identity->timezone);
        }

        $rent = new Rent();
        $rent->setAttribute('student', $student->id);
        $rent->setAttribute('college', $student->college);
        $rent->setAttribute('degree', $student->degree);
        $rent->setAttribute('time_in', $timestampIn);
        $rent->setAttribute('time_out', $timestampOut);
        $rent->setAttribute('service', $this->service);
        $rent->setAttribute('pc', null);
        $rent->setAttribute('topic', !$this->topic ? $service->name : $this->topic);
        $rent->setAttribute('academic_calendar', $academicCalendar->id);
        $rent->setAttribute('library', Yii::$app->user->identity->library);
        $rent->setAttribute('status', Rent::STATUS_TIME_OUT);
        $rent->setAttribute('amount', 0);
        $rent->setAttribute('time_diff', ($rent->time_out - $rent->time_in));
        $rent->setAttribute('rent_time', $student->rent_time);

        if ($service->charge) {
            $result = $result && $student->updateRentTime($rent->time_diff);
        }

        if ($formula !== '(0)') {
            $rent->setAttribute('pc', $this->pc);
        }

        $result = $result && $rent->save();
        if ($service->charge) {
            $result = $result && ($rent->updateAmount() !== false);
        }
        return $result;
    }
}
