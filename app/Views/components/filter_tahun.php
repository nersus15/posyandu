<?php  
    if(!isset($tahunTerpilih ))
        $tahunTerpilih = date('Y');
?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><b>Filter</b></h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group">
                    <label for="">Tahun</label>
                    <select class="form-control" name="filter_tahun" id="filter-tahun">
                        <?php for ($i = date('Y'); $i >= date('Y') - 10; $i--) : ?>
                            <option <?= $i == $tahunTerpilih ? 'selected' : '' ?> value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var tahunTerpilih = <?= $tahunTerpilih ?>;
        var lansia = "<?= $lansia?>";
        $("#filter-tahun").change(function(){
            location.href = basepath + 'lansia/kunjungan/' + lansia + '/' + $(this).val(); 
        });
    });
</script>