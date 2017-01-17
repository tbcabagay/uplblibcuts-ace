<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%rent}}".
 *
 * @property integer $id
 * @property string $student
 * @property integer $pc
 * @property integer $service
 * @property string $topic
 * @property string $amount
 * @property integer $status
 * @property integer $time_in
 * @property integer $time_out
 * @property integer $rent_time
 * @property integer $time_diff
 * @property integer $created_by
 * @property integer $updated_by
 */
class Rent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rent}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student', 'pc', 'service', 'topic', 'amount', 'status', 'time_in', 'time_out', 'rent_time', 'time_diff', 'created_by', 'updated_by'], 'required'],
            [['pc', 'service', 'status', 'time_in', 'time_out', 'rent_time', 'time_diff', 'created_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['student'], 'string', 'max' => 10],
            [['topic'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student' => Yii::t('app', 'Student'),
            'pc' => Yii::t('app', 'Pc'),
            'service' => Yii::t('app', 'Service'),
            'topic' => Yii::t('app', 'Topic'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'time_in' => Yii::t('app', 'Time In'),
            'time_out' => Yii::t('app', 'Time Out'),
            'rent_time' => Yii::t('app', 'Rent Time'),
            'time_diff' => Yii::t('app', 'Time Diff'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
