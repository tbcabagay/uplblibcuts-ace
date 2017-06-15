<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\Growl;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12">

    <div class="page-header">
        <h1>
            User Profile
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <?= Html::encode($this->title) ?>
            </small>
        </h1>
    </div>

    <p>
        <?= Html::a('<i class="ace-icon fa fa-lock"></i> ' . Yii::t('app', 'Change Password'), ['change-password', 'id' => $model->id], ['class' => 'btn btn-primary btn-modal']) ?>
        <?= ($model->isNew()) ? Html::a('<i class="ace-icon fa fa-unlock"></i> ' . Yii::t('app', 'Activate'), ['activate', 'id' => $model->id], ['class' => 'btn btn-success', 'data' => ['method' => 'post']]) : '' ?>
        <?php // Html::a('<i class="ace-icon fa fa-retweet"></i> ' . Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-default btn-modal']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'library',
                'value' => $model->getLibrary()->location,
            ],
            'name',
            'username',
            'access_token',
            'registration_ip',
            'created_at:datetime',
            'updated_at:datetime',
            //'timezone',
        ],
    ]) ?>

</div>

<?php
$session = Yii::$app->session;

if ($session->hasFlash('successChangePassword')) {
    echo Growl::widget([
        'type' => Growl::TYPE_SUCCESS,
        'title' => $session->getFlash('flashTitle'),
        'body' => $session->getFlash('successChangePassword'),
        'showSeparator' => true,
        'delay' => 0,
        'pluginOptions' => [
            'placement' => [
                'from' => 'top',
                'align' => 'right',
            ],
            'timer' => 5000,
        ],
    ]);
} ?>
