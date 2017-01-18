<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%college}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $description
 * @property integer $status
 */
class College extends \yii\db\ActiveRecord
{
    const STATUS_REGULAR = 5;
    const STATUS_CHARGE = 10;
    const STATUS_DELETE = 15;

    public $switch;

    private static $_list = [];
    private static $_statuses = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%college}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'description', 'switch'], 'required'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 50],
            ['code', 'filter', 'filter' => 'strtoupper'],
            ['description', 'filter', 'filter' => 'strtolower'],
            ['description', 'filter', 'filter' => 'ucwords'],
            ['status', 'default', 'value' => self::STATUS_REGULAR],
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

    public function beforeSave($insert)
    {
        if (intval($this->switch) === 1) {
            $this->setAttribute('status', self::STATUS_CHARGE);
        } else {
            $this->setAttribute('status', self::STATUS_REGULAR);
        }

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if ($this->status === self::STATUS_REGULAR) {
            $this->switch = 0;
        } else if ($this->status === self::STATUS_CHARGE) {
            $this->switch = 1;
        }

        return parent::afterFind();
    }

    public static function getCollegeList()
    {
        self::$_list = ArrayHelper::map(self::find()->asArray()->all(), 'id', 'description');
        return self::$_list;
    }

    public static function getStatusList()
    {
        if (empty(self::$_statuses)) {
            self::$_statuses = [
                self::STATUS_REGULAR => 'REGULAR',
                self::STATUS_CHARGE => 'CHARGE',
            ];
        }
        return self::$_statuses;
    }

    public static function findByStatus($status)
    {
        $statuses = self::getStatusList();
        if (isset($statuses[$status])) {
            if ($status === self::STATUS_CHARGE) {
                return '<i class="fa fa-check text-success"></i>';
            } else if ($status === self::STATUS_REGULAR) {
                return '<i class="fa fa-times text-danger"></i>';
            }
        }
        return null;
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
