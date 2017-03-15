<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Rent */

$this->title = Yii::t('app', 'Time In');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-create">

    <h3 class="header smaller lighter orange">
        <?= Html::encode($this->title) ?>
    </h3>

    <?= $this->render('_form', [
        'model' => $model,
        'featuredServices' => $featuredServices,
        'pcs' => $pcs,
    ]) ?>

</div>
