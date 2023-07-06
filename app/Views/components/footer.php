<?php
if (isset($dataFooter) && is_array($dataFooter) && !empty($dataFooter)) extract($dataFooter);
$config = config('App');
$config = (array) $config;
$autoLogout = c_isset($config, 'autoLogout') ? $config['autoLogout'] : false;
if ($autoLogout === false)
    $autoLogout = 0;
elseif ($autoLogout === true)
    $autoLogout = (12 * 1000 * 60 * 60); // default 12 jam
else {
    $arrayOfChars = str_split($autoLogout);
    $jam = 0;
    $menit = 0;
    $detik = 0;
    $posisi = [];
    foreach (['s', 'h', 'm'] as $str) {
        $posisi[$str] = strpos($autoLogout, $str);
    }
    asort($posisi);
    $prevPos = 0;
    foreach ($posisi as $str => $p) {
        if ($p > 0) {
            $nilai = substr($autoLogout, 0, ($p - $prevPos));
            $autoLogout = substr($autoLogout, ($p - $prevPos) + 1, strlen($autoLogout));
            if ($str == 's') {
                $detik = $nilai;
            } elseif ($str == 'm')
                $menit = $nilai;
            elseif ($str == 'h')
                $jam = $nilai;
            $prevPos = $p + 1;
        }
    }

    $autoLogout = ($jam * 60 * 60) + (($menit * 60)) + ($detik);
}
?>
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<!-- Bootstrap 4 -->
<script src="<?= assets_url("vendor/adminlte/plugins/bootstrap/js/bootstrap") ?>.bundle.min.js"></script>
<!-- Plugin -->
<?php if (isset($extra_js)) : ?>
    <?php foreach ($extra_js as $js) : ?>
        <script src="<?= assets_url($js) ?>"></script>
    <?php endforeach ?>
<?php endif ?>
<!-- AdminLTE App -->
<script src="<?= assets_url("vendor/adminlte/dist/js/adminlte.min") ?>.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= assets_url("vendor/adminlte/dist/js/demo.js") ?>"></script>
<?php if ($autoLogout !== false && $autoLogout != 0) : ?>
    <script>
        $(document).ready(function() {
            var interval = null;
            var inActivityTreshold = <?= $autoLogout ?>;
            console.log("Batas waktu in active => " + inActivityTreshold + ' Detik');

            function resetLastActivity() {
                localStorage.setItem('posyandu_la', 0);
            }
            window.addEventListener('beforeunload', function(e) {
                resetLastActivity();
            });
            $(this).mousemove(function(e) {
                resetLastActivity();
            });
            $(this).keypress(function(e) {
                resetLastActivity();
            });

            // Cek last activity every second
            interval = setInterval(function() {
                var la = localStorage.getItem('posyandu_la');
                if (!la) la = 0;
                la = parseInt(la);

                la += 1;
                localStorage.setItem('posyandu_la', la);
                if (la > inActivityTreshold) {
                    clearInterval(interval);
                    location.href = basepath + 'ws/user/logout';
                }
            }, 1000);
        })
    </script>
<?php endif ?>
</body>

</html>