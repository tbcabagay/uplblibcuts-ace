<?php

use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use kartik\helpers\Html;

use app\models\Pc;
use app\models\Rent;

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
                <div class="widget-header">
                    <h4 class="widget-title"><i class="ace-icon fa fa-sign-in"></i> <?= Yii::t('app', 'Time In') ?></h4>

                    <div class="widget-toolbar">
                        <?= Html::a('<i class="ace-icon fa fa-chevron-up"></i>', '#', ['data-action' => 'collapse']) ?>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
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

                        <?= $form->field($timeInRentModel, 'number')->textInput(['maxlength' => true]) ?>


                        <?= $form->field($timeInRentModel, 'service')->radioButtonGroup($services, [
                            'class' => 'btn-group-sm',
                            'itemOptions' => ['labelOptions' => ['class' => 'btn btn-default']]
                        ]) ?>

                        <?= $form->field($timeInRentModel, 'pc')->dropDownList(['' => '- Select -']) ?>

                        <?= $form->field($timeInRentModel, 'topic')->textInput(['maxlength' => true]) ?>

                        <div class="form-actions no-padding">
                            <?= Html::submitButton(Yii::t('app', 'Submit') . '
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>', ['class' => 'btn btn-success width-100', 'name' => 'time-in-rent-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title"><i class="ace-icon fa fa-sign-out"></i> <?= Yii::t('app', 'Time Out') ?></h4>

                    <div class="widget-toolbar">
                        <?= Html::a('<i class="ace-icon fa fa-chevron-up"></i>', '#', ['data-action' => 'collapse']) ?>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
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

                        <?= $form->field($timeOutRentModel, 'number')->textInput(['maxlength' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('app', 'Submit') . '
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>', ['class' => 'btn btn-success width-100', 'name' => 'time-out-rent-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-4 widget-container-col">
        <?php Pjax::begin(); ?>
            <div id="recent-tab"></div>
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>

<?php $this->registerJs('
timeIn.init({ numberId: "#' . Html::getInputId($timeInRentModel, 'number') . '", pcId: "#' . Html::getInputId($timeInRentModel, 'pc') . '", pcAjaxUrl: "' . Url::toRoute(['/ajax/list-pc']) . '", recentTabId: "#recent-tab", recentTabUrl: "' . Url::toRoute(['/ajax/recent']) . '" });
timeOut.init({ numberId: "#' . Html::getInputId($timeOutRentModel, 'number') . '" });
',
View::POS_READY,
'dashboard-index') ?>