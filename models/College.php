<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%college}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $description
 * @property integer $status
 */
class College extends \yii\db\ActiveRecord
{
    const STATUS_FREE = 5;
    const STATUS_CHARGE = 10;
    const STATUS_DELETE = 15;
    const SWITCH_ON = 1;
    const SWITCH_OFF = 0;

    public $switch;

    private static $_list = [];
    private static $_statuses = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%college}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'description', 'switch'], 'required'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 50],
            ['code', 'filter', 'filter' => 'strtoupper'],
            ['description', 'filter', 'filter' => 'strtolower'],
            ['description', 'filter', 'filter' => 'ucwords'],
            ['status', 'default', 'value' => self::STATUS_FREE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function beforeSave($insert)
    {
        $status = (intval($this->switch)) ? self::STATUS_CHARGE : self::STATUS_FREE;
        $this->setAttribute('status', $status);

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->switch = ($this->status === self::STATUS_FREE) ? self::SWITCH_OFF : self::SWITCH_ON;

        return parent::afterFind();
    }

    public static function getCollegeList()
    {
        self::$_list = ArrayHelper::map(self::find()->asArray()->all(), 'id', 'description');
        return self::$_list;
    }

    public static function getStatusList()
    {
        if (empty(self::$_statuses)) {
            self::$_statuses = [
                self::STATUS_FREE => 'FREE',
                self::STATUS_CHARGE => 'CHARGE',
            ];
        }
        return self::$_statuses;
    }

    public function iconifyStatus()
    {
        if ($this->status === self::STATUS_CHARGE) {
            return '<i class="fa fa-check text-success"></i>';
        } else if ($this->status === self::STATUS_FREE) {
            return '<i class="fa fa-times text-danger"></i>';
        }
    }
}
