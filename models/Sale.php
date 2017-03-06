<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%sale}}".
 *
 * @property integer $id
 * @property integer $academic_calendar
 * @property integer $library
 * @property integer $student
 * @property integer $service
 * @property integer $quantity
 * @property string $amount
 * @property string $total
 * @property integer $created_at
 * @property integer $created_by
 */
class Sale extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sale}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['academic_calendar', 'library', 'student', 'service', 'quantity', 'amount', 'total'], 'required'],
            [['academic_calendar', 'library', 'student', 'service', 'quantity', 'created_at', 'created_by'], 'integer'],
            [['amount', 'total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'academic_calendar' => Yii::t('app', 'Academic Calendar'),
            'library' => Yii::t('app', 'Library'),
            'student' => Yii::t('app', 'Student'),
            'service' => Yii::t('app', 'Service'),
            'quantity' => Yii::t('app', 'Quantity'),
            'amount' => Yii::t('app', 'Amount'),
            'total' => Yii::t('app', 'Total'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
        ];
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
}
