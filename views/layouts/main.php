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
                <!--
                    <li class="grey dropdown-modal">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="ace-icon fa fa-tasks"></i>
                            <span class="badge badge-grey">4</span>
                        </a>

                        <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header">
                                <i class="ace-icon fa fa-check"></i>
                                4 Tasks to complete
                            </li>

                            <li class="dropdown-content">
                                <ul class="dropdown-menu dropdown-navbar">
                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                <span class="pull-left">Software Update</span>
                                                <span class="pull-right">65%</span>
                                            </div>

                                            <div class="progress progress-mini">
                                                <div style="width:65%" class="progress-bar"></div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                <span class="pull-left">Hardware Upgrade</span>
                                                <span class="pull-right">35%</span>
                                            </div>

                                            <div class="progress progress-mini">
                                                <div style="width:35%" class="progress-bar progress-bar-danger"></div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                <span class="pull-left">Unit Testing</span>
                                                <span class="pull-right">15%</span>
                                            </div>

                                            <div class="progress progress-mini">
                                                <div style="width:15%" class="progress-bar progress-bar-warning"></div>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                <span class="pull-left">Bug Fixes</span>
                                                <span class="pull-right">90%</span>
                                            </div>

                                            <div class="progress progress-mini progress-striped active">
                                                <div style="width:90%" class="progress-bar progress-bar-success"></div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown-footer">
                                <a href="#">
                                    See tasks with details
                                    <i class="ace-icon fa fa-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="purple dropdown-modal">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                            <span class="badge badge-important">8</span>
                        </a>

                        <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header">
                                <i class="ace-icon fa fa-exclamation-triangle"></i>
                                8 Notifications
                            </li>

                            <li class="dropdown-content">
                                <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                <span class="pull-left">
                                                    <i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
                                                    New Comments
                                                </span>
                                                <span class="pull-right badge badge-info">+12</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="btn btn-xs btn-primary fa fa-user"></i>
                                            Bob just signed up as an editor ...
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                <span class="pull-left">
                                                    <i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
                                                    New Orders
                                                </span>
                                                <span class="pull-right badge badge-success">+8</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                <span class="pull-left">
                                                    <i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
                                                    Followers
                                                </span>
                                                <span class="pull-right badge badge-info">+11</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown-footer">
                                <a href="#">
                                    See all notifications
                                    <i class="ace-icon fa fa-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="green dropdown-modal">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
                            <span class="badge badge-success">5</span>
                        </a>

                        <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header">
                                <i class="ace-icon fa fa-envelope-o"></i>
                                5 Messages
                            </li>

                            <li class="dropdown-content">
                                <ul class="dropdown-menu dropdown-navbar">
                                    <li>
                                        <a href="#" class="clearfix">
                                            <img src="assets/images/avatars/avatar.png" class="msg-photo" alt="Alex's Avatar" />
                                            <span class="msg-body">
                                                <span class="msg-title">
                                                    <span class="blue">Alex:</span>
                                                    Ciao sociis natoque penatibus et auctor ...
                                                </span>

                                                <span class="msg-time">
                                                    <i class="ace-icon fa fa-clock-o"></i>
                                                    <span>a moment ago</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="clearfix">
                                            <img src="assets/images/avatars/avatar3.png" class="msg-photo" alt="Susan's Avatar" />
                                            <span class="msg-body">
                                                <span class="msg-title">
                                                    <span class="blue">Susan:</span>
                                                    Vestibulum id ligula porta felis euismod ...
                                                </span>

                                                <span class="msg-time">
                                                    <i class="ace-icon fa fa-clock-o"></i>
                                                    <span>20 minutes ago</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="clearfix">
                                            <img src="assets/images/avatars/avatar4.png" class="msg-photo" alt="Bob's Avatar" />
                                            <span class="msg-body">
                                                <span class="msg-title">
                                                    <span class="blue">Bob:</span>
                                                    Nullam quis risus eget urna mollis ornare ...
                                                </span>

                                                <span class="msg-time">
                                                    <i class="ace-icon fa fa-clock-o"></i>
                                                    <span>3:15 pm</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="clearfix">
                                            <img src="assets/images/avatars/avatar2.png" class="msg-photo" alt="Kate's Avatar" />
                                            <span class="msg-body">
                                                <span class="msg-title">
                                                    <span class="blue">Kate:</span>
                                                    Ciao sociis natoque eget urna mollis ornare ...
                                                </span>

                                                <span class="msg-time">
                                                    <i class="ace-icon fa fa-clock-o"></i>
                                                    <span>1:33 pm</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#" class="clearfix">
                                            <img src="assets/images/avatars/avatar5.png" class="msg-photo" alt="Fred's Avatar" />
                                            <span class="msg-body">
                                                <span class="msg-title">
                                                    <span class="blue">Fred:</span>
                                                    Vestibulum id penatibus et auctor  ...
                                                </span>

                                                <span class="msg-time">
                                                    <i class="ace-icon fa fa-clock-o"></i>
                                                    <span>10:09 am</span>
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown-footer">
                                <a href="inbox.html">
                                    See all messages
                                    <i class="ace-icon fa fa-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>-->

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
                                <a href="#">
                                    <i class="ace-icon fa fa-cog"></i>
                                    Settings
                                </a>
                            </li>

                            <li>
                                <a href="profile.html">
                                    <i class="ace-icon fa fa-user"></i>
                                    Profile
                                </a>
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
