<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\money\MaskMoney;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin([
        'id' => 'app-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['validate'],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->widget(MaskMoney::classname()) ?>

    <?= $form->field($model, 'formula')->dropDownList(['' => '- Select -'] + $formulas) ?>

    <?= $form->field($model, 'status')->dropDownList(['' => '- Select -'] + $model->getStatusList()) ?>

    <?= $form->field($model, 'switch')->widget(SwitchInput::classname())->label('Charge to Computer Usage Hours?') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
