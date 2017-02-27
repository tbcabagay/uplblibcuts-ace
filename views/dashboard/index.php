<?php

use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use kartik\widgets\TouchSpin;

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
        <div class="col-xs-12 col-sm-4">
            <div class="widget-box">
                <div class="widget-header widget-header-flat widget-header-small">
                    <h5 class="widget-title"><i class="ace-icon fa fa-sign-in"></i> <?= Yii::t('app', 'Time In') ?></h5>

                    <div class="widget-toolbar">
                        <?= Html::a('<i class="ace-icon fa fa-chevron-up"></i>', '#', ['data-action' => 'collapse']) ?>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <?php $form = ActiveForm::begin([
                            'id' => 'time-in-rent-form',
                            'action' => ['/dashboard/time-in'],
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'validationUrl' => ['validate-time-in'],
                            'options' => [
                                'autocomplete' => 'off',
                            ],
                        ]); ?>

                        <fieldset>
                            <?= $form->field($timeInRentModel, 'number')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($timeInRentModel, 'service')->radioList($featuredServices) ?>

                            <?= $form->field($timeInRentModel, 'pc')->dropDownList(['' => '- Select -']) ?>

                            <?= $form->field($timeInRentModel, 'topic')->textInput(['maxlength' => true]) ?>
                        </fieldset>

                        <div class="form-actions center">
                            <?= Html::submitButton(Yii::t('app', 'Submit') . '
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>', ['class' => 'btn btn-sm btn-success', 'name' => 'time-in-rent-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4">
            <div class="widget-box">
                <div class="widget-header widget-header-flat widget-header-small">
                    <h5 class="widget-title"><i class="ace-icon fa fa-sign-out"></i> <?= Yii::t('app', 'Time Out') ?></h5>

                    <div class="widget-toolbar">
                        <?= Html::a('<i class="ace-icon fa fa-chevron-up"></i>', '#', ['data-action' => 'collapse']) ?>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <?php $form = ActiveForm::begin([
                            'id' => 'time-out-rent-form',
                            'action' => ['/dashboard/time-out'],
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'validationUrl' => ['validate-time-out'],
                            'options' => [
                                'autocomplete' => 'off',
                            ],
                        ]); ?>

                        <fieldset>
                            <?= $form->field($timeOutRentModel, 'number')->textInput(['maxlength' => true]) ?>
                        </fieldset>

                        <div class="form-actions center">
                            <?= Html::submitButton(Yii::t('app', 'Submit') . '
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>', ['class' => 'btn btn-sm btn-success', 'name' => 'time-out-rent-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 widget-container-col">
        <?php Pjax::begin(); ?>
            <div id="recent-box"></div>
        <?php Pjax::end(); ?>
        </div>
    </div>

    <div class="hr hr32 hr-dotted"></div>

    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <div class="widget-box">
                <div class="widget-header widget-header-flat widget-header-small">
                    <h5 class="widget-title"><i class="ace-icon fa fa-sign-out"></i> <?= Yii::t('app', 'Sale') ?></h5>

                    <div class="widget-toolbar">
                        <?= Html::a('<i class="ace-icon fa fa-chevron-up"></i>', '#', ['data-action' => 'collapse']) ?>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main no-padding">
                        <?php $form = ActiveForm::begin([
                            'id' => 'sale-form',
                            'action' => ['/dashboard/sale'],
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'validationUrl' => ['validate-sale'],
                            'options' => [
                                'autocomplete' => 'off',
                            ],
                        ]); ?>

                        <fieldset>
                            <?= $form->field($saleModel, 'number')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($saleModel, 'service')->radioList($regularServices) ?>

                            <?= $form->field($saleModel, 'quantity')->widget(TouchSpin::classname(), [
                                'pluginOptions' => [
                                    'initval' => 1,
                                    'min' => 1,
                                    'max' => 100,
                                    'step' => 1,
                                    'buttonup_class' => 'btn btn-sm btn-primary',
                                    'buttondown_class' => 'btn btn-sm btn-danger',
                                ],
                            ]) ?>
                        </fieldset>

                        <div class="form-actions center">
                            <?= Html::submitButton(Yii::t('app', 'Submit') . '
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>', ['class' => 'btn btn-sm btn-success', 'name' => 'sale-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->registerJs('
cuts.dashboard.init({in:{ studentId: "' . Html::getInputId($timeInRentModel, 'number') . '", pcId: "' . Html::getInputId($timeInRentModel, 'pc') . '", pcUrl: "' . Url::toRoute(['/ajax/list-pc']) . '", recentTabId: "#recent-box", recentTabUrl: "' . Url::toRoute(['/ajax/recent']) . '" }, out: { studentId: "' . Html::getInputId($timeOutRentModel, 'number') . '" }});
',
View::POS_READY,
'dashboard-index') ?>