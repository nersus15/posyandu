<div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title"></h3>

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
            <form action="<?= base_url('bumil/add') ?>" method="POST">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Ibu <span class="symbol-required"></span></label>
                            <input type="text" required name="nama" id="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nama-suami">Nama Suami <span class="symbol-required"></span></label>
                            <input type="text" required name="suami" id="nama-suami" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ttl">Ingat Tanggal lahir <span class="symbol-required"></span></label>
                            <div class="row ">
                                <div class="form-check ml-2">
                                    <input id="ingat" value="1" class="form-check-input" type="radio" checked name="ingat_ttl">
                                    <label for="ingat" class="form-check-label">Ingat</label>
                                </div>
                                <div class="form-check ml-2">
                                    <input id="tidak_ingat" value="0" class="form-check-input" type="radio" name="ingat_ttl">
                                    <label for="tidak_ingat" class="form-check-label">Tidak ingat</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ttl">Tanggal lahir <span class="symbol-required"></span></label>
                            <input type="text" required name="ttl" id="ttl" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                        </div>
                        <div style="display: none;" class="form-group">
                            <label for="umur">Umur <span class="symbol-required"></span></label>
                            <input type="text" required name="umur" id="umur" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="domisili">Alamat Domisili <span class="symbol-required"></span></label>
                            <input type="text" required name="domisili" id="domisili" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat <span class="symbol-required"></span></label>
                            <input type="text" required name="alamat" id="alamat" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="nama">Pendidikan</label>
                            <select name="pendidikan" id="pendidikan" class="form-control">
                                <option value="tidak sekolah">Tidak sekolah</option>
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
                            <input type="text" name="pekerjaan" id="pekerjaan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nama">Agama</label>
                            <select name="agama" id="agama" class="form-control">
                                <option value="islam">Islam</option>
                                <option value="hindu">Hindu</option>
                                <option value="buda">Buda</option>
                                <option value="Kristen">kristen</option>
                                <option value="katolik">Katolik</option>
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
        $('#ttl').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
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
        $("input[name='ingat_ttl']").trigger('change');
    });
</script>