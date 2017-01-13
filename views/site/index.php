<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */

$this->title = 'Home';
?>
<div id="login-box" class="login-box visible widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header blue lighter bigger">
                <i class="ace-icon fa fa-coffee green"></i>
                Please Enter Your Information
            </h4>

            <div class="space-6"></div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'formConfig' => [
                    'showLabels' => false,
                ],
            ]); ?>

                <?= $form->field($loginModel, 'username', [
                    'feedbackIcon' => [
                        'prefix' => 'ace-icon fa fa-',
                        'default' => 'user',
                        'success' => 'check',
                        'error' => 'exclamation',
                        'defaultOptions' => ['class' => 'text-primary']
                    ]
                ])->textInput([
                    'placeholder' => $loginModel->getAttributeLabel('username'),
                ]) ?>

                <?= $form->field($loginModel, 'password', [
                    'feedbackIcon' => [
                        'prefix' => 'ace-icon fa fa-',
                        'default' => 'lock',
                        'success' => 'check',
                        'error' => 'exclamation',
                        'defaultOptions' => ['class' => 'text-primary']
                    ]
                ])->passwordInput([
                    'placeholder' => $loginModel->getAttributeLabel('password'),
                ]) ?>

                <div class="space"></div>

                <?= $form->field($loginModel, 'rememberMe')->checkbox() ?>

                <?= Html::submitButton('<i class="ace-icon fa fa-key"></i> <span class="bigger-110">Login</span>', ['class' => 'btn btn-block btn-primary width-100 ', 'name' => 'login-button']) ?>

            <?php ActiveForm::end(); ?>

        </div>

        <div class="toolbar clearfix">
            <div>
                <a href="#" data-target="#forgot-box" class="forgot-password-link">
                    <i class="ace-icon fa fa-arrow-left"></i>
                    I forgot my password
                </a>
            </div>

            <div>
                <a href="#" data-target="#signup-box" class="user-signup-link">
                    I want to register
                    <i class="ace-icon fa fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="forgot-box" class="forgot-box widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header red lighter bigger">
                <i class="ace-icon fa fa-key"></i>
                Retrieve Password
            </h4>

            <div class="space-6"></div>
            <p>
                Enter your email and to receive instructions
            </p>

            <form>
                <fieldset>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="email" class="form-control" placeholder="Email" />
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                    </label>

                    <div class="clearfix">
                        <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                            <i class="ace-icon fa fa-lightbulb-o"></i>
                            <span class="bigger-110">Send Me!</span>
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>

        <div class="toolbar center">
            <a href="#" data-target="#login-box" class="back-to-login-link">
                Back to login
                <i class="ace-icon fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<div id="signup-box" class="signup-box widget-box no-border">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header green lighter bigger">
                <i class="ace-icon fa fa-users blue"></i>
                New User Registration
            </h4>

            <div class="space-6"></div>
            <p> Enter your details to begin: </p>

            <?php $form = ActiveForm::begin([
                'id' => 'signup-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validationUrl' => ['validate-signup'],
                'options' => [
                    'autocomplete' => 'off',
                ],
                'formConfig' => [
                    'showLabels' => false,
                ],
            ]); ?>

                <?= $form->field($registerModel, 'library')->widget(Select2::className(), [
                    'data' => $libraries,
                    'options' => ['placeholder' => $registerModel->getAttributeLabel('library')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

                <?= $form->field($registerModel, 'name', [
                    'feedbackIcon' => [
                        'prefix' => 'ace-icon fa fa-',
                        'default' => 'address-card',
                        'success' => 'check',
                        'error' => 'exclamation',
                        'defaultOptions' => ['class' => 'text-primary']
                    ]
                ])->textInput([
                    'placeholder' => $registerModel->getAttributeLabel('name'),
                ]) ?>

                <?= $form->field($registerModel, 'username', [
                    'feedbackIcon' => [
                        'prefix' => 'ace-icon fa fa-',
                        'default' => 'user',
                        'success' => 'check',
                        'error' => 'exclamation',
                        'defaultOptions' => ['class' => 'text-primary']
                    ]
                ])->textInput([
                    'placeholder' => $registerModel->getAttributeLabel('username'),
                ]) ?>

                <?= $form->field($registerModel, 'password', [
                    'feedbackIcon' => [
                        'prefix' => 'ace-icon fa fa-',
                        'default' => 'lock',
                        'success' => 'check',
                        'error' => 'exclamation',
                        'defaultOptions' => ['class' => 'text-primary']
                    ]
                ])->passwordInput([
                    'placeholder' => $registerModel->getAttributeLabel('password'),
                ]) ?>

                <?= $form->field($registerModel, 'confirm_password', [
                    'feedbackIcon' => [
                        'prefix' => 'ace-icon fa fa-',
                        'default' => 'retweet',
                        'success' => 'check',
                        'error' => 'exclamation',
                        'defaultOptions' => ['class' => 'text-primary']
                    ]
                ])->passwordInput([
                    'placeholder' => $registerModel->getAttributeLabel('confirm_password'),
                ]) ?>

                <div class="space-24"></div>

                <div class="clearfix">
                    <?= Html::resetButton('<i class="ace-icon fa fa-refresh"></i> <span class="bigger-110">Reset</span>', ['class' => 'btn btn-defaul width-30 pull-left', 'name' => 'reset-button']) ?>
                    <?= Html::submitButton('<span class="bigger-110">Register</span> <i class="ace-icon fa fa-arrow-right icon-on-right"></i>', ['class' => 'btn btn-success width-65 pull-right', 'name' => 'register-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="toolbar center">
            <a href="#" data-target="#login-box" class="back-to-login-link">
                <i class="ace-icon fa fa-arrow-left"></i>
                Back to login
            </a>
        </div>
    </div>
</div>

<?php $this->registerJs('
jQuery(function($) {
    $(document).on("click", ".toolbar a[data-target]", function(e) {
        e.preventDefault();
        var target = $(this).data("target");
        $(".widget-box.visible").removeClass("visible");
        $(target).addClass("visible");
    });
});

jQuery(function($) {
    $("#btn-login-dark").on("click", function(e) {
        $("body").attr("class", "login-layout");
        $("#id-text2").attr("class", "white");
        $("#id-company-text").attr("class", "blue");

        e.preventDefault();
    });
    $("#btn-login-light").on("click", function(e) {
        $("body").attr("class", "login-layout light-login");
        $("#id-text2").attr("class", "grey");
        $("#id-company-text").attr("class", "blue");

        e.preventDefault();
    });
    $("#btn-login-blur").on("click", function(e) {
        $("body").attr("class", "login-layout blur-login");
        $("#id-text2").attr("class", "white");
        $("#id-company-text").attr("class", "light-blue");

        e.preventDefault();
    });
});
'); ?>
