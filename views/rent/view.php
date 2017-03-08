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

    <h1><?= Html::encode($this->title) ?></h1>
<?php /*
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
*/ ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
