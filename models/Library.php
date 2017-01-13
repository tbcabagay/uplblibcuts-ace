<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%library}}".
 *
 * @property integer $id
 * @property string $location
 *
 * @property User[] $users
 */
class Library extends \yii\db\ActiveRecord
{
    private static $_list = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%library}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location'], 'required'],
            [['location'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'location' => Yii::t('app', 'Location'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['library_id' => 'id']);
    }

    public static function getLibraryList()
    {
        self::$_list = ArrayHelper::map(self::find()->asArray()->all(), 'id', 'location');
        return self::$_list;
    }
}
