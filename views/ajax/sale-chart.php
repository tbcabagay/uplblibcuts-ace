<?php

use kartik\helpers\Html;
use dosamigos\highcharts\HighCharts;

/* @var $this yii\web\View */
?>

<?= HighCharts::widget([
    'clientOptions' => [
        'title' => [
             'text' => 'Sale Stats'
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