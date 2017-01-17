<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%student}}".
 *
 * @property integer $id
 * @property string $number
 * @property string $name
 * @property string $sex
 * @property integer $degree
 * @property integer $college
 * @property integer $status
 * @property integer $rent_time
 * @property integer $created_at
 * @property integer $updated_at
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%student}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'name', 'sex', 'degree', 'college', 'status', 'rent_time', 'created_at', 'updated_at'], 'required'],
            [['degree', 'college', 'status', 'rent_time', 'created_at', 'updated_at'], 'integer'],
            [['number'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 150],
            [['sex'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'number' => Yii::t('app', 'Number'),
            'name' => Yii::t('app', 'Name'),
            'sex' => Yii::t('app', 'Sex'),
            'degree' => Yii::t('app', 'Degree'),
            'college' => Yii::t('app', 'College'),
            'status' => Yii::t('app', 'Status'),
            'rent_time' => Yii::t('app', 'Rent Time'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
