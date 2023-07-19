$(document).ready(function(){
    $(".btn-hapus-anak").click(function(e){
        e.preventDefault();
        var yakin = confirm("Yakin ingin menghapus data ini ?");
        if(!yakin) return;

        location.href =  $(this).attr("href")
    });
    $(".edit-kunjungan-anak").click(function(){
        var ini = $(this);
        var bulan = ini.data('bulan');
        var tahun = ini.data('tahun');
        var anak = ini.data('anak');
        var value = ini.data('value');
        var formid = 'form-pemeriksaan-anak';
        var form = $("#" + formid);
        var modal = $('#modal-' + formid);
        var kunjungan = ini.data('kunjungan');
        var berat = value ? value.split('/')[0] : null;
        var tinggi = value ? value.split('/')[1] : null;
        var pemeriksa = ini.data('pemeriksa');

        console.log(bulan, tahun, anak);
        form.append('<input type="hidden" name="bulan_act" value="'+ bulan +'">')
        form.append('<input type="hidden" name="tahun_act" value="'+ tahun +'">')
        form.find('#bulan option[value="'+ parseInt(bulan) +'"]').prop('selected', true).parent().trigger('change').prop('disabled', true);
        form.find('#tahun option[value="'+ parseInt(tahun) +'"]').prop('selected', true).parent().trigger('change').prop('disabled', true);
        form.append('<input type="hidden" value="' + anak + '" name="anak">');
        form.attr('action', basepath + (value ? ("kunjungan/anak/set/" + kunjungan) : "kunjungan/anak/save"))
        form.find('#berat').val(berat);
        form.find('#tinggi').val(tinggi);
        form.find('#pemeriksa').val(pemeriksa);
        modal.modal('show');
    });
    $(".hapus-kunjungan-anak").click(function(){
        var ini = $(this);
        var kunjungan = ini.data('kunjungan');
        var yakin = confirm("Yakin Ingin menghapus data ?");
        if(!yakin)
            return;

        $.post(basepath + 'kunjungan/anak/delete', {'kunjungan': kunjungan}, function(res){
            if(res.type == 'error'){
                var card = $("#dt-anak_wrapper").parents('.card');
                card.find('.card-title').text(res.message);
            }else{
                location.reload();
            }
        });
    });
});