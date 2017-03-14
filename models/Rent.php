<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

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

    const STATUS_TIME_IN = 5;
    const STATUS_TIME_OUT = 10;

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
            [['student', 'college', 'degree', 'service', 'topic', 'amount', 'rent_time', 'time_diff'], 'required'],
            [['academic_calendar', 'library', 'student', 'college', 'degree', 'pc', 'service', 'status', 'time_in', 'time_out', 'rent_time', 'time_diff', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['topic'], 'string', 'max' => 30],
            ['status', 'default', 'value' => self::STATUS_TIME_IN],
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
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['time_in', 'time_out'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => false, // 'time_out',
                ],
            ],
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by',
                ],
            ],
        ];
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
