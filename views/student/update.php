<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Student',
]) . "{$model->lastname} {$model->firstname} {$model->middlename}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "{$model->lastname} {$model->firstname} {$model->middlename}", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="student-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'colleges' => $colleges,
        'degrees' => $degrees,
    ]) ?>

</div>
