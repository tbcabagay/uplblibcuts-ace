<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sales');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">

    <div class="page-header">
        <h1>
            Settings
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <?= Html::encode($this->title) ?>
            </small>        
        </h1>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            // 'id',
            // 'academic_calendar',
            // 'library',
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
                'attribute' => 'service',
                'value' => function($model, $key, $index, $column) {
                    $service = $model->getService();
                    return Html::encode($service->name);
                },
                'filter' => $services,
            ],
            [
                'attribute' => 'quantity',
                'hAlign' => GridView::ALIGN_CENTER,
            ],
            // 'amount',
            [
                'attribute' => 'total',
                'hAlign' => GridView::ALIGN_CENTER,
                'format' => 'currency',
            ],
            [
                'attribute' => 'created_at',
                'format' => 'date',
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ],
            ],
            [
                'attribute' => 'created_by',
                'value' => function($model, $key, $index, $column) {
                    $user = $model->getCreatedBy();
                    return Html::encode($user->name);
                },
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'viewOptions' => ['class' => 'btn-modal'],
                'updateOptions' => ['class' => 'btn-modal'],
                'template' => '{view} {update}',
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
</div>
