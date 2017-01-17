<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%monitor_login}}".
 *
 * @property integer $id
 * @property integer $user
 * @property integer $time_in
 * @property integer $time_out
 * @property string $last_ip
 */
class MonitorLogin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%monitor_login}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'time_in', 'time_out', 'last_ip'], 'required'],
            [['user', 'time_in', 'time_out'], 'integer'],
            [['last_ip'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user' => Yii::t('app', 'User'),
            'time_in' => Yii::t('app', 'Time In'),
            'time_out' => Yii::t('app', 'Time Out'),
            'last_ip' => Yii::t('app', 'Last Ip'),
        ];
    }
}
