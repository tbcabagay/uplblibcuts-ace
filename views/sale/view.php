<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sale */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-view">

    <div class="page-header">
        <h1>
            Sale
        </h1>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'academic_calendar',
            [
                'attribute' => 'library',
                'value' => $model->getLibrary()->location,
            ],
            [
                'attribute' => 'number',
                'value' => function ($model, $widget) {
                    $student = $model->getStudent();
                    return Html::encode($student->number);
                },
            ],
            [
                'attribute' => 'name',
                'value' => function ($model, $widget) {
                    $student = $model->getStudent();
                    return Html::encode($student->getFullname());
                },
            ],
            [
                'attribute' => 'service',
                'value' => function ($model, $widget) {
                    $service = $model->getService();
                    return Html::encode($service->name);
                },
            ],
            'quantity',
            'amount:currency',
            'total:currency',
            'created_at:datetime',
            [
                'attribute' => 'created_by',
                'value' => function ($model, $widget) {
                    $user = $model->getCreatedBy();
                    return Html::encode($user->name);
                },
            ],
        ],
    ]) ?>

</div>
