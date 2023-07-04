function(e, dt, node, config) {
    var lansia = "<?= $lansia ?>";
    var formid = "<?= $formid ?>";
    var modalComp = $("#modal-" + formid);
    var form = $("#" + formid);
    form.attr('action', basepath + "kunjungan/lansia/save");
    form.append('<input type="hidden" value="' + lansia + '" name="lansia">');
    modalComp.modal('show');
}