<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\SwitchInput

/* @var $this yii\web\View */
/* @var $model app\models\College */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="college-form">

    <?php $form = ActiveForm::begin([
        'id' => 'app-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['validate'],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'switch')->widget(SwitchInput::classname())->label('Charge Students?') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
