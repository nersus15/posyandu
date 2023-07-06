$(document).ready(function () {
    $('.btn-update-user').click(function (e) {
        e.preventDefault();
        var formid = $(this).data('formid');
        var username = $(this).data('username');
        var modalComp = $("#modal-" + formid);
        var form = $("#" + formid);
        form.append('<input type="hidden" name="username" value="' + username + '">');

        form.attr('action', basepath + 'user/set');
        modalComp.on('shown.bs.modal', async function () {
            // Load data Update
            $("#password").parent().parent().remove();
            var res = await $.get(basepath + '/ws/user/' + username).then(res => res);
            if(res == null) return;
            
            form.find('#alamat, #wilker').select2();
            modalComp.removeAttr('tabindex');
            function perikasUsername(username) {
                if (!username || username == res.username) return;
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


            form.find('#username').val(res.username).prop('readonly', true);
            form.find('#nama').val(res.nama_lengkap);
            form.find('#faskes').val(res.faskes);
            form.find('#email').val(res.email);
            form.find('#hp').val(res.hp);
            form.find('#alamat option[value="' + res.alamat + '"]').prop('selected', true).parent().trigger('change');
            form.find('#wilker option[value="' + res.wilayah_kerja + '"]').prop('selected', true).parent().trigger('change');
        });
        modalComp.on('hidden.bs.modal', function () {
            modalComp.off('shown.bs.modal');
        });
        modalComp.modal({ backdrop: 'static', keyboard: false }, 'show');
    });

    $(".btn-hapus-user").click(function(e){
        e.preventDefault();
        var username = $(this).data('username');
        var role = $(this).data('role');

        var yakin = confirm("Yakin ingin menghapus " + role + ' ' + username + ' ?');
        if(!yakin)
            return;

        location.href = $(this).attr('href') + username + '/' + role;
    });
});