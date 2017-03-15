<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pc */

$this->title = Yii::t('app', 'Create Pc');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pcs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pc-create">

    <h3 class="header smaller lighter orange">
        <?= Html::encode($this->title) ?>
    </h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
