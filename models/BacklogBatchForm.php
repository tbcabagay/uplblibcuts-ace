<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\StudentNumberValidator;

/**
 * TimeInRentForm is the model behind the login form.
 *
 */
class BacklogBatchForm extends Model
{
    public $date_out;
    public $time_out;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['date_out', 'time_out'], 'required'],
            ['date_out', 'date', 'format' => 'php:Y-m-d'],
            ['date_out', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '>='],
            ['time_out', 'date', 'format' => 'php:H:i:s'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date_out' => Yii::t('app', 'Date Out'),
            'time_out' => Yii::t('app', 'Time Out'),

        ];
    }

    public function backlogBatch()
    {
        $result = ['result' => true];
        $count = 0;
        $selections = Yii::$app->request->post('selection');

        if (!empty($selections)) {
            if (Yii::$app->user->identity->timezone !== 'UTC') {
                $timestampOut = Yii::$app->formatter->asTimestamp($this->date_out . ' ' . $this->time_out . ' ' . Yii::$app->user->identity->timezone);
            }

            foreach ($selections as $selection) {
                $rent = $this->findRent($selection);
                $student = $rent->getStudent();
                $service = $rent->getService();

                $rent->setAttribute('time_out', $timestampOut);
                $rent->setAttribute('status', Rent::STATUS_TIME_OUT);
                $rent->setAttribute('time_diff', ($rent->time_out - $rent->time_in));

                if ($service->charge) {
                    $student->updateRentTime($rent->time_diff);
                }
                if (!is_null($rent->pc)) {
                    $rent->getPc()->setVacant();
                }
                if ($service->charge) {
                    $rent->updateAmount();
                }
                if ($rent->update() !== false) {
                    $count = $count + 1;
                }
            }
        }
        $result['count'] = $count;
        return $result;
    }

    protected function findRent($id)
    {
        return Rent::findOne($id);
    }
}
