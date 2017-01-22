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
    const STATUS_ACTIVE = 5;
    const STATUS_DELETE = 10;

    private static $_list = [];

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
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
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

    public static function getPcList($library = null, $status = null)
    {
        $library = ['library' => is_null($library) ?
            Yii::$app->user->identity->library : $library];
        $status = ['status' => is_null($status) ?
            self::STATUS_ACTIVE : $status];
        $where = ArrayHelper::merge($library, $status);
        self::$_list = ArrayHelper::map(self::find()->where($where)->all(), 'id', 'code');
        return self::$_list;
    }
}
