<?php
$session = session();
$message = $session->getFlashdata('response');
$data = $session->getFlashdata('bumilData');
if(!isset($mode)) $mode = 'baru';
if(empty($data)){
    $data = [
        'nama' => null,
        'suami' => null,
        'ingat_ttl' => '1',
        'ttl' => null,
        'domisili' => null,
        'alamat' => null,
        'umur' => null,
        'pendidikan' => 'tidak sekolah',
        'pekerjaan' => null,
        'agama' => null,
    ];
}
if(isset($dataBumil) && !empty($dataBumil)){
    $data = array_merge($data, $dataBumil);
    if($data['ttl_estimasi'] == 1){
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
            <form action="<?= $mode == 'baru' ? base_url('bumil/add') : base_url('bumil/set/' . $data['id']) ?>" method="POST">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Ibu <span class="symbol-required"></span></label>
                            <input value="<?= $data['nama'] ?>" type="text" required name="nama" id="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nama-suami">Nama Suami <span class="symbol-required"></span></label>
                            <input value="<?= $data['suami'] ?>" type="text" required name="suami" id="nama-suami" class="form-control">
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
                            <label for="domisili">Alamat Domisili <span class="symbol-required"></span></label>
                            <input type="text" value="<?= $data['domisili'] ?>" required name="domisili" id="domisili" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat <span class="symbol-required"></span></label>
                            <input type="text" value="<?= $data['alamat'] ?>" required name="alamat" id="alamat" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="nama">Pendidikan</label>
                            <select name="pendidikan" id="pendidikan" class="form-control">
                                <option value="-">Tidak sekolah</option>
                                <option value="TK">PAUD</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="D1">D1</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input value="<?= $data['pekerjaan'] ?>" type="text" name="pekerjaan" id="pekerjaan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nama">Agama</label>
                            <select name="agama" id="agama" class="form-control">
                                <option value="islam">Islam</option>
                                <option value="hindu">Hindu</option>
                                <option value="buda">Buda</option>
                                <option value="kristen protestan">Kristen Protestan</option>
                                <option value="kristen katolik">Kristen Katolik</option>
                                <option value="konghucu">Konghucu</option>
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
        if(response == null || response == '')
            $("#umur").focus();

        var defData = <?= json_encode($data) ?>;

        $('#ttl').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
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

        if(defData['pendidikan'])
            $("#pendidikan option[value='" + defData['pendidikan'] + "']").prop('selected', true).parent().trigger('change');

        if(defData['agama'])
            $("#agama option[value='" + defData['agama'] + "']").prop('selected', true).parent().trigger('change');

        $("input[name='ingat_ttl']:checked").trigger('change');
    });
</script>