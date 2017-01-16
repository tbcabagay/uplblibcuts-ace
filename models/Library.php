<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%library}}".
 *
 * @property integer $id
 * @property string $location
 * @property integer $status
 */
class Library extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 5;
    const STATUS_DELETE = 10;

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
            [['status'], 'integer'],
            [['location'], 'string', 'max' => 50],
            ['location', 'filter', 'filter' => 'ucwords'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
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
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public static function getLibraryList()
    {
        self::$_list = ArrayHelper::map(self::find()->asArray()->all(), 'id', 'location');
        return self::$_list;
    }

    public static function findById($id)
    {
        $model = self::findOne($id);
        if (!is_null($model)) {
            return $model->location;
        }
        return null;
    }
}
