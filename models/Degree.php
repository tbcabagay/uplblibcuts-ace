<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%degree}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $description
 * @property integer $status
 */
class Degree extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 5;
    const STATUS_DELETE = 10;

    private static $_list = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%degree}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'description'], 'required'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 15],
            [['description'], 'string', 'max' => 50],
            ['code', 'filter', 'filter' => 'strtoupper'],
            ['description', 'filter', 'filter' => 'strtolower'],
            ['description', 'filter', 'filter' => 'ucwords'],
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
            'code' => Yii::t('app', 'Code'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public static function getDegreeList()
    {
        self::$_list = ArrayHelper::map(self::find()->asArray()->all(), 'id', 'description');
        return self::$_list;
    }

    public static function findById($id)
    {
        $model = self::findOne($id);
        if (!is_null($model)) {
            return "{$model->description}";
        }
        return null;
    }
}
