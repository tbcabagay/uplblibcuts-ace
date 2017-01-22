<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * TimeInRentForm is the model behind the login form.
 *
 */
class TimeInRentForm extends Model
{
    public $number;
    public $pc;
    public $service;

    private $_student = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['number', 'pc', 'service'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'number' => Yii::t('app', 'Student Number'),
            'pc' => Yii::t('app', 'PC'),
            'service' => Yii::t('app', 'Service'),
        ];
    }

    public function getStudent()
    {
        if ($this->_student === false) {
            $this->_student = Student::findByNumber($this->number);
        }

        return $this->_student;
    }
}
