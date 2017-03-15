<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\College */

$this->title = Yii::t('app', 'Update {modelClass}', [
    'modelClass' => 'College',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Colleges'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="college-update">

    <h3 class="header smaller lighter orange">
        <?= Html::encode($this->title) ?>
    </h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
