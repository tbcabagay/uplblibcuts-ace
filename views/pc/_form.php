<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pc-form">

    <?php $form = ActiveForm::begin([
        'id' => 'app-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['validate', ($model->isNewRecord) ? null : 'id' => $model->id],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
