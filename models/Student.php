<?php

namespace app\models;

use Yii;
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
    const STATUS_ACTIVE = 5;
    const STATUS_DELETE = 10;

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
            ['number', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{5}$/', 'message' => Yii::t('app', 'Student number is invalid.')],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
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
            if ($this->isChargeable()) {
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
        return College::find()->where([
            'id' => $this->college,
            'status' => College::STATUS_CHARGE,
        ])->exists();
    }

    public function setRentTime($timeDiff)
    {
        /*if ($this->rent_time > 0) {*/
            $rentTime = $this->rent_time - $timeDiff;
            $this->setAttribute('rent_time', $rentTime);
            return $this->update();
        /*}
        return true;*/
    }

    public function formatRentTime()
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
    }

    public static function findByNumber($number)
    {
        return self::findOne(['number' => $number]);
    }

    public function getFullname()
    {
        return "{$this->lastname}, {$this->firstname} {$this->middlename}";
    }
}
