<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $library_id
 * @property string $name
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $registration_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Library $library
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['library_id', 'name', 'username', 'password_hash', 'auth_key', 'status', 'created_at', 'updated_at'], 'required'],
            [['library_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 80],
            [['username', 'password_hash'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['registration_ip'], 'string', 'max' => 45],
            [['library_id'], 'exist', 'skipOnError' => true, 'targetClass' => Library::className(), 'targetAttribute' => ['library_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'library_id' => Yii::t('app', 'Library ID'),
            'name' => Yii::t('app', 'Name'),
            'username' => Yii::t('app', 'Username'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'registration_ip' => Yii::t('app', 'Registration Ip'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibrary()
    {
        return $this->hasOne(Library::className(), ['id' => 'library_id']);
    }
}
