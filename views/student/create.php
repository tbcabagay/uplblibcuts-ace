<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = Yii::t('app', 'Create Student');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'colleges' => $colleges,
        'degrees' => $degrees,
    ]) ?>

</div>
