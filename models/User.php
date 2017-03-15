<?php

namespace app\models;

use Yii;
use yii\web\Application as WebApplication;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property integer $library
 * @property string $name
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $access_token
 * @property string $registration_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $timezone
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_NEW = 5;
    const STATUS_ACTIVE = 10;

    private static $_roles = [];

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
            // [['library', 'name', 'username', 'password_hash', 'auth_key', 'status', 'created_at', 'updated_at'], 'required'],
            [['library', 'name', 'username', 'password_hash', 'auth_key', 'access_token', 'status', 'timezone'], 'required'],
            [['library', 'status', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 80],
            [['username', 'password_hash'], 'string', 'max' => 60],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
            [['registration_ip'], 'string', 'max' => 15],
            [['timezone'], 'string', 'max' => 40],
            ['name', 'filter', 'filter' => 'strtolower'],
            ['name', 'filter', 'filter' => 'ucwords'],
            ['status', 'default', 'value' => self::STATUS_NEW],
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
            'name' => Yii::t('app', 'Name'),
            'username' => Yii::t('app', 'Username'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'access_token' => Yii::t('app', 'Access Token'),
            'registration_ip' => Yii::t('app', 'Registration Ip'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'timezone' => Yii::t('app', 'Timezone'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    public function generateAuthKey()
    {
        $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
    }

    public function generateAccessToken()
    {
        $this->setAttribute('access_token', \Yii::$app->security->generateRandomString());
    }

    public function generatePassword($password)
    {
        $this->setAttribute('password_hash', Yii::$app->getSecurity()->generatePasswordHash($password));
    }

    public function generateIpAddress()
    {
        if (\Yii::$app instanceof WebApplication) {
            $this->setAttribute('registration_ip', \Yii::$app->request->userIP);
        }
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
        ];
    }

    public function activate()
    {
        $this->setAttribute('status', self::STATUS_ACTIVE);
        return ($this->update() !== false);
    }

    public function isNew()
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getLibrary()
    {
        return Library::findOne($this->library);
    }

    public static function getRoleList()
    {
        self::$_roles = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
        return self::$_roles;
    }
}
