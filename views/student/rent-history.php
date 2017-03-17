<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use app\models\College;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rent History');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$formatter = Yii::$app->formatter;
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

    <div class="row">
        <div class="col-xs-4">
            <div class="well">
                <h4 class="orange smaller lighter"><?= Html::encode($studentModel->getFullname()) ?></h4>
                <dl>
                    <dt>Number</dt>
                    <dd><?= Html::encode($studentModel->number) ?></dd>
                    <dt>College</dt>
                    <dd><?= Html::encode($studentModel->getCollege()->code) ?></dd>
                    <dt>Degree</dt>
                    <dd><?= Html::encode($studentModel->getDegree()->code) ?></dd>
                </dl>

                <p class="clearfix">
                    <?= Html::a('Go back', ['index'], ['class' => 'btn btn-default btn-white pull-right']) ?>
                </p>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute' => 'service',
                'value' => function($model, $key, $index, $column) {
                    $service = $model->getService();
                    return Html::encode($service->name);
                },
                'filter' => $services,
            ],
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
            [
                'attribute' => 'library',
                'value' => function($model, $key, $index, $column) {
                    $library = $model->getLibrary();
                    return Html::encode($library->location);
                },
                'filter' => false,
            ],
            [
                'attribute' => 'pc',
                'value' => function($model, $key, $index, $column) {
                    if (is_null($model->pc)) {
                        return 'N/A';
                    } else {
                        $pc = $model->getPc();
                        return Html::encode($pc->code);
                    }                    
                },
                'filter' => false,
            ],
            [
                'attribute' => 'time_diff',
                'value' => function($model, $key, $index, $column) {
                    return Html::encode($model->getTimeDiff());
                },
                'hAlign' => 'center',
                'filter' => false,
            ],
            [
                'attribute' => 'rent_time',
                'value' => function($model, $key, $index, $column) {
                    if (!$model->rent_time) {
                        return 'N/A';
                    } else {
                        return Html::encode($model->getRentTime());
                    }
                },
                'hAlign' => 'center',
                'filter' => false,
            ],
            [
                'attribute' => 'amount',
                'format' => 'currency',
                'hAlign' => 'center',
                'filter' => false,
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
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
                    'title' => Yii::t('app', 'Add Student'), 
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
