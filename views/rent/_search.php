<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rent-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'academic_calendar') ?>

    <?= $form->field($model, 'library') ?>

    <?= $form->field($model, 'student') ?>

    <?= $form->field($model, 'college') ?>

    <?php // echo $form->field($model, 'degree') ?>

    <?php // echo $form->field($model, 'pc') ?>

    <?php // echo $form->field($model, 'service') ?>

    <?php // echo $form->field($model, 'topic') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'time_in') ?>

    <?php // echo $form->field($model, 'time_out') ?>

    <?php // echo $form->field($model, 'rent_time') ?>

    <?php // echo $form->field($model, 'time_diff') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
