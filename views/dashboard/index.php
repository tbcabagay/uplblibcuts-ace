<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Dashboards');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">
    
    <div class="page-header">
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 widget-container-col" id="widget-container-col-5">
            <div class="widget-box" id="widget-box-5">
                <div class="widget-header">
                    <h5 class="widget-title smaller">Time In</h5>

                    <div class="widget-toolbar">
                        <span class="label label-success">
                            16%
                            <i class="ace-icon fa fa-arrow-up"></i>
                        </span>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main padding-6">
                        <?php $form = ActiveForm::begin([
                            'id' => 'time-in-rent-form',
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'validationUrl' => ['validate-time-in'],
                            'options' => [
                                'autocomplete' => 'off',
                            ],
                        ]); ?>

                        <?= $form->field($timeInRentModel, 'number')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($timeInRentModel, 'service')->radioButtonGroup($services, [
                            'class' => 'btn-group-sm',
                            'itemOptions' => ['labelOptions' => ['class' => 'btn btn-warning']]
                        ]) ?>

                        <?= $form->field($timeInRentModel, 'pc')->dropDownList($pcs) ?>

                        <div class="form-group">
                            <?= Html::submitButton('<i class="ace-icon fa fa-sign-in"></i>', ['class' => 'btn btn-primary width-100 ', 'name' => 'time-in-rent-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 widget-container-col" id="widget-container-col-5">
            <div class="widget-box" id="widget-box-5">
                <div class="widget-header">
                    <h5 class="widget-title smaller">With Label</h5>

                    <div class="widget-toolbar">
                        <span class="label label-success">
                            16%
                            <i class="ace-icon fa fa-arrow-up"></i>
                        </span>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main padding-6">
                        <div class="alert alert-info"> Hello World! </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
