jQuery(function($) {
    var m = {
        modalClass: '.modal',
        modalBody: '.modal-body',
        modalHeaderClass: '.modal-header-content',
        modalHeaderTitle: 'Window',
        pjaxContainer: '#app-pjax-container',
        modalDisplay: function(e) {
            var href = $(this).attr('href');

            $(m.modalHeaderClass).text(m.modalHeaderTitle);
            $(m.modalClass).modal('show').find(m.modalBody).load(href);

            return false;
        },
        modalClose: function(e) {
            $(m.modalClass).modal('hide');
        },
        modalSubmit: function(e) {
            var form = $(this);

            $.ajax({
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
            $.pjax.reload({ container: m.pjaxContainer });
        },
    };

    var f = {
        submit: function(e) {
            var form = $(this);

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
        },
    };

    $(document).on('click', '.btn-modal', m.modalDisplay);
    $(document).on('beforeSubmit', '#app-form', m.modalSubmit);
    $(document).on('beforeSubmit', '#signup-form', f.submit);
    $(document).on('beforeSubmit', '#login-form', f.submit);
});