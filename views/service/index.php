<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Services');
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
            'name',
            'amount:currency',
            [
                'attribute' => 'formula',
                'value' => function($model, $key, $index, $column) {
                    $formula = $model->getFormula();
                    return $formula->unit;
                },
                'hAlign' => GridView::ALIGN_CENTER,
                'filter' => $formulas,
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'viewOptions' => ['class' => 'btn-modal'],
                'updateOptions' => ['class' => 'btn-modal'],
            ],
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            if ($model->isFeatured()) {
                return ['class' => 'success'];
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
                    'title' => Yii::t('app', 'Add Service'), 
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
            'after' => '<em><span class="label label-success label-white middle">* Services that are featured.</span></em>',
        ],
    ]); ?>
</div>
