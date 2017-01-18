<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\models\AcademicYear */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="academic-year-form">

    <?php $form = ActiveForm::begin([
        'id' => 'app-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['validate', ($model->isNewRecord) ? null : 'id' => $model->id],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'semester')->radioButtonGroup($semesters, [
        'class' => 'btn-group-sm',
        'itemOptions' => ['labelOptions' => ['class' => 'btn btn-warning']]
    ]) ?>

    <?= $form->field($model, 'date_start')->widget(DatePicker::className(), [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]) ?>

    <?= $form->field($model, 'date_end')->widget(DatePicker::className(), [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
