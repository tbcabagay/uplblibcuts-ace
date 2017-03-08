<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $password;
    public $confirm_password;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'confirm_password'], 'required'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'New Password'),
            'confirm_password' => Yii::t('app', 'Confirm New Password'),
        ];
    }

    public function change($id)
    {
        $model = User::findOne($id);
        if (!is_null($model)) {
            $model->generatePassword($this->password);
            return ($model->update() !== false);
        }
    }
}
