$(document).ready(function(){
    $(".edit-kunjungan-lansia").click(function(){
        var ini = $(this);
        var bulan = ini.data('bulan');
        var tahun = ini.data('tahun');
        var lansia = ini.data('lansia');
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
        form.attr('action', basepath + (value ? ("kunjungan/lansia/set/" + kunjungan) : "kunjungan/lansia/save"))
        form.find('#berat').val(value);
        modal.modal('show');
    });
});