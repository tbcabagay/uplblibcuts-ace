<?php

namespace app\components;

use yii\validators\Validator;

class StudentNumberValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $number = $model->$attribute;
        $explode = explode('-', $number);
        $year = intval($explode[0]);
        $isValidYear = ($year >= 1970) && ($year <= 2030);
        if (!$isValidYear) {
            $this->addError($model, $attribute, 'Student number is invalid.');
        }
    }
}