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

    private $_academic_calendar = false;
    private $_student = false;
    private $_service = false;

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

    public function getService()
    {
        if ($this->_service === false) {
            $this->_service = Service::findOne($this->service);
        }
        return $this->_service;
    }

    public function getAcademicCalendar()
    {
        if ($this->_academic_calendar === false) {
            $this->_academic_calendar = AcademicCalendar::findActive();
        }
        return $this->_academic_calendar;
    }

    public function bill()
    {
        $academicCalendar = $this->getAcademicCalendar();
        $student = $this->getStudent();
        $service = $this->getService();
        $formula = $service->getFormula()->formula;

        $sale = new Sale();
        $sale->setAttribute('academic_calendar', $academicCalendar->id);
        $sale->setAttribute('library', Yii::$app->user->identity->library);
        $sale->setAttribute('student', $student->id);
        $sale->setAttribute('service', $service->id);
        $sale->setAttribute('quantity', $this->quantity);
        $sale->setAttribute('amount', $service->amount);

        if ($formula === '(0)') {
            $sale->setAttribute('total', 0);
        } else {
            $formula = str_replace('{service_amount}', $service->amount, $formula);
            $formula = str_replace('{quantity}', $this->quantity, $formula);
            $total = eval("return {$formula};");
            $sale->setAttribute('total', round($total));
        }
        return $sale->save();
    }
}
