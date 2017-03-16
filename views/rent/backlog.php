<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Rent */

$this->title = Yii::t('app', 'Time In');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-create">

    <h3 class="header smaller lighter orange">
        <?= Html::encode($this->title) ?>
    </h3>

    <div class="rent-form">

        <?php $form = ActiveForm::begin([
            'id' => 'app-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'validationUrl' => ['validate-backlog'],
            'options' => [
                'autocomplete' => 'off',
            ],
        ]); ?>

        <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'service')->radioList($featuredServices) ?>

        <?= $form->field($model, 'date_in')->widget(DatePicker::className(), [
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ]) ?>

        <?= $form->field($model, 'time_in')->widget(TimePicker::className(), [
            'pluginOptions' => [
                'minuteStep' => 1,
                'secondStep' => 1,
                'showMeridian' => false,
                'showSeconds' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'date_out')->widget(DatePicker::className(), [
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ]) ?>

        <?= $form->field($model, 'time_out')->widget(TimePicker::className(), [
            'pluginOptions' => [
                'minuteStep' => 1,
                'secondStep' => 1,
                'showMeridian' => false,
                'showSeconds' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'pc')->dropDownList($pcs) ?>

        <?= $form->field($model, 'topic')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Backlog'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
