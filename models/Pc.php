<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%pc}}".
 *
 * @property integer $id
 * @property integer $library
 * @property string $code
 * @property string $ip_address
 * @property integer $status
 */
class Pc extends \yii\db\ActiveRecord
{
    const STATUS_VACANT = 5;
    const STATUS_OCCUPIED = 10;
    const STATUS_DELETE = 20;

    private static $_list = [];
    private static $_status = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pc}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['library', 'status'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['ip_address'], 'string', 'max' => 15],
            ['code', 'filter', 'filter' => 'strtoupper'],
            ['status', 'default', 'value' => self::STATUS_VACANT],
            ['library', 'default', 'value' => Yii::$app->user->identity->library],
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
            'code' => Yii::t('app', 'Code'),
            'ip_address' => Yii::t('app', 'Ip Address'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public static function getStatusList()
    {
        if (empty(self::$_status)) {
            self::$_status = [
                self::STATUS_VACANT => 'VACANT',
                self::STATUS_OCCUPIED => 'OCCUPIED',
            ];
        }
        return self::$_status;
    }

    public static function setOccupied($id)
    {
        $model = self::findOne($id);
        if (!is_null($model)) {
            $model->setAttribute('status', self::STATUS_OCCUPIED);
            return $model->update();
        }
        return false;
    }

    public static function setVacant($id)
    {
        $model = self::findOne($id);
        if (!is_null($model)) {
            $model->setAttribute('status', self::STATUS_VACANT);
            return $model->update();
        }
        return false;
    }

    public static function getPcList($library = null, $status = null)
    {
        $statuses = self::getStatusList();
        $model = self::find();

        if (!is_null($status) && isset($statuses[$status])) {
            $model->where(['status' => $status]);
        } else {
            $model->where(['status' => self::STATUS_VACANT]);
        }

        if (!is_null($library)) {
            $model->andWhere(['library' => $library]);
        } else {
            $model->andWhere(['library' => Yii::$app->user->identity->library]);
        }

        self::$_list = ArrayHelper::map($model->all(), 'id', 'code');
        return self::$_list;
    }
}
