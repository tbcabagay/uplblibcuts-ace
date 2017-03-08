<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'id' => 'change-password-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['validate-change-password'],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

    <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder' => $model->getAttributeLabel('confirm_password')]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
