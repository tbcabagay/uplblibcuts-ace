<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = "{$model->lastname} {$model->firstname} {$model->middlename}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

    <h3 class="header smaller lighter orange">
        <?= Html::encode($this->title) ?>
    </h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'number',
            'firstname',
            'middlename',
            'lastname',
            'sex',
            [
                'attribute' => 'college',
                'value' => function ($model, $widget) {
                    $college = $model->getCollege();
                    return Html::encode($college->code);
                },
            ],
            [
                'attribute' => 'degree',
                'value' => function ($model, $widget) {
                    $degree = $model->getDegree();
                    return Html::encode($degree->code);
                },
            ],
            // 'status',
            [
                'attribute' => 'rent_time',
                'value' => $model->getRentTime(),
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
