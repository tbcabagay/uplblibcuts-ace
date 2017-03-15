<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use app\components\StudentNumberValidator;

/**
 * This is the model class for table "{{%rent}}".
 *
 * @property integer $id
 * @property integer $academic_calendar
 * @property integer $library
 * @property integer $student
 * @property integer $college
 * @property integer $degree
 * @property integer $pc
 * @property integer $service
 * @property string $topic
 * @property string $amount
 * @property integer $status
 * @property integer $time_in
 * @property integer $time_out
 * @property integer $rent_time
 * @property integer $time_diff
 * @property integer $created_by
 * @property integer $updated_by
 */
class Rent extends \yii\db\ActiveRecord
{
    public $number;
    public $name;
    public $in_date;
    public $in_time;

    const STATUS_TIME_IN = 5;
    const STATUS_TIME_OUT = 10;
    const SCENARIO_TIME_IN = 'time_in';
    const SCENARIO_TIME_OUT = 'time_out';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rent}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['academic_calendar', 'library', 'student', 'college', 'degree', 'service', 'topic', 'amount', 'status', 'time_in', 'time_out', 'rent_time', 'time_diff', 'created_by', 'updated_by'], 'required'],
            [['student', 'college', 'degree', 'service', 'topic', 'amount', 'rent_time', 'time_diff'], 'required'],
            [['student', 'college', 'degree', 'service', 'topic', 'amount', 'rent_time', 'time_diff', 'number', 'in_date', 'in_time'], 'required', 'on' => self::SCENARIO_TIME_IN],
            [['academic_calendar', 'library', 'student', 'college', 'degree', 'pc', 'service', 'status', 'time_in', 'time_out', 'rent_time', 'time_diff', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['topic'], 'string', 'max' => 30],
            ['status', 'default', 'value' => self::STATUS_TIME_IN],
            ['number', 'string', 'max' => 10],
            ['number', StudentNumberValidator::classname()],
            ['number', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{5}$/'],
            ['number', 'validateStudent'],
            ['in_date', 'date', 'format' => 'php:Y-m-d'],
            ['in_time', 'date', 'format' => 'php:H:i:s'],
            ['status', 'in', 'range' => [self::STATUS_TIME_IN, self::STATUS_TIME_OUT]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'academic_calendar' => Yii::t('app', 'Academic Year'),
            'library' => Yii::t('app', 'Library'),
            'student' => Yii::t('app', 'Student'),
            'college' => Yii::t('app', 'College'),
            'degree' => Yii::t('app', 'Degree'),
            'pc' => Yii::t('app', 'Pc'),
            'service' => Yii::t('app', 'Service'),
            'topic' => Yii::t('app', 'Topic'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'time_in' => Yii::t('app', 'Time In'),
            'time_out' => Yii::t('app', 'Time Out'),
            'rent_time' => Yii::t('app', 'Rent Time'),
            'time_diff' => Yii::t('app', 'Time Expended'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'number' => Yii::t('app', 'Number'),
            'name' => Yii::t('app', 'Name'),
            'in_date' => Yii::t('app', 'Date In'),
            'in_time' => Yii::t('app', 'Time In'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_TIME_IN] = ['number', 'service', 'pc', 'topic', 'status', 'in_date', 'in_time'];
        $scenarios[self::SCENARIO_TIME_OUT] = ['number', 'out_date', 'out_time'];
        return $scenarios;
    }

    public function behaviors()
    {
        return [
            /*[
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['time_in', 'time_out'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false, // 'time_out',
                ],
            ],*/
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                ],
            ],
        ];
    }

    public function validateStudent($attribute, $params)
    {
        $timeInRentForm = new TimeInRentForm();
        $timeInRentForm->number = $this->number;
        $student = $timeInRentForm->getStudent();

        if (!$student) {
            $this->addError($attribute, Yii::t('app', 'Student number does not exist.'));
        } else {
            $rent = $timeInRentForm->getRent();
            if ($rent) {
                $this->addError($attribute, Yii::t('app', 'Student is already logged in.'));
            }
        }
    }

    public function signin()
    {
        $result = true;
        $timeInRentForm = new TimeInRentForm();
        $timeInRentForm->number = $this->number;
        $student = $timeInRentForm->getStudent();
        $academicCalendar = AcademicCalendar::findActive();
        $service = Service::findOne($this->service);
        $formula = $service->getFormula()->formula;

        if (Yii::$app->user->identity->timezone !== 'UTC') {
            $timestamp = Yii::$app->formatter->asTimestamp($this->in_date . ' ' . $this->in_time . ' ' . Yii::$app->user->identity->timezone);
        }

        $this->setAttribute('student', $student->id);
        $this->setAttribute('college', $student->college);
        $this->setAttribute('degree', $student->degree);
        $this->setAttribute('time_in', $timestamp);
        $this->setAttribute('time_out', $timestamp);
        $this->setAttribute('topic', !$this->topic ? $service->name : $this->topic);
        $this->setAttribute('amount', 0);
        $this->setAttribute('rent_time', $student->rent_time);
        $this->setAttribute('time_diff', 0);
        $this->setAttribute('academic_calendar', $academicCalendar->id);
        $this->setAttribute('library', Yii::$app->user->identity->library);

        if ($formula !== '(0)') {
            $this->setAttribute('pc', $this->pc);
            $result = $result && ($this->getPc()->setOccupied() !== false);
        } else {
            $this->setAttribute('pc', null);
        }
        $result = $result && $this->save();
        return $result;
    }

    public function updateAmount()
    {
        $student = $this->getStudent();
        $service = $this->getService();
        $timeDiff = null;

        if ($student->isChargeableByCollege()) {
            $timeDiff = $this->formatTimeDiffAsArray();
        } else if ($student->isChargeable()) {
            $timeDiff = $this->formatTimeDiffAsArray();

            if ($student->rent_time < 0) {
                $timeDiff = $student->formatRentTimeAsArray();
                $student->setAttribute('rent_time', 0);
                $student->update();
            }
        }

        /*
         *  (({hours}*{service_amount})+(({service_amount}/60)*{minutes}))
         */
        if (is_array($timeDiff) && !is_null($service)) {
            $formula = $service->getFormula()->formula;
            $amount = 0;
            if ($formula !== '(0)') {
                $formula = str_replace('{service_amount}', $service->amount, $formula);
                $formula = str_replace('{hours}', $timeDiff['hours'], $formula);
                $formula = str_replace('{minutes}', $timeDiff['minutes'], $formula);
                $amount = eval("return {$formula};");
            }
            $this->setAttribute('amount', round($amount));
            return $this->update();
        }
    }

    public function formatTimeDiffAsArray()
    {
        $timeDiff = $this->getTimeDiff();
        $pieces = explode(':', $timeDiff);
        if (is_array($pieces) && (count($pieces) === 3)) {
            $timeDiff = [
                'hours' => $pieces[0],
                'minutes' => $pieces[1],
                'seconds'  => $pieces[2],
            ];
        }        
        return $timeDiff;
    }

    public function getTimeDiff()
    {
        $timeDiff = null;
        if ($this->time_diff > 0) {
            $time = $this->time_diff;
            $hours = str_pad(floor($time / 3600), 2, '0', STR_PAD_LEFT);
            $minutes = str_pad(floor($time / 60 % 60), 2, '0', STR_PAD_LEFT);
            $seconds = str_pad(floor($time % 60), 2, '0', STR_PAD_LEFT);

            $timeDiff = "{$hours}:{$minutes}:{$seconds}";
        }
        return $timeDiff;
    }

    public function getStatusList()
    {
        return [
            self::STATUS_TIME_IN => 'TIME_IN',
            self::STATUS_TIME_OUT => 'TIME_OUT',
        ];
    }

    public function getStatusValue()
    {
        $statuses = $this->getStatusList();
        return $statuses[$this->status];
    }

    public function isTimeIn()
    {
        return $this->status === self::STATUS_TIME_IN;
    }

    public function isTimeOut()
    {
        return $this->status === self::STATUS_TIME_OUT;
    }

    public function rentRollBack()
    {
        $student = $this->getStudent();
        if (!$student->isChargeableByCollege() && ($this->rent_time > 0)) {
            $student->setAttribute('status', Student::STATUS_REGULAR);
            $student->setAttribute('rent_time', $this->rent_time);
            $student->update();
            $this->getPc()->setVacant();
        }
        return $this->delete();
    }

    public function getLibrary()
    {
        return Library::findOne($this->library);
    }

    public function getStudent()
    {
        return Student::findOne($this->student);
    }

    public function getPc()
    {
        return Pc::findOne($this->pc);
    }

    public function getService()
    {
        return Service::findOne($this->service);
    }

    public function getCollege()
    {
        return College::findOne($this->college);
    }

    public function getDegree()
    {
        return Degree::findOne($this->degree);
    }
}
