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
 */
class Service extends \yii\db\ActiveRecord
{
    const STATUS_FEATURED = 5;
    const STATUS_REGULAR = 10;
    const STATUS_DELETE = 15;

    private static $_status = [];
    private static $_list = [];

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
            [['name', 'amount', 'status'], 'required'],
            [['amount'], 'number'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 30],
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
        ];
    }

    public static function getStatusList()
    {
        if (empty(self::$_status)) {
            self::$_status = [
                self::STATUS_FEATURED => 'FEATURED',
                self::STATUS_REGULAR => 'REGULAR',
            ];
        }
        return self::$_status;
    }

    public static function getServiceList($status = null)
    {
        $statuses = self::getStatusList();
        $model = self::find();
        if (!is_null($status) && isset($statuses[$status])) {
            $model->where(['status' => $status]);
        }
        self::$_list = ArrayHelper::map($model->all(), 'id', 'name');
        return self::$_list;
    }

    public function getTextStatus()
    {
        if ($this->status === self::STATUS_FEATURED) {
            return 'FEATURED';
        } else if ($this->status === self::STATUS_REGULAR) {
            return 'REGULAR';
        }
    }
}
