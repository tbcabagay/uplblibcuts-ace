<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rents');
$this->params['breadcrumbs'][] = $this->title;

$session = Yii::$app->session;
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'student',
                'value' => function($model, $key, $index, $column) {
                    $student = $model->getStudent();
                    return '<strong>' . Html::encode($student->number) . '</strong>
                        ' . Html::encode($student->getFullname());
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'college',
                'value' => function($model, $key, $index, $column) {
                    $college = $model->getCollege();
                    return Html::encode($college->code);
                },
            ],
            // 'degree',
            [
                'attribute' => 'pc',
                'value' => function($model, $key, $index, $column) {
                    $pc = $model->getPc();
                    return Html::encode($pc->code);
                },
            ],
            [
                'attribute' => 'service',
                'value' => function($model, $key, $index, $column) {
                    $service = $model->getService();
                    return Html::encode($service->name);
                },
            ],
            // 'topic',
            // 'amount',
            // 'status',
            /*[
                'attribute' => 'time_in',
                'value' => function($model, $key, $index, $column) use ($session, $formatter) {
                    $time_in = date('Y-m-d H:i:s', $model->time_in);

                    if ($session->has('time_zone')) {
                        $time_in = $time_in . ' Asia/Manila'; // . $session->get('time_zone');
                    }
                    return $formatter->asDateTime($time_in);
                },
            ],*/
            // 'time_in:datetime',
            'time_out:datetime',
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
                'template' => '{delete}',
            ],
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            /*if ($model->isFeatured()) {
                return ['class' => 'success'];
            }*/
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
        ],
    ]); ?>
</div>
