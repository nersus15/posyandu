<?php
$session = session();
$message = $session->getFlashdata('response');
$data = $session->getFlashdata('anakData');
if (!isset($mode)) $mode = 'baru';
if (empty($data)) {
    $data = [
        'nama' => null,
        'alamat' => null,
        'ttl' => null,
        'estimasi' => null,
        'ingat_ttl' => '1',
        'umur' => null,
        'kelamin' => null,
        'bbl' => null,
        'ibu' => null,
        'ayah' => null,
        'akb' => null,
    ];
}
if (isset($dataAnak) && !empty($dataAnak)) {
    $data = array_merge($data, $dataAnak);
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
            <form action="<?= $mode == 'baru' ? base_url('anak/daftar') : base_url('anak/set/') ?>" method="POST">
                <input type="hidden" name="id" value="<?= $data['id'] ?? null ?>">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="nama">Nama <span class="symbol-required"></span></label>
                        <input value="<?= $data['nama'] ?>" type="text" required name="nama" id="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nik">Kelamin</label>
                        <select name="kelamin" id="kelamin" class="form-control">
                            <option value="L" <?= $data['kelamin'] == 'L' ? 'selected' : null ?>>Laki laki</option>
                            <option value="P" <?= $data['kelamin'] == 'P' ? 'selected' : null ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Berat Badan Saat Lahir (dalam gram)</label>
                        <input type="number" value="<?= $data['bbl'] ?>" name="bbl" id="bbl" class="form-control">
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
                        <label for="umur">Umur (dalam bulan) <span class="symbol-required"></span></label>
                        <input type="text" value="<?= $data['umur'] ?>" required name="umur" id="umur" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Ibu <span class="symbol-required"></span></label>
                        <input type="text" id="ibu" required maxlength="46" name="ibu" value="<?= $data['ibu'] ?>" class="form-control ibu">
                    </div>
                    <div class="form-group">
                        <label for="">Nama Ayah</label>
                        <input type="text" id="ayah" maxlength="46" name="ayah" value="<?= $data['ayah'] ?>" class="form-control ayah">
                    </div>
                    <div class="form-group">
                        <label for="">AKB</label>
                        <input type="number" value="<?= $data['akb'] ?>" name="akb" id="akb" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat <span class="symbol-required"></span></label>
                        <select required name="alamat" id="alamat" class="form-control">
                            <option value="52.03.18.2001" selected>Desa Gelanggang</option>
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