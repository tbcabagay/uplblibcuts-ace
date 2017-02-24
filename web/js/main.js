var m = {
    modalClass: '.modal',
    modalBody: '.modal-body',
    modalHeaderClass: '.modal-header-content',
    modalHeaderTitle: 'Window',
    pjaxContainer: '#app-pjax-container',
    modalDisplay: function(e) {
        var href = jQuery(this).attr('href');

        jQuery(m.modalHeaderClass).text(m.modalHeaderTitle);
        jQuery(m.modalClass).modal('show').find(m.modalBody).load(href);

        return false;
    },
    modalClose: function(e) {
        jQuery(m.modalClass).modal('hide');
    },
    modalSubmit: function(e) {
        var form = jQuery(this);

        jQuery.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function(r) {
                m.modalClose();

                if (r.result == 'success') {
                    m.pjaxReload();
                }
            },
        });

        return false;
    },
    pjaxReload: function() {
        jQuery.pjax.reload({ container: m.pjaxContainer });
    },
};

var timeIn = {
    numberId: null,
    pcId: null,
    pcAjaxUrl: null,
    recentTabId: null,
    recentTabUrl: null,
    init: function(e) {
        timeIn.numberId = e.numberId;
        timeIn.pcId = e.pcId;
        timeIn.pcAjaxUrl = e.pcAjaxUrl;
        timeIn.recentTabId = e.recentTabId;
        timeIn.recentTabUrl = e.recentTabUrl;
        timeIn.populatePcData();
        timeIn.displayRecentTab();
        jQuery(document).on('beforeSubmit', '#time-in-rent-form', timeIn.submit);
    },
    displayRecentTab: function() {
        jQuery.ajax({
            type: 'get',
            url: timeIn.recentTabUrl,
            dataType: 'html',
            success: function(r) {
                jQuery(timeIn.recentTabId).html(r);
            },
        });
    },
    populatePcData: function() {
        jQuery.ajax({
            type: 'get',
            url: timeIn.pcAjaxUrl,
            dataType: 'json',
            success: function(r) {
                var pc = jQuery(timeIn.pcId);
                pc.empty();
                if (Object.keys(r.model).length) {
                    jQuery.each(r.model, function(v, k) {
                        pc.append(jQuery('<option></option>').attr('value', v).text(k));
                    });
                } else {
                    pc.append(jQuery('<option></option>').attr('value', '').text('- Select -'));
                }
            },
        });
    },
    submit: function(e) {
        var form = jQuery(this);

        jQuery.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function(r) {
                if (r.result == 'success') {
                    jQuery(timeIn.numberId).val('');
                    timeIn.displayRecentTab();
                    timeIn.populatePcData();
                } else {
                    location.reload(true);
                }
            },
        });

        return false;
    },
};

var timeOut = {
    numberId: null,
    init: function(e) {
        timeOut.numberId = e.numberId;
        jQuery(document).on('beforeSubmit', '#time-out-rent-form', timeOut.submit);
    },
    submit: function(e) {
        var form = jQuery(this);

        jQuery.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            success: function(r) {
                if (r.result == 'success') {
                    jQuery(timeOut.numberId).val('');
                    timeIn.displayRecentTab();
                    timeIn.populatePcData();
                } /*else {
                    location.reload(true);
                }*/
            },
        });

        return false;
    },
};

var f = {
    submit: function(e) {
        var form = jQuery(this);

        jQuery.ajax({
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
    },
};

var s = {
    pjaxContainer: '#app-pjax-container',
    vacate: function(e) {
        var button = jQuery(this);
        jQuery.ajax({
            url: button.data('value'),
            type: 'post',
            success: function(r) {
                if (r.result == 'success') {
                    s.pjaxReload();
                }
            },
        });
        return false;
    },
    changeTimeZone: function(e) {
        var link = jQuery(this);
        jQuery.ajax({
            url: link.attr('href'),
            type: 'post',
            success: function(r) {
                if (r.result == 'success') {
                    s.pjaxReload();
                }
            },
        });
        return false;
    },
    pjaxReload: function() {
        jQuery.pjax.reload({ container: s.pjaxContainer });
    },
};

function init() {
    jQuery(document).on('click', '.btn-modal', m.modalDisplay);
    jQuery(document).on('click', '.change-timezone', s.changeTimeZone);
    jQuery(document).on('click', '#vacate-pcs', s.vacate);
    jQuery(document).on('beforeSubmit', '#app-form', m.modalSubmit);
    jQuery(document).on('beforeSubmit', '#signup-form', f.submit);
    jQuery(document).on('beforeSubmit', '#login-form', f.submit);
}
jQuery(document).ready(init);
