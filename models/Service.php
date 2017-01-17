<?php

namespace app\models;

use Yii;

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
    const STATUS_MAIN = 5;
    const STATUS_SALE = 10;
    const STATUS_DELETE = 15;

    private static $_statuses = [];

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
        if (empty(self::$_statuses)) {
            self::$_statuses = [
                self::STATUS_MAIN => 'MAIN',
                self::STATUS_SALE => 'SALE',
            ];
        }
        return self::$_statuses;
    }

    public static function findByStatus($status)
    {
        $statuses = self::getStatusList();
        if (isset($statuses[$status])) {
            return $statuses[$status];
        }
        return null;
    }
}
