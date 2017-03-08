<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\FontAwesomeAsset;
use app\assets\FlagIconAsset;
use app\assets\AceAsset;
use app\assets\AceSkinAsset;
use app\assets\AppFontAsset;
use app\assets\Ace2Asset;
use app\assets\AceIeAsset;
use yii\bootstrap\Modal;

AppAsset::register($this);
FontAwesomeAsset::register($this);
FlagIconAsset::register($this);
AppFontAsset::register($this);
AceAsset::register($this);
Ace2Asset::register($this);
AceSkinAsset::register($this);
AceIeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="no-skin">
<?php $this->beginBody() ?>

    <div id="navbar" class="navbar navbar-default ace-save-state">
        <div class="navbar-container ace-save-state" id="navbar-container">
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>
            </button>

            <div class="navbar-header pull-left">
                <a href="index.html" class="navbar-brand">
                    <small>
                        <i class="fa fa-desktop"></i>
                        <?= Html::encode(Yii::$app->params['appName']) ?>
                    </small>
                </a>
            </div>

            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">
                    <li class="light-blue dropdown-modal">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <?php // Html::img('@web/img/avatars/user.jpg', ['class' => 'nav-user-photo']) ?>
                            <i class="ace-icon fa fa-user"></i>
                            <span class="user-info">
                                <small>Welcome,</small>
                                <?= Html::encode(Yii::$app->user->identity->username) ?>
                            </span>

                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <?= Html::a('<i class="ace-icon fa fa-user"></i> Profile', ['/user/view', 'id' => Yii::$app->user->identity->id]) ?>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <?= Html::a('<i class="ace-icon fa fa-power-off"></i> Logout', ['/site/logout'], ['data-method' => 'post']) ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div><!-- /.navbar-container -->
    </div>

    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try{ace.settings.loadState('main-container')}catch(e){}
        </script>

        <div id="sidebar" class="sidebar responsive ace-save-state">
            <script type="text/javascript">
                try{ace.settings.loadState('sidebar')}catch(e){}
            </script>
            <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                    <button class="btn btn-success">
                        <i class="ace-icon fa fa-signal"></i>
                    </button>

                    <button class="btn btn-info">
                        <i class="ace-icon fa fa-pencil"></i>
                    </button>

                    <button class="btn btn-warning">
                        <i class="ace-icon fa fa-users"></i>
                    </button>

                    <button class="btn btn-danger">
                        <i class="ace-icon fa fa-cogs"></i>
                    </button>
                </div>

                <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span>

                    <span class="btn btn-info"></span>

                    <span class="btn btn-warning"></span>

                    <span class="btn btn-danger"></span>
                </div>
            </div>

            <ul class="nav nav-list">
                <li class="<?= ($this->context->id === 'dashboard') ? 'active' : null ?>">
                    <?= Html::a('<i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text"> Dashboard </span>', ['dashboard/index']) ?>

                    <b class="arrow"></b>
                </li>

                <li class="<?= (in_array($this->context->id, ['college', 'degree', 'library', 'service', 'formula', 'pc', 'student', 'user'])) ? 'open active' : null ?>">
                    <?= Html::a('<i class="menu-icon fa fa-cogs"></i>
                        <span class="menu-text">
                            Settings
                        </span>

                        <b class="arrow fa fa-angle-down"></b>', '#', ['class' => 'dropdown-toggle']) ?>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="<?= ($this->context->id === 'college') ? 'active' : null ?>">
                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i>
                                Colleges', ['/college/index']) ?>

                            <b class="arrow"></b>
                        </li>
                        <li class="<?= ($this->context->id === 'degree') ? 'active' : null ?>">
                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i>
                                Degrees', ['/degree/index']) ?>

                            <b class="arrow"></b>
                        </li>
                        <li class="<?= ($this->context->id === 'library') ? 'active' : null ?>">
                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i>
                                Libraries', ['/library/index']) ?>

                            <b class="arrow"></b>
                        </li>
                        <li class="<?= ($this->context->id === 'formula') ? 'active' : null ?>">
                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i>
                                Formulas', ['/formula/index']) ?>

                            <b class="arrow"></b>
                        </li>
                        <li class="<?= ($this->context->id === 'service') ? 'active' : null ?>">
                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i>
                                Services', ['/service/index']) ?>

                            <b class="arrow"></b>
                        </li>
                        <li class="<?= ($this->context->id === 'pc') ? 'active' : null ?>">
                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i>
                                PCs', ['/pc/index']) ?>

                            <b class="arrow"></b>
                        </li>
                        <li class="<?= ($this->context->id === 'student') ? 'active' : null ?>">
                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i>
                                Students', ['/student/index']) ?>

                            <b class="arrow"></b>
                        </li>
                        <li class="<?= ($this->context->id === 'user') ? 'active' : null ?>">
                            <?= Html::a('<i class="menu-icon fa fa-caret-right"></i>
                                Users', ['/user/index']) ?>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <li class="<?= ($this->context->id === 'academic-calendar') ? 'active' : null ?>">
                    <?= Html::a('<i class="menu-icon fa fa-calendar"></i>
                        <span class="menu-text"> Academic Calendars </span>', ['academic-calendar/index']) ?>

                    <b class="arrow"></b>
                </li>
                <li class="<?= ($this->context->id === 'rent') ? 'active' : null ?>">
                    <?= Html::a('<i class="menu-icon fa fa-sign-in"></i>
                        <span class="menu-text"> Rents </span>', ['/rent/index']) ?>

                    <b class="arrow"></b>
                </li>
            </ul>

            <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
            </div>
        </div>

        <div class="main-content">
            <div class="main-content-inner">
                <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                </div>
                <div class="page-content">
                    <div class="row">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="footer-inner">
                <div class="footer-content clearfix">
                    <span class="bigger-120"><span class="blue bolder"><?= Html::encode(Yii::$app->params['appName']) ?></span> Application &copy; 2016</span>
                    <span class="pull-left smaller-90">
                        Set Time Zone:
                        <?= Html::a('UTC', ['/site/set-timezone', 'timezone' => 'UTC'], ['class' => 'change-timezone']) ?>
                        <?= Html::a('<span class="flag-icon flag-icon-ph"></span>', ['/site/set-timezone', 'timezone' => 'Manila'], ['class' => 'change-timezone']) ?>
                    </span>
                </div>
            </div>
        </footer>

        <?= Html::a('<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>', '#', ['id' => 'btn-scroll-up', 'class' => 'btn-scroll-up btn btn-sm btn-inverse']) ?>
    </div>
<?php $this->endBody() ?>
<?php Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => '<span class="modal-header-content"></span>',
    'clientOptions' => [
        'backdrop' => 'static',
    ],
]);
Modal::end(); ?>
</body>
</html>
<?php $this->endPage() ?>
