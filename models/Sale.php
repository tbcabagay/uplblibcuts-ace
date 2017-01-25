<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%sale}}".
 *
 * @property integer $id
 * @property integer $academic_year
 * @property integer $library
 * @property string $student
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
            [['academic_year', 'library', 'student', 'service', 'quantity', 'amount', 'total', 'created_at', 'created_by'], 'required'],
            [['academic_year', 'library', 'service', 'quantity', 'created_at', 'created_by'], 'integer'],
            [['amount', 'total'], 'number'],
            [['student'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'academic_year' => Yii::t('app', 'Academic Year'),
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
}
