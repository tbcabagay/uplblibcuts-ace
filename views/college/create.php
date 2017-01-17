<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\College */

$this->title = Yii::t('app', 'Create College');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Colleges'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="college-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
