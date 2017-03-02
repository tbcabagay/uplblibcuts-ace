var cuts = cuts || {};
var store = store || {};
(function(cuts, store, $) {
    'use strict';

    var themeHandler = ['btn-login-dark', 'btn-login-light', 'btn-login-blur'];
    var themeOptions = {
        'btn-login-dark': ['login-layout', 'white', 'blue'],
        'btn-login-light': ['login-layout light-login', 'grey', 'blue'],
        'btn-login-blur': ['login-layout blur-login', 'white', 'light-blue'],
    };
    var themeKey = 'cuts-theme';
    var theme = undefined;

    var appModal = {
        class: 'modal',
        buttonClass: 'btn-modal',
        bodyClass: 'modal-body',
        headerClass: 'modal-header-content',
        headerTitle: 'Window',
    };

    cuts.initThemes = function() {
        $.each(themeHandler, function(index, value) {
            $('#' + value).on('click', function() {
                var opts = themeOptions[value];
                store.set(themeKey, opts);
                cuts.applyTheme();
                return false;
            });
        });
        cuts.applyTheme();
    };

    cuts.applyTheme = function() {
        if (!(theme = store.get(themeKey))) {
            return;
        }

        if (theme.length !== 3) {
            return;
        }
        $('body').attr('class', theme[0]);
        $('#id-text2').attr('class', theme[1]);
        $('#id-company-text').attr('class', [2]);
    };

    cuts.submitIndexForms = function(forms) {
        $.each(forms, function(index, value) {
            $(document).on('beforeSubmit', '#' + value, function(e) {
                var form = jQuery(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'post',
                    data: form.serialize(),
                    success: function(r) {
                        if (r.result == 'success') {
                            location.href = r.href;
                        }
                    },
                });
                return false;
            });
        });
    };

    cuts.handleIndexToolbars = function() {
        $(document).on('click', '.toolbar a[data-target]', function(e) {
            var target = $(this).data('target');
            $('.widget-box.visible').removeClass('visible');
            $(target).addClass('visible');
            return false;
        });
    };

    cuts.handleModalDisplay =  function() {
        $(document).on('click', '.' + appModal.buttonClass, function(e) {
            $('.' + appModal.headerClass).text('.' + appModal.headerTitle);
            $('.' + appModal.class).modal('show').find('.' + appModal.bodyClass).load($(this).attr('href'));
            return false;
        });
    };

    function init() {
        cuts.handleModalDisplay();
    }
    $(document).ready(init);
})(cuts, store, window.jQuery);
