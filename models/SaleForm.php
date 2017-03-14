<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\StudentNumberValidator;

/**
 * SaleForm is the model behind the login form.
 *
 */
class SaleForm extends Model
{
    public $number;
    public $service;
    public $quantity;

    private $_student = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['number', 'service', 'quantity'], 'required'],
            ['number', 'string', 'max' => 10],
            ['number', StudentNumberValidator::classname()],
            ['number', 'match', 'pattern' => '/^[0-9]{4}-[0-9]{5}$/'],
            ['number', 'validateStudent'],
            [['service', 'quantity'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => Yii::t('app', 'Student Number'),
            'service' => Yii::t('app', 'Service'),
            'quantity' => Yii::t('app', 'Quantity'),
        ];
    }

    public function validateStudent($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $student = $this->getStudent();

            if (!$student) {
                $this->addError($attribute, Yii::t('app', 'Student number does not exist.'));
            }
        }
    }

    public function getStudent()
    {
        if ($this->_student === false) {
            $this->_student = Student::findByNumber($this->number);
        }
        return $this->_student;
    }

    public function bill()
    {
        $student = $this->getStudent();

        $sale = new Sale();
        $sale->setAttribute('library', Yii::$app->user->identity->library);
        $sale->setAttribute('student', $student->id);
        $sale->setAttribute('service', $this->service);
        $sale->setAttribute('quantity', $this->quantity);
        $sale->setAcademicCalendar();
        $sale->setAmount();
        $sale->computeTotal();

        return $sale->save();
    }
}
