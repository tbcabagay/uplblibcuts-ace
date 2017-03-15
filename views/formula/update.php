<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Formula */

$this->title = Yii::t('app', 'Update {modelClass}', [
    'modelClass' => 'Formula',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Formulas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="formula-update">

    <h3 class="header smaller lighter orange">
        <?= Html::encode($this->title) ?>
    </h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
