<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\College */

$this->title = Yii::t('app', 'Create College');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Colleges'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="college-create">

    <h3 class="header smaller lighter orange">
        <?= Html::encode($this->title) ?>
    </h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
