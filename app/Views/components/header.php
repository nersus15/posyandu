<?php
if (isset($dataHeader) && is_array($dataHeader) && !empty($dataHeader)) extract($dataHeader);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pelayanan Posyandu | <?= $title ?? 'App' ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= assets_url("vendor/adminlte/plugins/fontawesome-free/css/all.min.css") ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= assets_url("vendor/adminlte/dist/css/adminlte.min.css") ?>">

    <?php if (isset($extra_css)) :
        if (is_array($extra_css)) :
            foreach ($extra_css as $css) : ?>
                <link rel="stylesheet" href="<?= assets_url($css) ?>">
            <?php endforeach ?>
        <?php else : ?>
            <link rel="stylesheet" href="<?= assets_url($extra_css) ?>">
        <?php endif ?>
    <?php endif ?>

    <?php if (isset($extra_js)) : ?>
        <?php foreach ($extra_js as $js) : ?>
            <?php if ($js['pos'] == 'head') : ?>
                <script src="<?= assets_url($js) ?>"></script>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">