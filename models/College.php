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
    const STATUS_REGULAR = 5;
    const STATUS_CHARGE = 10;
    const STATUS_DELETE = 15;

    const SWITCH_ON = 1;
    const SWITCH_OFF = 0;

    public $switch;

    private static $_list = [];

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
            ['status', 'default', 'value' => self::STATUS_REGULAR],
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
        $status = (intval($this->switch)) ? self::STATUS_CHARGE : self::STATUS_REGULAR;
        $this->setAttribute('status', $status);

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->switch = ($this->status === self::STATUS_REGULAR) ? self::SWITCH_OFF : self::SWITCH_ON;

        return parent::afterFind();
    }

    public function isCharged()
    {
        return $this->status === self::STATUS_CHARGE;
    }

    public static function getCollegeList()
    {
        self::$_list = ArrayHelper::map(self::find()->asArray()->all(), 'id', 'description');
        return self::$_list;
    }

    /*public static function getStatusList()
    {
        if (empty(self::$_statuses)) {
            self::$_statuses = [
                self::STATUS_REGULAR => 'REGULAR',
                self::STATUS_CHARGE => 'CHARGE',
            ];
        }
        return self::$_statuses;
    }*/
}
