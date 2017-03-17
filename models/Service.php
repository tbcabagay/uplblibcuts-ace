<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%service}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $amount
 * @property integer $status
 * @property integer $charge
 * @property integer $formula
 */
class Service extends \yii\db\ActiveRecord
{
    public $switch;

    const STATUS_FEATURED = 5;
    const STATUS_REGULAR = 10;
    const STATUS_DELETE = 15;
    const SWITCH_ON = 1;
    const SWITCH_OFF = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%service}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'amount', 'status', 'formula', 'switch'], 'required'],
            [['amount'], 'number'],
            [['status', 'charge', 'formula'], 'integer'],
            [['name'], 'string', 'max' => 100],
            ['switch', 'boolean'],
            ['charge', 'default', 'value' => 1],
            ['name', 'filter', 'filter' => 'ucwords'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'charge' => Yii::t('app', 'Charge'),
            'formula' => Yii::t('app', 'Formula'),
            'charge' => Yii::t('app', 'Charge'),
        ];
    }

    public function beforeSave($insert)
    {
        $charge = (intval($this->switch)) ? self::SWITCH_ON : self::SWITCH_OFF;
        $this->setAttribute('charge', $charge);

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->switch = ($this->charge) ? self::SWITCH_ON : self::SWITCH_OFF;

        return parent::afterFind();
    }

    public function getFormula()
    {
        return Formula::find()->where(['id' => $this->formula])->limit(1)->one();
    }

    public function isFeatured()
    {
        return $this->status === self::STATUS_FEATURED;
    }

    public function isRegular()
    {
        return $this->status === self::STATUS_REGULAR;
    }

    public static function getStatusList()
    {
        $status = [
            self::STATUS_FEATURED => 'FEATURED',
            self::STATUS_REGULAR => 'REGULAR',
        ];

        return $status;
    }

    public static function getServiceList($status = null)
    {
        $statuses = self::getStatusList();
        $model = self::find();
        if (!is_null($status) && isset($statuses[$status])) {
            $model->where(['status' => $status]);
        }
        $list = ArrayHelper::map($model->all(), 'id', 'name');
        return $list;
    }

}
