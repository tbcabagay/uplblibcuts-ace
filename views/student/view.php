<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use app\models\College;
use app\models\Degree;

/* @var $this yii\web\View */
/* @var $model app\models\Student */

$this->title = "{$model->lastname} {$model->firstname} {$model->middlename}";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

    <div class="page-header">
        <h1>
            Student
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <?= Html::encode($this->title) ?>
            </small>        
        </h1>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'number',
            'firstname',
            'middlename',
            'lastname',
            'sex',
            [
                'attribute' => 'college',
                'value' => call_user_func(function ($data) {
                    return College::findById($data->college);
                }, $model),
            ],
            [
                'attribute' => 'degree',
                'value' => call_user_func(function ($data) {
                    return Degree::findById($data->degree);
                }, $model),
            ],
            // 'status',
            [
                'attribute' => 'rent_time',
                'value' => $model->formatRentTime(),
            ],
            [
                'attribute' => 'created_at',
                'value' => call_user_func(function ($data) {
                    return Yii::$app->formatter->asDateTime($data->created_at);
                }, $model),
            ],
            [
                'attribute' => 'updated_at',
                'value' => call_user_func(function ($data) {
                    // Yii::$app->formatter->timeZone = 'Asia/Manila';
                    return Yii::$app->formatter->asDateTime($data->updated_at);
                }, $model),
            ],
        ],
    ]) ?>

</div>
