<?php

use kartik\helpers\Html;
use dosamigos\highcharts\HighCharts;

/* @var $this yii\web\View */
?>

<?= HighCharts::widget([
    'clientOptions' => [
        'title' => [
             'text' => 'Service Stats'
             ],
        'xAxis' => [
            'categories' => $services,
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Frequency'
            ]
        ],
        'series' => $series,
    ]
]) ?>