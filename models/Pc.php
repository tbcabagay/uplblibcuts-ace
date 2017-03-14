<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Application as WebApplication;

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

    const SCENARIO_VALIDATE_CODE = 'validate_code';

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
            ['code', 'validateUnique', 'on' => self::SCENARIO_VALIDATE_CODE],
            ['status', 'default', 'value' => self::STATUS_VACANT],
            //['library', 'default', 'value' => Yii::$app->user->identity->library],
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

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_VALIDATE_CODE] = ['code'];
        return $scenarios;
    }

    public function beforeSave($insert)
    {
        if ($this instanceof WebApplication) {
            $this->setAttribute('library', Yii::$app->user->identity->library);
        }
        return parent::beforeSave($insert);
    }

    public function validateUnique($attribute, $params)
    {
        $model = self::find()->where(['code' => $this->$attribute, 'library' => Yii::$app->user->identity->library])->limit(1)->one();
        if (!is_null($model)) {
            $this->addError($attribute, Yii::t('app', 'Code "{code}" has already been taken.', ['code' => $this->$attribute]));
        }
    }

    public function getLibrary()
    {
        return Library::findOne($this->library);
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

    public static function getStatusList()
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

    public static function getPcList($status = null, $library = null)
    {
        $statuses = self::getStatusList();
        $model = self::find();

        if (!is_null($status) && isset($statuses[$status])) {
            $model->where(['status' => $status]);
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
}
