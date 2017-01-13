<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $library;
    public $name;
    public $username;
    public $password;
    public $confirm_password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['library', 'name', 'username', 'password', 'confirm_password'], 'required'],
            ['library', 'integer'],
            ['name', 'string', 'max' => 80],
            [['username', 'password', 'confirm_password'], 'string', 'max' => 60],
            ['confirm_password', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'library' => Yii::t('app', 'Library'),
            'name' => Yii::t('app', 'Complete Name'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'confirm_password' => Yii::t('app', 'Confirm Password'),
        ];
    }
}
