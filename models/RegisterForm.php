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
    public $role;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['library', 'name', 'username', 'password', 'confirm_password', 'role'], 'required'],
            ['library', 'integer'],
            [['name', 'role'], 'string', 'max' => 80],
            [['username', 'password', 'confirm_password'], 'string', 'max' => 60],
            ['username', 'unique', 'targetClass' => User::className()],
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
            'role' => Yii::t('app', 'Role'),
        ];
    }

    public function signup()
    {
        $model = new User();
        $model->library_id = $this->library;
        $model->name = $this->name;
        $model->username = $this->username;
        $model->password_hash = $this->password;

        $model->setAttribute('status', (Yii::$app->params['autoConfirmAccount'])
            ? User::STATUS_ACTIVE : User::STATUS_NEW);
        $model->generatePassword($this->password);
        $model->generateAuthKey();
        $model->generateIpAddress();

        if ($model->save()) {
            $model->refresh();

            $auth = Yii::$app->authManager;
            $role = $auth->getRole($this->role);
            $auth->assign($role, $model->getId());
            return true;
        }
        return false;
    }
}
