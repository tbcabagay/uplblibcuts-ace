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
 * @property integer $academic_year
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
            //[['academic_year', 'library', 'student', 'college', 'degree', 'pc', 'service', 'topic', 'amount', 'status', 'time_in', 'time_out', 'rent_time', 'time_diff', 'created_by', 'updated_by'], 'required'],
            [['student', 'college', 'degree', 'pc', 'service', 'topic', 'amount', 'rent_time', 'time_diff'], 'required'],
            [['academic_year', 'library', 'student', 'college', 'degree', 'pc', 'service', 'status', 'time_in', 'time_out', 'rent_time', 'time_diff', 'created_by', 'updated_by'], 'integer'],
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
            'academic_year' => Yii::t('app', 'Academic Year'),
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
            'time_diff' => Yii::t('app', 'Time Diff'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['time_in', 'time_out'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'time_out',
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

    public function computeTimeDiff()
    {
        $timeDiff = $this->time_out - $this->time_in;
        $this->setAttribute('time_diff', $timeDiff);
        $this->update();
    }

    public function computeRentFee()
    {
        $service = Service::findOne($this->service);
        $formatTime = $this->formatTimeDiff();
        if (is_array($formatTime) && !is_null($service)) {
            $hourFee = $service->amount * $formatTime['hours'];
            $secondFee = (60 / $service->amount)* $formatTime['mins'];
            $this->setAttribute('amount', ($hourFee + $secondFee));
            $this->update();
        }
    }

    public function formatTimeDiff()
    {
        $rentTime = 0;
        if ($this->time_diff > 0) {
            $seconds = $this->time_diff;
            $hours = floor($seconds / 3600);
            $mins = str_pad(floor($seconds / 60 % 60), 2, '0', STR_PAD_LEFT);

            $rentTime = [
                'hours' => $hours,
                'mins' => $mins,
            ];
        }
        return $rentTime;
    }

    public function getStudent()
    {
        return Student::findOne($this->student);
    }
}
