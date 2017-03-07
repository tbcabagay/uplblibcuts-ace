var cuts = cuts || {};
var dashboard = dashboard || {};
var store = store || {};
(function(dashboard, cuts, store, $) {
    'use strict';

    var themeHandler = ['btn-login-dark', 'btn-login-light', 'btn-login-blur'];
    var themeOptions = {
        'btn-login-dark': ['login-layout', 'white', 'blue'],
        'btn-login-light': ['login-layout light-login', 'grey', 'blue'],
        'btn-login-blur': ['login-layout blur-login', 'white', 'light-blue'],
    };
    var themeKey = 'cuts-theme';
    var theme = null;

    var appModal = {
        class: 'modal',
        buttonClass: 'btn-modal',
        bodyClass: 'modal-body',
        headerClass: 'modal-header-content',
        headerTitle: 'Window',
    };

    var appFormId = 'app-form';
    var appPjaxId = 'app-pjax-container';

    var dashboardIn, dashboardOut, dashboardService = null;

    dashboard.init = function(data) {
        dashboardIn = data.in;
        dashboardOut = data.out;
        dashboardService = data.service;
        dashboard.handleInForm();
        dashboard.handleOutForm();
        dashboard.handleServiceForm();
        dashboard.populatePcData();
        dashboard.handleRecentTab();
        dashboard.handleSaleChart();
        dashboard.handleServiceChart();
        setInterval(function() {
            dashboard.handleRecentTab();
        }, 5000);
    };

    dashboard.handleSaleChart = function() {
        $.get(
            dashboardService.saleChartUrl,
            function(r) {
                $(document).find('#' + dashboardService.saleChartId).html(r);
            },
            'html'
        );
    };

    dashboard.handleServiceChart = function() {
        $.get(
            dashboardService.serviceChartUrl,
            function(r) {
                $(document).find('#' + dashboardService.serviceChartId).html(r);
            },
            'html'
        );
    };

    dashboard.handleInForm = function() {
        if (dashboardIn == null) {
            return;
        }
        $('input:radio[name="' + dashboardIn.serviceName + '"]:first').attr('checked', true);
        $(document).on('beforeSubmit', '#' + dashboardIn.formId, function(e) {
            var form = $(this);
            $.post(
                form.attr('action'),
                form.serialize(),
                function(r) {
                    if (r.result == 'success') {
                        $('#' + dashboardIn.studentId).val('');
                        dashboard.populatePcData();
                        dashboard.handleRecentTab();
                    }
                },
                'json'
            );
            return false;
        });
    };

    dashboard.handleOutForm = function() {
        if (dashboardOut == null) {
            return;
        }
        $(document).on('beforeSubmit', '#' + dashboardOut.formId, function(e) {
            var form = $(this);
            $.post(
                form.attr('action'),
                form.serialize(),
                function(r) {
                    if (r.result == 'success') {
                        $('#' + dashboardOut.studentId).val('');
                        dashboard.populatePcData();
                        dashboard.handleRecentTab();
                        dashboard.handleServiceChart();
                    }
                },
                'json'
            );
            return false;
        });
    };

    dashboard.handleServiceForm = function() {
        if (dashboardService == null) {
            return;
        }
        $('input:radio[name="' + dashboardService.serviceName + '"]:first').attr('checked', true);
        $(document).on('beforeSubmit', '#' + dashboardService.formId, function(e) {
            var form = $(this);
            $.post(
                form.attr('action'),
                form.serialize(),
                function(r) {
                    if (r.result == 'success') {
                        $('#' + dashboardService.studentId).val('');
                        $('#' + dashboardService.quantityId).val(1);
                        dashboard.handleSaleChart();
                    }
                },
                'json'
            );
            return false;
        });
    };

    dashboard.handleRecentTab = function() {
        $.get(
            dashboardIn.recentTabUrl,
            function(r) {
                $(document).find('#' + dashboardIn.recentTabId).html(r);
            },
            'html'
        );
    };

    dashboard.populatePcData = function() {
        $.get(
            dashboardIn.pcUrl,
            function(r) {
                var pc = $('#' + dashboardIn.pcId);
                pc.empty();
                if (Object.keys(r.model).length) {
                    $.each(r.model, function(v, k) {
                        pc.append($('<option></option>').attr('value', v).text(k));
                    });
                } else {
                    pc.append($('<option></option>').attr('value', '').text('- Select -'));
                }
            },
            'json'
        );
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

    cuts.handleModalClose = function() {
        $(document).find('.' + appModal.class).modal('hide');
    };

    cuts.handlePjaxReload = function() {
        if ($('#' + appPjaxId).length) {
            $.pjax.reload({
                container: '#' + appPjaxId,
            });
        }
    };

    cuts.handleModalForm = function() {
        $(document).on('beforeSubmit', '#' + appFormId, function() {
            var form = jQuery(this);
            jQuery.ajax({
                url: form.attr('action'),
                type: 'post',
                data: form.serialize(),
                success: function(r) {
                    cuts.handleModalClose();
                    if (r.result == 'success') {
                        cuts.handlePjaxReload();
                    }
                },
            });

            return false;
        });
    };

    cuts.handleTimeZone = function() {
        $(document).on('click', '.change-timezone', function(e) {
            var link = jQuery(this);
            $.post(
                link.attr('href'),
                function(r) {
                    if (r.result == 'success') {
                        cuts.handlePjaxReload();
                    }
                }
            );
            return false;
        });
    };

    function init() {
        cuts.handleModalDisplay();
        cuts.handleModalForm();
        cuts.handleTimeZone();
    }
    $(document).ready(init);
})(dashboard, cuts, store, window.jQuery);
