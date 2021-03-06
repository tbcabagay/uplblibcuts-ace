<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;

use kartik\widgets\Growl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AcademicCalendarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Academic Calendars');
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
                    return $model->getTextSemester();
                },
                'filter' => $searchModel->getSemesterList(),
            ],
            'date_start:date',
            'date_end:date',
            [
                'attribute' => 'status',
                'value' => function($model, $key, $index, $column) {
                    return $model->getTextStatus();
                },
                'format' => 'html',
                'hAlign' => GridView::ALIGN_CENTER,
                'filter' => $searchModel->getStatusList(),
            ],
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{toggle-status} {update} {delete}',
                'viewOptions' => ['class' => 'btn-modal'],
                'updateOptions' => ['class' => 'btn-modal'],
                'visibleButtons' => [
                    'toggle-status' => function ($model, $key, $index) {
                        return $model->isActive();
                    },
                    'update' => function ($model, $key, $index) {
                        return $model->isActive();
                    },
                ],
                'buttons' => [
                    'toggle-status' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-toggle-off"></i>', ['/academic-calendar/toggle-status', 'id' => $model->id], ['data-pjax' => 'false', 'title' => Yii::t('app', 'Toggle Off'), 'class' => 'btn-toggle']);
                    },
                ],
            ],
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            if ($model->isActive()) {
                return ['class' => 'success'];
            } else {
                return ['class' => 'danger'];
            }
        },
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

if ($session->hasFlash('setAcademicCalendar')) {
    echo Growl::widget([
        'type' => Growl::TYPE_INFO,
        'title' => $session->getFlash('flashTitle'),
        'body' => $session->getFlash('setAcademicCalendar'),
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
