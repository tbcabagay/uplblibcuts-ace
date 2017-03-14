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
 * @property integer $formula
 */
class Service extends \yii\db\ActiveRecord
{
    const STATUS_FEATURED = 5;
    const STATUS_REGULAR = 10;
    const STATUS_DELETE = 15;

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
            [['name', 'amount', 'status', 'formula'], 'required'],
            [['amount'], 'number'],
            [['status', 'formula'], 'integer'],
            [['name'], 'string', 'max' => 100],
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
            'formula' => Yii::t('app', 'Formula'),
        ];
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
