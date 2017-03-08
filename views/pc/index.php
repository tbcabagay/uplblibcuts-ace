<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

use app\models\Pc;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PcSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'PCs');
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
            // [
            //     'attribute' => 'library',
            //     'value' => function($model, $key, $index, $column) {
            //         $library = $model->getLibrary();
            //         return Html::encode($library->location);
            //     },
            //     'filter' => $libraries,
            // ],
            'code',
            'ip_address',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'viewOptions' => ['class' => 'btn-modal'],
                'updateOptions' => ['class' => 'btn-modal'],
            ],
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            if ($model->isOccupied()) {
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
                    'title' => Yii::t('app', 'Add PC'), 
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
            'before' => Html::button('<i class="fa fa-desktop"></i>
                ' . Yii::t('app', 'Vacate {n, plural, =0{} =1{(#) PC} other{(#) PCs}}', ['n' => $searchModel->countByStatus(Pc::STATUS_OCCUPIED)]), [
                'id' => 'vacate-pcs',
                'class' => 'btn btn-danger',
                'data-value' => Url::to(['vacate']),
                'value' => 0,
                'disabled' => ($searchModel->countByStatus(Pc::STATUS_OCCUPIED) < 1) ? true : false,
            ])
        ],
    ]); ?>
</div>
