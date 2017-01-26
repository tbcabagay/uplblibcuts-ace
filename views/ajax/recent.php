<?php

use yii\helpers\Html;

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
                    <div class="comments">
                    <?php if (count($students) > 0): ?>
                    <?php foreach ($students as $student): ?>
                        <div class="itemdiv commentdiv">
                            <div class="user">
                                <i class="ace-icon fa fa-desktop text-info"></i>
                                <?= Html::encode($student->getPc()->code) ?>
                            </div>
                            <div class="body">
                                <div class="name">
                                    <?= Html::encode($student->getStudent()->number) ?>
                                </div>
                                <div class="time">
                                    <i class="ace-icon fa fa-clock-o"></i>
                                    <span class="green"><?= Yii::$app->formatter->asRelativeTime($student->time_in) ?></span>
                                </div>
                                <div class="text">
                                    <?= Html::encode($student->getStudent()->fullname) ?>
                                    <span class="text-warning"><?= Html::encode($student->getService()->name) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        (not set)
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>