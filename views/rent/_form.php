<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use app\models\Rent;

/* @var $this yii\web\View */
/* @var $model app\models\Rent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rent-form">

    <?php $form = ActiveForm::begin([
        'id' => 'app-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['validate', 'id' => $model->id],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?php if ($model->scenario === Rent::SCENARIO_TIME_IN): ?>

    <?= $form->field($model, 'service')->radioList($featuredServices) ?>

    <?= $form->field($model, 'in_date')->widget(DatePicker::className(), [
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]) ?>

    <?= $form->field($model, 'in_time')->widget(TimePicker::className(), [
        'pluginOptions' => [
            'showMeridian' => false,
            'showSeconds' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'pc')->dropDownList($pcs) ?>

    <?= $form->field($model, 'topic')->textInput(['maxlength' => true]) ?>

    <?php elseif ($model->scenario === Rent::SCENARIO_TIME_OUT): ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
