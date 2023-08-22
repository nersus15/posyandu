<?php
if (!isset($formid)) $formid = 'form-default';
?>
<form id="<?= $formid ?>" action="<?= base_url() ?>" method="post">
    <input type="hidden" name="role" value="<?= $role ?>">

    <div id="<?= 'modal-' . $formid ?>" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form <?= ucfirst($role) ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="">Username <span class="symbol-required"></span></label>
                                <input type="text" name="username" maxlength="46" required class="form-control" id="username">
                            </div>
                            <p class="text-danger" id="err-username"></p>
                            <div class="form-group">
                                <label for="">Password <span class="symbol-required"></span></label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" required id="password" name="password" aria-describedby="show-password">
                                    <div class="input-group-append">
                                        <span style="cursor: pointer;" class="input-group-text" id="show-password"><i class="fas fa-eye-slash"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Lengkap</label>
                                <input type="text" name="nama" maxlength="46" class="form-control" id="nama">
                            </div>
                            <div class="form-group">
                                <label for="">Puskesmas</label>
                                <input type="text" name="faskes" maxlength="46" class="form-control" id="faskes">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" maxlength="46" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label for="">Nomor Hp</label>
                                <input type="text" name="hp" maxlength="15" class="form-control" id="hp">
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</span></label>
                                <select name="alamat" id="alamat" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php foreach ($wilLengkap as $w) : ?>
                                        <option value="<?= $w['id'] ?>"><?= $w['nama'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Wilayah Kerja <span class="symbol-required"></span></label>
                                <select required name="wilker" id="wilker" class="form-control">
                                    <?php if($role == 'bidan'): ?>
                                    <option value="52.03.18.0000">Kecamatan Sakra Timur</option>
                                    <?php else: ?>
                                        <option value="52.03.18.2001">Desa Gelanggang</option>
                                    <?php endif ?>
                                    
                                </select>
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