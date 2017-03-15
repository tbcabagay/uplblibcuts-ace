<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Formula */

$this->title = Yii::t('app', 'Create Formula');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Formulas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formula-create">

    <h3 class="header smaller lighter orange">
        <?= Html::encode($this->title) ?>
    </h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
