<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use kartik\widgets\Growl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Backlog Batch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$formatter = Yii::$app->formatter;
?>
<div class="col-xs-12">

    <div class="page-header">
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'backlog-batch-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validationUrl' => ['validate-backlog-batch'],
        'options' => [
            'autocomplete' => 'off',
        ],
    ]); ?>

        <div class="well">
            <div class="row">
                <div class="col-xs-6">
                    <?= $form->field($model, 'date_out')->widget(DatePicker::className(), [
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]) ?>
                </div>
                <div class="col-xs-6">
                    <?= $form->field($model, 'time_out')->widget(TimePicker::className(), [
                        'pluginOptions' => [
                            'minuteStep' => 1,
                            'secondStep' => 1,
                            'showMeridian' => false,
                            'showSeconds' => true,
                            'defaultTime' => false,
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Backlog Batch'), ['class' => 'btn btn-success']) ?>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],

                ['class' => 'kartik\grid\CheckboxColumn'],

                [
                    'attribute' => 'number',
                    'value' => function($model, $key, $index, $column) {
                        $student = $model->getStudent();
                        return $student->number;
                    },
                ],
                [
                    'attribute' => 'name',
                    'value' => function($model, $key, $index, $column) {
                        $student = $model->getStudent();
                        return $student->getFullname();
                    },
                ],
                [
                    'attribute' => 'pc',
                    'value' => function($model, $key, $index, $column) {
                        if ($model->pc !== null) {
                            $pc = $model->getPc();
                            return Html::encode($pc->code);
                        } else {
                            return 'N/A';
                        }
                    },
                ],
                [
                    'attribute' => 'service',
                    'value' => function($model, $key, $index, $column) {
                        $service = $model->getService();
                        return Html::encode($service->name);
                    },
                ],
                [
                    'attribute' => 'time_in',
                    'value' => function($model, $key, $index, $column) use ($formatter) {
                        return $formatter->asDateTime($model->time_in);
                    },
                ],
            ],
            'pjax' => true,
            'pjaxSettings' => [
                'options' => [
                    'id' => 'app-pjax-container',
                ],
            ],
            'hover' => true,
            'export' => false,
            'toolbar' => [
                ['content' =>
                    Html::a('<i class="fa fa-repeat"></i>', ['index'], [
                        'class' => 'btn btn-default', 
                        'title' => Yii::t('app', 'Reset Grid'),
                        'data-pjax' => 0,
                    ]),
                ],
                '{toggleData}',
            ],
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => 'Grid View',
            ],
        ]); ?>

    <?php ActiveForm::end(); ?>
</div>

<?php
$session = Yii::$app->session;

if ($session->hasFlash('backlogBatch')) {
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'title' => $session->getFlash('flashTitle'),
        'body' => $session->getFlash('backlogBatch'),
        'showSeparator' => true,
        'delay' => 0,
        'pluginOptions' => [
            'placement' => [
                'from' => 'top',
                'align' => 'right',
            ],
            'timer' => 5000,
        ],
    ]);
} ?>
