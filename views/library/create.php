<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Library */

$this->title = Yii::t('app', 'Create Library');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Libraries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="library-create">

    <h3 class="header smaller lighter orange">
        <?= Html::encode($this->title) ?>
    </h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
