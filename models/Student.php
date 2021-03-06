<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use app\components\StudentNumberValidator;

/**
 * This is the model class for table "{{%student}}".
 *
 * @property integer $id
 * @property string $number
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $sex
 * @property integer $degree
 * @property integer $college
 * @property integer $status
 * @property integer $rent_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Student extends \yii\db\ActiveRecord
{
    public $name;

    const STATUS_REGULAR = 5;
    const STATUS_CHARGE = 10;    
    const STATUS_DELETE = 15;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'firstname', 'middlename', 'lastname', 'sex', 'degree', 'college'], 'required'],
            [['degree', 'college', 'status', 'rent_time', 'created_at', 'updated_at'], 'integer'],
            [['number', 'lastname'], 'string', 'max' => 10],
            [['firstname', 'middlename'], 'string', 'max' => 40],
            [['sex'], 'string', 'max' => 1],
            [['firstname', 'lastname', 'middlename'], 'trim'],
            [['firstname', 'lastname', 'middlename'], 'filter', 'filter' => 'strtolower'],
            [['firstname', 'lastname', 'middlename'], 'filter', 'filter' => 'ucwords'],
            [['firstname', 'lastname'], 'string', 'max' => 70],
            ['middlename', 'string', 'max' => 10],
            ['number', 'unique'],
            ['number', StudentNumberValidator::classname()],
            ['number', 'match', 'pattern' => '/^[\d]{4}-[\d]{5}$/'],
            ['status', 'default', 'value' => self::STATUS_REGULAR],
            ['rent_time', 'default', 'value' => Yii::$app->params['studentRentTime']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'number' => Yii::t('app', 'Number'),
            'firstname' => Yii::t('app', 'Firstname'),
            'middlename' => Yii::t('app', 'Middlename'),
            'lastname' => Yii::t('app', 'Lastname'),
            'sex' => Yii::t('app', 'Sex'),
            'degree' => Yii::t('app', 'Degree'),
            'college' => Yii::t('app', 'College'),
            'status' => Yii::t('app', 'Status'),
            'rent_time' => Yii::t('app', 'Rent Time'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if ($this->isChargeableByCollege()) {
                $this->setAttribute('status', self::STATUS_CHARGE);
                $this->setAttribute('rent_time', 0);
            }
            
        }

        return parent::beforeSave($insert);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }

    public function isChargeable()
    {
        return $this->status === self::STATUS_CHARGE;
    }

    public function isChargeableByCollege()
    {
        $college = $this->getCollege();

        return $college->status === College::STATUS_CHARGE;
    }

    public function updateRentTime($timeDiff)
    {
        if ($this->isChargeableByCollege()) {
            return;
        }

        $rentTime = $this->rent_time - $timeDiff;
        
        $this->setAttribute('rent_time', $rentTime);

        if ($rentTime < 1) {
            $this->setAttribute('status', self::STATUS_CHARGE);
        }

        return $this->update();
    }

    public function formatRentTimeAsArray()
    {
        $rentTime = $this->getRentTime();
        $pieces = explode(':', $rentTime);
        if (is_array($pieces)) {
            $rentTime = [
                'hours' => $pieces[0],
                'minutes' => $pieces[1],
            ];
        }        
        return $rentTime;
    }

    public function getRentTime()
    {
        $rentTime = '00:00:00';
        $time = abs($this->rent_time);
        if ($time > 0) {
            $hours = str_pad(floor($time / 3600), 2, '0', STR_PAD_LEFT);
            $minutes = str_pad(floor($time / 60 % 60), 2, '0', STR_PAD_LEFT);
            $seconds = str_pad(floor($time % 60), 2, '0', STR_PAD_LEFT);

            $rentTime = "{$hours}:{$minutes}:{$seconds}";
        }

        return $rentTime;
    }

    /*public function formatRentTime()
    {
        $rentTime = null;
        if ($this->rent_time) {
            $seconds = $this->rent_time;
            $hours = floor($seconds / 3600);
            $mins = str_pad(floor($seconds / 60 % 60), 2, '0', STR_PAD_LEFT);
            $secs = str_pad(floor($seconds % 60), 2, '0', STR_PAD_LEFT);

            $rentTime = "{$hours}:{$mins}:{$secs}";
        }
        return $rentTime;
    }*/

    public static function resetRentTime()
    {
        $college = College::find()->where(['status' => College::STATUS_REGULAR])->asArray()->all();
        if (!empty($college)) {
            $collegeIds = ArrayHelper::getColumn($college, 'id');
            return self::updateAll(
                ['rent_time' => Yii::$app->params['studentRentTime'], 'status' => self::STATUS_REGULAR],
                ['in', 'college', $collegeIds]
            );
        }
        return null;
    }

    public static function findByNumber($number)
    {
        return self::findOne(['number' => $number]);
    }

    public function getCollege()
    {
        return College::findOne($this->college);
    }

    public function getDegree()
    {
        return Degree::findOne($this->degree);
    }

    public function getFullname()
    {
        return "{$this->lastname}, {$this->firstname} {$this->middlename}";
    }

    public function fields()
    {
        return [
            'id',
            'number',
            'name' => function($model) {
                return $model->firstname . ' ' . $model->lastname;
            },
            'sex',
            'college' => function($model) {
                return [
                    'code' => $model->getCollege()->code,
                    'description' => $model->getCollege()->description,
                ];
            },
            'degree' => function($model) {
                return [
                    'code' => $model->getDegree()->code,
                    'description' => $model->getDegree()->description,
                ];
            },
            'created_at',
        ];
    }
}
