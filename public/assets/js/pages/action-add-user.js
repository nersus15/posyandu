function(e, dt, node, config) {
    var formid = "<?= $formid ?>";
    var modalComp = $("#modal-" + formid);
    var form = $("#" + formid);
    form.attr('action', basepath + 'user/save');

    modalComp.on('shown.bs.modal', function () {
        modalComp.removeAttr('tabindex');
        function perikasUsername(username) {
            if (!username) return;
            $.get(basepath + '/ws/user/' + username, function (res) {
                if (res == null) {
                    form.find('#err-username').hide();
                    form.find('button[type="submit"]').prop('disabled', false);
                } else {
                    form.find('#err-username').html("Username '<b>" + username + "</b>' sudah digunakan").show();
                    form.find('button[type="submit"]').prop('disabled', true);
                }
            });
        }
        form.find("#username").keyup(function () {
            perikasUsername($(this).val());
        });

        form.find('#show-password').click(function () {
            var icon = $(this).find('i');
            var isHide = icon.hasClass('fa-eye-slash');

            if (isHide) {
                icon.removeClass('fa-eye-slash');
                icon.addClass('fa-eye');
                $("#password").attr('type', 'text')
            } else {
                icon.addClass('fa-eye-slash');
                icon.removeClass('fa-eye');
                $("#password").attr('type', 'password')
            }
        });
        setTimeout(function(){
            form.find('input[type != "hidden"]').val('');
        form.find('select option[value=""]').prop('selected', true).parent().trigger('change');
        form.find('#username').prop('readonly', false);
        }, 500);
    });
    modalComp.on('hidden.bs.modal', function () {
        modalComp.off('shown.bs.modal');
    });
    modalComp.modal({ backdrop: 'static', keyboard: false }, 'show');
}