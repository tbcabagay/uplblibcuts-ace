<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Degree */

$this->title = Yii::t('app', 'Create Degree');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Degrees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="degree-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
