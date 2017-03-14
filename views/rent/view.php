<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Rent */

$this->title = $model->getStudent()->number . ' - ' . $model->getStudent()->getFullname();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-view">

    <div class="page-header">
        <h1>
            Rent
        </h1>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
                'attribute' => 'college',
                'value' => $model->getCollege()->code,
            ],
            [
                'attribute' => 'degree',
                'value' => $model->getDegree()->code,
            ],
            [
                'attribute' => 'pc',
                'value' => ($model->pc) ? $model->getPc()->code : 'N/A',
            ],
            [
                'attribute' => 'service',
                'value' => $model->getService()->name,
            ],
            'topic',
            [
                'attribute' => 'amount',
                'value' => Yii::$app->formatter->asCurrency($model->amount),
            ],
            'time_in:datetime',
            'time_out:datetime',
            // 'rent_time:datetime',
            [
                'attribute' => 'time_diff',
                'value' => $model->getTimeDiff(),
            ],
        ],
    ]) ?>

</div>
