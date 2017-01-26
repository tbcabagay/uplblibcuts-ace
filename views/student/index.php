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
            // 'sex',
            // 'degree',
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
                    return $model->formatRentTime();
                },
                'filter' => false,
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model, $key, $index, $column) {
                    // Yii::$app->formatter->timeZone = Yii::$app->session->get('timeZone');
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
