<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AcademicYear */

$this->title = Yii::t('app', 'Create Academic Year');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Academic Years'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academic-year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'semesters' => $semesters,
    ]) ?>

</div>
