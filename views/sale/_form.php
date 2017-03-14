<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\Sale */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sale-form">

    <?php $form = ActiveForm::begin([
        'id' => 'app-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['validate', 'id' => $model->id],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'service')->radioList($services) ?>

    <?= $form->field($model, 'quantity')->widget(TouchSpin::classname(), [
        'pluginOptions' => [
            'initval' => 1,
            'min' => 1,
            'max' => 100,
            'step' => 1,
            'buttonup_class' => 'btn btn-sm btn-primary',
            'buttondown_class' => 'btn btn-sm btn-danger',
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
