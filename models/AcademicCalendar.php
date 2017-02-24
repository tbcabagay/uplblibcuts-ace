<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%academic_year}}".
 *
 * @property integer $id
 * @property string $semester
 * @property string $date_start
 * @property string $date_end
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 */
class AcademicCalendar extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 5;
    const STATUS_INACTIVE = 10;
    const SEMESTER_FIRST = 1;
    const SEMESTER_SECOND = 2;
    const SCENARIO_CREATE = 'create';

    private static $_list = [];
    private static $_statuses = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%academic_calendar}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['semester', 'date_start', 'date_end'], 'required'],
            [['date_start', 'date_end'], 'safe'],
            [['status', 'created_at', 'created_by'], 'integer'],
            [['semester'], 'string', 'max' => 1],
            ['semester', 'in', 'range' => [1, 2, 3]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['semester', 'validateStatus', 'on' => self::SCENARIO_CREATE],
            ['date_start', 'date', 'format' => 'php:Y-m-d'],
            ['date_end', 'date', 'format' => 'php:Y-m-d'],
            ['date_end', 'compare', 'compareAttribute' => 'date_start', 'operator' => '>'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'semester' => Yii::t('app', 'Semester'),
            'date_start' => Yii::t('app', 'Date Start'),
            'date_end' => Yii::t('app', 'Date End'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['semester', 'date_start', 'date_end', 'status'];
        return $scenarios;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
        ];
    }

    public function validateStatus($attribute, $params)
    {
        $model = self::find()->where(['status' => self::STATUS_ACTIVE])->limit(1)->one();
        if (!is_null($model)) {
            $this->addError($attribute, Yii::t('app', 'Please change the status of the active academic year first.'));
        }
    }

    public function getSemesterList()
    {
        $semester = [
            self::SEMESTER_FIRST => 'First',
            self::SEMESTER_SECOND => 'Second',
        ];
        return $semester;
    }

    public function getStatusList()
    {
        $status = [
            self::STATUS_ACTIVE => 'ACTIVE',
            self::STATUS_INACTIVE => 'INACTIVE',
        ];
        return $status;
    }

    public function getTextSemester()
    {
        $semesters = self::getSemesterList();
        return $semesters[$this->semester];
    }

    public function getTextStatus()
    {
        $statuses = self::getStatusList();
        return $statuses[$this->status];
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public static function findActive()
    {
        return self::find()->where(['status' => self::STATUS_ACTIVE])->limit(1)->one();
    }
}
