<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rents');
$this->params['breadcrumbs'][] = $this->title;

$formatter = Yii::$app->formatter;
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
            /*[
                'attribute' => 'college',
                'value' => function($model, $key, $index, $column) {
                    $college = $model->getCollege();
                    return Html::encode($college->code);
                },
                'filter' => $colleges,
            ],*/
            // 'degree',
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
                'filter' => $pcs,
            ],
            [
                'attribute' => 'service',
                'value' => function($model, $key, $index, $column) {
                    $service = $model->getService();
                    return Html::encode($service->name);
                },
                'filter' => $services,
            ],
            // 'topic',
            // 'amount:currency',
            // 'status',
            [
                'attribute' => 'time_in',
                'value' => function($model, $key, $index, $column) use ($formatter) {
                    return $formatter->asDateTime($model->time_in);
                },
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ],
            ],
            [
                'attribute' => 'time_out',
                'value' => function($model, $key, $index, $column) use ($formatter) {
                    return $formatter->asDateTime($model->time_out);
                },
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ],
            ],
            // 'rent_time:datetime',
            [
                'attribute' => 'time_diff',
                'value' => function($model, $key, $index, $column) {
                    return Html::encode($model->getTimeDiff());
                },
            ],
            // 'created_by',
            // 'updated_by',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {delete}',
                'viewOptions' => ['class' => 'btn-modal'],
            ],
        ],
        /*'rowOptions' => function ($model, $key, $index, $grid) {
            if ($model->isFeatured()) {
                return ['class' => 'success'];
            }
        },*/
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
                    'title' => Yii::t('app', 'Add Rent'), 
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
