<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AcademicCalendar */

$this->title = Yii::t('app', 'Create Academic Calendar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Academic Calendars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="academic-calendar-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'semesters' => $semesters,
    ]) ?>

</div>
