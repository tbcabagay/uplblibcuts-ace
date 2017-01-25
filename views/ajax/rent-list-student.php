<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Student;
use app\models\Pc;

/* @var $this yii\web\View */

?>

<div class="widget-box transparent">
    <div class="widget-header">
        <h4 class="widget-title lighter smaller">
            <i class="ace-icon fa fa-rss orange"></i>RECENT
        </h4>

        <div class="widget-toolbar no-border">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#online-tab">Online</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-main padding-4">
            <div class="tab-content padding-8">
                <div id="online-tab" class="tab-pane">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php /* GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'student',
            'value' => function($model, $key, $index, $column) {
                $student = Student::findOne($model->id);
                return Html::encode($student->number) . ' - ' . Html::encode($student->fullname);
            },
            'label' => '<i class="ace-icon fa fa-user"></i> Student',
            'encodeLabel' => false,

        ],
        [
            'attribute' => 'pc',
            'value' => function($model, $key, $index, $column) {
                $pc = Pc::findOne($model->pc);
                return Html::encode($pc->code);
            },
            'label' => '<i class="ace-icon fa fa-desktop"></i>',
            'encodeLabel' => false,
        ],
        [
            'attribute' => 'time_in',
            'value' => function($model, $key, $index, $column) {
                return Yii::$app->formatter->asTime($model->time_in);
            },
            'label' => '<i class="ace-icon fa fa-clock-o"></i> Time In',
            'encodeLabel' => false,
        ],
    ],
    'hover' => true,
    'export' => false,
    'toolbar' => false,
    'panel' => [
        'type' => GridView::TYPE_DEFAULT,
        'heading' => '<i class="ace-icon fa fa-globe"></i>
            ' . Yii::t('app', 'Who\'s In'),
    ],
]); */ ?>