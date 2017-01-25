<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */

?>

<div class="widget-box transparent">
    <div class="widget-header">
        <h4 class="widget-title lighter smaller">
            <i class="ace-icon fa fa-rss orange"></i>RECENT
        </h4>

        <div class="widget-toolbar no-border">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#student-tab">Students</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="widget-body">
        <div class="widget-main padding-4">
            <div class="tab-content padding-8">
                <div id="student-tab" class="tab-pane active">
                    <?php ListView::widget([
                        'dataProvider' => $studentDataProvider,
                        'itemView' => '_recentView',
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>