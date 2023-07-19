<?php
$session = session();
$message = $session->getFlashdata('response');
$data = $session->getFlashdata('dataKunjungan');
if (!isset($mode)) $mode = 'baru';
if (empty($data)) {
    $data = [
        'id' => null,
        'tgl' =>  waktu(null, MYSQL_DATE_FORMAT),
        'gravida' =>  1,
        'paritas' =>  0,
        'abortus' =>  0,
        'hidup' =>  0,
        'hpht' =>  null,
        'hpl' =>  null,
        'sebelum' =>  null,
        'bb' =>  null,
        'tb' =>  null,
        'buku_kia' =>  0,
        'komplikasi' =>  null,
        'penyakit' =>  null,
        'tgl_persalinan' =>  null,
        'penolong' =>  null,
        'pendamping' =>  null,
        'tempat' =>  null,
        'transport' =>  null,
        'donor' =>  null,
        'kunjungan' =>  null,
        'kondisi_rumah' =>  null,
        'persediaan' =>  null,
        'posyandu' =>  null,
        'dukun' => null,
        'pemeriksa' => null
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
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama Pemeriksa <span class="symbol-required"></span></label>
                            <input type="text" name="pemeriksa" required value="<?= $data['pemeriksa'] ?>" id="pemeriksa" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Posyandu</label>
                            <input type="text" name="posyandu" value="<?= $data['posyandu'] ?>" id="posyandu" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Dukun</label>
                            <input type="text" name="dukun" value="<?= $data['dukun'] ?>" id="dukun" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <h4 class="col-12">Riwayat Obstetrik</h4>
                        <div class="form-group">
                            <label for="">Gravida</label>
                            <input type="number" name="gravida" value="<?= $data['gravida'] ?>" id="gravida" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Partus</label>
                            <input type="number" name="paritas" value="<?= $data['paritas'] ?>" id="paritas" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Abortus</label>
                            <input type="number" name="abortus" value="<?= $data['abortus'] ?>" id="abortus" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Anak Hidup</label>
                            <input type="number" name="hidup" value="<?= $data['hidup'] ?>" id="hidup" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <h4 class="col-12">Pemeriksaan Bidan</h4>
                        <div class="form-group">
                            <label for="kunjungan">Tanggal Periksa</label>
                            <input type="text" name="tgl" value="<?= $data['tgl'] ?>" id="kunjungan" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                        </div>
                        <div class="form-group">
                            <label for="hpht">Tanggal HPHT</label>
                            <input type="text" name="hpht" value="<?= $data['hpht'] ?>" id="hpht" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                        </div>
                        <div class="form-group">
                            <label for="hpl">Taksiran Persalinan</label>
                            <input type="text" name="hpl" value="<?= $data['hpl'] ?>" id="hpl" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                        </div>
                        <div class="form-group">
                            <label for="sebelum">Persalinan Sebelumnya</label>
                            <input type="text" name="sebelum" value="<?= $data['sebelum'] ?>" id="sebelum" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                        </div>
                        <div class="form-group">
                            <label for="bb">BB Sebelum Hamil (dalam Kg)</label>
                            <input type="number" value="<?= $data['bb'] ?>" name="bb" id="bb" class="form-control" min="10">
                        </div>
                        <div class="form-group">
                            <label for="tb">Tinggi Badan (dalam cm)</label>
                            <input type="number" value="<?= $data['tb'] ?>" name="tb" id="tb" class="form-control" min="10">
                        </div>
                        <div class="form-group">
                            <label for="bb">Buku KIA</label>
                            <select name="buku_kia" id="buku-kia" class="form-control">
                                <option value="1" <?= $data['buku_kia'] == 1 ? 'selected' : '' ?>>Memiliki</option>
                                <option value="0" <?= $data['buku_kia'] == 0 ? 'selected' : '' ?>>Tidak Memiliki</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="komplikasi">Riwayat komplikasi kebidanan</label>
                            <input type="text" name="komplikasi" value="<?= $data['komplikasi'] ?>" id="komplikasi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="penyakit">Penyakit kronis dan alergi</label>
                            <input type="text" name="penyakit" value="<?= $data['penyakit'] ?>" id="penyakit" class="form-control">
                        </div>
                        <h4>Rencan Persalinan</h4>
                        <div class="form-group">
                            <label for="tgl_persalinan">Tanggal</label>
                            <input type="text" name="tgl_persalinan" value="<?= $data['tgl_persalinan'] ?>" id="tgl_persalinan" class="form-control datemask" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask>
                        </div>
                        <div class="form-group">
                            <label for="penolong">Rencana penolong</label>
                            <select name="penolong" id="penolong" class="form-control">
                                <option value="1" <?= $data['penolong'] == '1' ? 'selected' : '' ?>>Keluarga</option>
                                <option value="2" <?= $data['penolong'] == '2' ? 'selected' : '' ?>>Dukun</option>
                                <option value="3" <?= $data['penolong'] == '3' ? 'selected' : '' ?>>Bidan</option>
                                <option value="4" <?= $data['penolong'] == '4' ? 'selected' : '' ?>>dr. Umum</option>
                                <option value="5" <?= $data['penolong'] == '5' ? 'selected' : '' ?>>dr. Spesialis</option>
                                <option value="6" <?= $data['penolong'] == '6' ? 'selected' : '' ?>>Lain lain</option>
                                <option value="7" <?= $data['penolong'] == '7' ? 'selected' : '' ?>>Tidak ada</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tempat">Tempat</label>
                            <select name="tempat" id="tempat" class="form-control">
                                <option value="1" <?= $data['tempat'] == '1' ? 'selected' : '' ?>>Rumah</option>
                                <option value="2" <?= $data['tempat'] == '2' ? 'selected' : '' ?>>Poskesdes/Polindes</option>
                                <option value="3" <?= $data['tempat'] == '3' ? 'selected' : '' ?>>Pustu</option>
                                <option value="4" <?= $data['tempat'] == '4' ? 'selected' : '' ?>>Puskesmas</option>
                                <option value="5" <?= $data['tempat'] == '5' ? 'selected' : '' ?>>RB</option>
                                <option value="6" <?= $data['tempat'] == '6' ? 'selected' : '' ?>>RSIA</option>
                                <option value="7" <?= $data['tempat'] == '7' ? 'selected' : '' ?>>RS</option>
                                <option value="8" <?= $data['tempat'] == '8' ? 'selected' : '' ?>>RS Odha</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pendamping">Pendamping</label>
                            <select name="pendamping" id="pendamping" class="form-control">
                                <option value="1" <?= $data['pendamping'] == '1' ? 'selected' : '' ?>>Suami</option>
                                <option value="2" <?= $data['pendamping'] == '2' ? 'selected' : '' ?>>Keluarga</option>
                                <option value="3" <?= $data['pendamping'] == '3' ? 'selected' : '' ?>>Teman</option>
                                <option value="4" <?= $data['pendamping'] == '4' ? 'selected' : '' ?>>Tetangga</option>
                                <option value="5" <?= $data['pendamping'] == '5' ? 'selected' : '' ?>>Lain lain (Dukun)</option>
                                <option value="6" <?= $data['pendamping'] == '6' ? 'selected' : '' ?>>Tidak ada</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="transport">Transportasi</label>
                            <select name="transport" id="transport" class="form-control">
                                <option value="1" <?= $data['transport'] == '1' ? 'selected' : '' ?>>Sepeda motor</option>
                                <option value="2" <?= $data['transport'] == '2' ? 'selected' : '' ?>>Mobil</option>
                                <option value="3" <?= $data['transport'] == '3' ? 'selected' : '' ?>>Lain lain (Cidomo, becak, benhur, dll)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="donor">Pendonor</label>
                            <select name="donor" id="donor" class="form-control">
                                <option value="1" <?= $data['donor'] == '1' ? 'selected' : '' ?>>Suami</option>
                                <option value="2" <?= $data['donor'] == '2' ? 'selected' : '' ?>>Keluarga</option>
                                <option value="3" <?= $data['donor'] == '3' ? 'selected' : '' ?>>Teman</option>
                                <option value="4" <?= $data['donor'] == '4' ? 'selected' : '' ?>>Lain lain(Kader, Masyarakat, Polri, Satpam)</option>
                                <option value="5" <?= $data['donor'] == '5' ? 'selected' : '' ?>>Tidak ada</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Kunjugan Rumah</label>
                            <input type="text" name="kunjungan" value="<?= $data['kunjungan'] ?>" id="kunjungan-rumah" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Kondisi Rumah</label>
                            <input type="text" name="kondisi_rumah" value="<?= $data['kondisi_rumah'] ?>" id="kondisi-rumah" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Persediaan kain handuk, pakaian bayi bersih dan kering</label>
                            <input type="text" name="persediaan" value="<?= $data['persediaan'] ?>" id="persediaan" class="form-control">
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