<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%formula}}".
 *
 * @property integer $id
 * @property string $unit
 * @property string $formula
 * @property integer $status
 */
class Formula extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 5;
    const STATUS_DELETE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%formula}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unit', 'formula'], 'required'],
            [['status'], 'integer'],
            [['unit'], 'string', 'max' => 10],
            [['formula'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'unit' => Yii::t('app', 'Unit'),
            'formula' => Yii::t('app', 'Formula'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public static function getFormulaList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'unit');
    }
}
