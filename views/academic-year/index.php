<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use app\models\AcademicYear;

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
                'template' => '{update} {delete}',
                'viewOptions' => ['class' => 'btn-modal'],
                'updateOptions' => ['class' => 'btn-modal'],
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
