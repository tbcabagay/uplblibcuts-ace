<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%session}}".
 *
 * @property string $id
 * @property integer $user
 * @property string $ip_address
 * @property string $expire
 * @property resource $data
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%session}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ip_address'], 'required'],
            [['user'], 'integer'],
            [['data'], 'string'],
            [['id', 'expire'], 'string', 'max' => 40],
            [['ip_address'], 'string', 'max' => 15],
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
            'ip_address' => Yii::t('app', 'Ip Address'),
            'expire' => Yii::t('app', 'Expire'),
            'data' => Yii::t('app', 'Data'),
        ];
    }
}
