<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%sale}}".
 *
 * @property integer $id
 * @property integer $academic_calendar
 * @property integer $library
 * @property integer $student
 * @property integer $service
 * @property integer $quantity
 * @property string $amount
 * @property string $total
 * @property integer $created_at
 * @property integer $created_by
 */
class Sale extends \yii\db\ActiveRecord
{
    public $name;
    public $number;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sale}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'service', 'quantity'], 'required'],
            [['academic_calendar', 'library', 'student', 'service', 'quantity', 'created_at', 'created_by'], 'integer'],
            [['amount', 'total'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'academic_calendar' => Yii::t('app', 'Academic Calendar'),
            'library' => Yii::t('app', 'Library'),
            'student' => Yii::t('app', 'Student'),
            'service' => Yii::t('app', 'Service'),
            'quantity' => Yii::t('app', 'Quantity'),
            'amount' => Yii::t('app', 'Amount'),
            'total' => Yii::t('app', 'Total'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'number' => Yii::t('app', 'Number'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
            ],
        ];
    }

    public function setAmount()
    {
        $service = $this->getService();
        $this->setAttribute('amount', $service->amount);
    }

    public function setAcademicCalendar()
    {
        $academicCalendar = $this->getAcademicCalendar();
        $this->setAttribute('academic_calendar', $academicCalendar->id);
    }

    public function computeTotal()
    {
        $service = $this->getService();
        $formula = $service->getFormula()->formula;
        $total = 0;

        if ($formula !== '(0)') {
            $formula = str_replace('{service_amount}', $this->amount, $formula);
            $formula = str_replace('{quantity}', $this->quantity, $formula);
            $total = eval("return {$formula};");
        }
        $this->setAttribute('total', round($total));
    }

    public function getAcademicCalendar()
    {
        return AcademicCalendar::findActive();
    }

    public function getStudent()
    {
        return Student::findOne($this->student);
    }

    public function getService()
    {
        return Service::findOne($this->service);
    }

    public function getLibrary()
    {
        return Library::findOne($this->library);
    }

    public function getCreatedBy()
    {
        return User::findOne($this->created_by);
    }
}
