<?php
$tahunIni = date('Y');
$daftarBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
if(!isset($formid)) $formid = 'form-default';
?>
<form id="<?= $formid ?>" action="<?= base_url() ?>" method="post">
    <div id="<?= 'modal-' . $formid ?>" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Pemeriksaan Lansia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="">Pilih Tahun</label>
                                <select name="tahun" id="tahun" class="form-control">
                                    <?php for ($t = $tahunIni; $t >= intval($tahunIni - 10); $t--) : ?>
                                        <option value="<?= $t ?>"><?= $t ?></option>
                                    <?php endfor ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="">Pilih Bulan</label>
                                <select name="bulan" id="bulan" class="form-control">
                                    <?php foreach ($daftarBulan as $k => $v) : ?>
                                        <option value="<?= ($k + 1) ?>"><?= $v ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Hasil penimbangan (dalam Kg) <span class="symbol-required"></span></label>
                                <input type="number" name="berat" min="0" required id="berat" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>