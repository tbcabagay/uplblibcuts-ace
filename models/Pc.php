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

    public function getLibrary()
    {
        return Library::find()->where(['id' => $this->library])->limit(1)->one();
    }

    public function getStatusValue()
    {
        $statuses = self::getStatusList();
        if (isset($statuses[$this->status])) {
            return $statuses[$this->status];
        }
    }

    public function isVacant()
    {
        return $this->status === self::STATUS_VACANT;
    }

    public function isOccupied()
    {
        return $this->status === self::STATUS_OCCUPIED;
    }

    public function getStatusList()
    {
        $status = [
            self::STATUS_VACANT => 'VACANT',
            self::STATUS_OCCUPIED => 'OCCUPIED',
        ];
        return $status;
    }

    public function countByStatus($status, $library = null)
    {
        $model = self::find()->where(['status' => $status]);

        if (is_null($library)) {
            $model->andWhere(['library' => Yii::$app->user->identity->library]);
        } else {
            $model->andWhere(['library' => $library]);
        }
        return intval($model->count());
    }

    public static function vacateAll()
    {
        return self::updateAll(
            ['status' => self::STATUS_VACANT],
            ['library' => Yii::$app->user->identity->library]
        );
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

        $list = ArrayHelper::map($model->all(), 'id', 'code');
        return $list;
    }

    public function setVacant()
    {
        $this->setAttribute('status', self::STATUS_VACANT);
        return $this->update();
    }

    public function setOccupied()
    {
        $this->setAttribute('status', self::STATUS_OCCUPIED);
        return $this->update();
    }

    /*public static function setOccupied($id)
    {
        $model = self::findOne(['id' => $id, 'status' => self::STATUS_VACANT]);
        if (!is_null($model)) {
            $model->setAttribute('status', self::STATUS_OCCUPIED);
            return $model->update();
        }
        return false;
    }

    public static function setVacant($id)
    {
        $model = self::findOne(['id' => $id, 'status' => self::STATUS_OCCUPIED]);
        if (!is_null($model)) {
            $model->setAttribute('status', self::STATUS_VACANT);
            return $model->update();
        }
        return false;
    }

    */
}
