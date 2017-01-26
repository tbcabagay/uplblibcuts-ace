<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;

use app\models\AcademicYear;
use kartik\widgets\Growl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AcademicYearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Academic Years');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">

    <div class="page-header">
        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'semester',
                'value' => function($model, $key, $index, $column) {
                    return AcademicYear::findBySemester($model->semester);
                },
                'filter' => $semesters,
            ],
            'date_start:date',
            'date_end:date',
            [
                'attribute' => 'status',
                'value' => function($model, $key, $index, $column) {
                    return AcademicYear::findByStatus($model->status);
                },
                'format' => 'html',
                'filter' => false,
            ],
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{toggle-status} {update} {delete}',
                'viewOptions' => ['class' => 'btn-modal'],
                'updateOptions' => ['class' => 'btn-modal'],
                'buttons' => [
                    'toggle-status' => function ($url, $model, $key) {
                        if ($model->status === AcademicYear::STATUS_ACTIVE) {
                            return Html::a('<i class="fa fa-toggle-off"></i>', ['/academic-year/toggle-status', 'id' => $model->id], ['data-pjax' => 'false', 'title' => Yii::t('app', 'Toggle Off'), 'class' => 'btn-toggle']);
                        }                        
                    },
                ],
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
                Html::a('<i class="fa fa-plus"></i>', ['create'], [
                    'title' => Yii::t('app', 'Add Academic Calendar'), 
                    'class' => 'btn btn-success btn-modal',
                    'data-pjax' => 0,
                ]) . ' ' .
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
</div>

<?php
$session = Yii::$app->session;

if ($session->hasFlash('setAcademicYear')) {
    echo Growl::widget([
        'type' => Growl::TYPE_INFO,
        'title' => $session->getFlash('flashTitle'),
        'body' => $session->getFlash('setAcademicYear'),
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

<?php $this->registerJs('
jQuery(".btn-toggle").on("click", function() {
    var $btn = jQuery(this);
    BootstrapDialog.confirm({
        title: "Confirmation",
        message: "Are you sure you want to deactivate this item?",
        type: BootstrapDialog.TYPE_WARNING,
        callback: function(result) {
            if (result) {
                jQuery.ajax({
                    url: $btn.attr("href"),
                    type: "post",

                }).done(function (data) {
                    jQuery.pjax.reload({ container: "#app-pjax-container" });
                });
            }
        },
    });
    return false;
});
',
View::POS_READY,
'academic-year-index') ?>