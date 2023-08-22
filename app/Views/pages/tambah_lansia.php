<?php
$session = session();
$message = $session->getFlashdata('response');
$data = $session->getFlashdata('lansiaData');
if (!isset($mode)) $mode = 'baru';
if (empty($data)) {
    $data = [
        'nama' => null,
        'alamat' => null,
        'ttl' => null,
        'estimasi' => null,
        'nik' => null,
        'ingat_ttl' => '1',
        'umur' => null
    ];
}
if (isset($dataLansia) && !empty($dataLansia)) {
    $data = array_merge($data, $dataLansia);
    if ($data['estimasi'] == 1) {
        $data['ingat_ttl'] = 0;
        $ttl = date_create($data['ttl']);
        $sekarang = date_create();

        $umur = date_diff($sekarang, $ttl);
        $data['umur'] = $umur->y;
        $data['ttl'] = null;
    }
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
            <form action="<?= $mode == 'baru' ? base_url('lansia/save') : base_url('lansia/set/' . $data['id']) ?>" method="POST">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="nama">Nama <span class="symbol-required"></span></label>
                        <input value="<?= $data['nama'] ?>" type="text" required name="nama" id="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input value="<?= $data['nik'] ?>" minlength="16" maxlength="16" type="text" name="nik" id="nik" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="ttl">Ingat Tanggal lahir <span class="symbol-required"></span></label>
                        <div class="row ">
                            <div class="form-check ml-2">
                                <input id="ingat" value="1" class="form-check-input" type="radio" <?= $data['ingat_ttl'] == '1' ? 'checked' : '' ?> name="ingat_ttl">
                                <label for="ingat" class="form-check-label">Ingat</label>
                            </div>
                            <div class="form-check ml-2">
                                <input id="tidak_ingat" value="0" class="form-check-input" type="radio" <?= $data['ingat_ttl'] == '0' ? 'checked' : '' ?> name="ingat_ttl">
                                <label for="tidak_ingat" class="form-check-label">Tidak ingat</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ttl">Tanggal lahir <span class="symbol-required"></span></label>
                        <input type="text" value="<?= $data['ttl'] ?>" required name="ttl" id="ttl" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                    </div>
                    <div style="display: none;" class="form-group">
                        <label for="umur">Umur <span class="symbol-required"></span></label>
                        <input type="text" value="<?= $data['umur'] ?>" required name="umur" id="umur" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat <span class="symbol-required"></span></label>
                        <select required name="alamat" id="alamat" class="form-control">
                            <option value="52.03.18.2001">Desa Gelanggang</option>
                            
                        </select>
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

        $('#ttl').inputmask('yyyy-mm-dd', {
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
        // $("#alamat").select2();

        if (defData['pendidikan'])
            $("#pendidikan option[value='" + defData['pendidikan'] + "']").prop('selected', true).parent().trigger('change');

        if (defData['agama'])
            $("#agama option[value='" + defData['agama'] + "']").prop('selected', true).parent().trigger('change');

        $("input[name='ingat_ttl']:checked").trigger('change');
    });
</script>