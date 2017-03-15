<?php

use yii\helpers\Html;
use kartik\grid\GridView;

use app\models\College;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Students');
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
            'number',
            'lastname',
            'firstname',
            'middlename',
            'sex',
            [
                'attribute' => 'degree',
                'value' => function($model, $key, $index, $column) {
                    $degree = $model->getDegree();
                    return Html::encode($degree->description);
                },
                'filter' => $degrees,
            ],
            [
                'attribute' => 'college',
                'value' => function($model, $key, $index, $column) {
                    $college = $model->getCollege();
                    return Html::encode($college->description);
                },
                'filter' => $colleges,
            ],
            // 'status',
            [
                'attribute' => 'rent_time',
                'value' => function($model, $key, $index, $column) {
                    return $model->getRentTime();
                },
                'filter' => false,
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model, $key, $index, $column) {
                    return Yii::$app->formatter->asDateTime($model->created_at);
                },
                'filter' => false,
            ],
            // 'updated_at',

            [
                'class' => 'kartik\grid\ActionColumn',
                'viewOptions' => ['class' => 'btn-modal'],
                'updateOptions' => ['class' => 'btn-modal'],
            ],
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            if ($model->isChargeableByCollege() || $model->isChargeable()) {
                return ['class' => 'warning'];
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
            'after' => '<em><span class="label label-warning label-white middle">* Students who do not have free computer usage hours.</span></em>',
        ],
    ]); ?>
</div>
