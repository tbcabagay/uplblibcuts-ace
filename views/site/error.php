<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="col-xs-12">

    <div class="error-container">
        <div class="well">
            <h1 class="grey lighter smaller">
                <span class="blue bigger-125">
                    <i class="ace-icon fa fa-sitemap"></i>
                    <?= Html::encode($this->title) ?>
                </span>
            </h1>

            <hr />
            <h3 class="lighter smaller"><?= nl2br(Html::encode($message)) ?></h3>

            <div class="space"></div>

            <ul class="list-unstyled spaced inline bigger-110 margin-15">
                <li>
                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                    The above error occurred while the Web server was processing your request.
                </li>
                <li>
                    <i class="ace-icon fa fa-hand-o-right blue"></i>
                    Please contact us if you think this is a server error. Thank you.
                </li>
            </ul>

            <hr />
            <div class="space"></div>

            <div class="center">
                <?= Html::a('<i class="ace-icon fa fa-arrow-left"></i> Go Back', 'javascript:history.back()', ['class' => 'btn btn-grey']) ?>
                <?= Html::a('<i class="ace-icon fa fa-tachometer"></i> Dashboard', ['/dashboard/index'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
