<?php
$session = session();
$message = $session->getFlashdata('response');
$data = $session->getFlashdata('dataKunjungan');
if (!isset($mode)) $mode = 'baru';
if (empty($data)) {
    $data = [
        'id' => null,
        'tgl' => waktu(null, MYSQL_DATE_FORMAT),
        'gravida' => null,
        'bb' => null,
        'tb' => null,
        'lila' => null,
        'fundus' => null,
        'usia_hamil' => null,
        'ttd' => null,
        'hb' => null,
        'pemeriksa' => sessiondata('login', 'nama_lengkap')
    ];
}
if (isset($dataKunjungan) && !empty($dataKunjungan)) {
    $data = array_merge($data, $dataKunjungan);
}
?>

<div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title text-danger"><?= $message ?></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form action="<?= $mode == 'baru' ? base_url('kunjungan/bumil/save') : base_url('kunjungan/bumil/set/' . $data['id']) ?>" method="POST">
                <input type="hidden" name="ibu" value="<?= $ibu ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Tanggal Periksa <span class="symbol-required"></span></label>
                            <input type="text" name="tgl" value="<?= $data['tgl'] ?>" id="kunjungan" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Pemeriksa <span class="symbol-required"></span></label>
                            <input type="text" name="pemeriksa" required value="<?= $data['pemeriksa'] ?>" id="pemeriksa" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Usia Kehamilan (hari)</label>
                            <input type="number" name="usia_hamil" value="<?= $data['usia_hamil'] ?>" id="usia_hamil" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Hamil Ke</label>
                            <input type="number" name="gravida" value="<?= $data['gravida'] ?>" id="gravida" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Berat badan (Kg)</label>
                            <input type="number" name="bb" value="<?= $data['bb'] ?>" id="bb" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Tinggi Badan (cm)</label>
                            <input type="number" name="tb" value="<?= $data['tb'] ?>" id="tb" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Lingkar Lengan Atas (cm)</label>
                            <input type="number" name="lila" value="<?= $data['lila'] ?>" id="lila" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Tinggi Fundus (cm)</label>
                            <input type="number" name="fundus" value="<?= $data['fundus'] ?>" id="fundus" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">HB</label>
                            <input type="number" name="hb" value="<?= $data['hb'] ?>" id="hb" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">BJ</label>
                            <input type="text" name="ttd" value="<?= $data['ttd'] ?>" id="ttd" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">

        </div>
    </div>
    <!-- /.card -->
</div>

<script>
    $(document).ready(function() {
        var response = '<?= $message ?>';
        if (response == null || response == '')
            $("#umur").focus();

        var defData = <?= json_encode($data) ?>;

        $('.datemask').inputmask('yyyy-mm-dd', {
            'placeholder': 'yyyy-mm-dd'
        })
        $("input[name='ingat_ttl']").change(function() {
            var ingat = $(this).attr('id');
            if (ingat == 'ingat') {
                $("#ttl").parent().show();
                $("#umur").parent().hide();
                $("#umur").prop('required', false);
            } else if (ingat == 'tidak_ingat') {
                $("#ttl").parent().hide();
                $("#umur").parent().show();
                $("#ttl").prop('required', false);

            }
        });

        if (defData['pendidikan'])
            $("#pendidikan option[value='" + defData['pendidikan'] + "']").prop('selected', true).parent().trigger('change');

        if (defData['agama'])
            $("#agama option[value='" + defData['agama'] + "']").prop('selected', true).parent().trigger('change');

        $("input[name='ingat_ttl']:checked").trigger('change');
    });
</script>