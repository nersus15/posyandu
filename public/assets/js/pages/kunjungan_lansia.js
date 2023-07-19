$(document).ready(function(){
    $(".edit-kunjungan-lansia").click(function(){
        var ini = $(this);
        var bulan = ini.data('bulan');
        var tahun = ini.data('tahun');
        var lansia = ini.data('lansia');
        var pemeriksa = ini.data('pemeriksa');
        var value = ini.data('value');
        var formid = 'form-pemeriksaan-lansia';
        var form = $("#" + formid);
        var modal = $('#modal-' + formid);
        var kunjungan = ini.data('kunjungan');

        console.log(bulan, tahun, lansia);
        form.append('<input type="hidden" name="bulan_act" value="'+ bulan +'">')
        form.append('<input type="hidden" name="tahun_act" value="'+ tahun +'">')
        form.find('#bulan option[value="'+ parseInt(bulan) +'"]').prop('selected', true).parent().trigger('change').prop('disabled', true);
        form.find('#tahun option[value="'+ parseInt(tahun) +'"]').prop('selected', true).parent().trigger('change').prop('disabled', true);
        form.append('<input type="hidden" value="' + lansia + '" name="lansia">');
        form.find('#pemeriksa').val(pemeriksa);
        form.attr('action', basepath + (value ? ("kunjungan/lansia/set/" + kunjungan) : "kunjungan/lansia/save"))
        form.find('#berat').val(value);
        modal.modal('show');
    });
    $(".btn-hapus-lansia").click(function(e){
        e.preventDefault();
        var yakin = confirm("Yakin ingin menghapus data ini ?");
        if(!yakin) return;
        
        location.href =  $(this).attr("href")
    });
    $(".hapus-kunjungan-lansia").click(function(){
        var ini = $(this);
        var kunjungan = ini.data('kunjungan');
        var yakin = confirm("Yakin Ingin menghapus data ?");
        if(!yakin)
            return;

        $.post(basepath + 'kunjungan/lansia/delete', {'kunjungan': kunjungan}, function(res){
            if(res.type == 'error'){
                var card = $("#dt-lansia_wrapper").parents('.card');
                card.find('.card-title').text(res.message);
            }else{
                location.reload();
            }
        });
    });
});