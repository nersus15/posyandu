<?php
$session = session();
$message = $session->getFlashdata('response');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="<?= assets_url("vendor/login/images/icons/favicon.ico") ?>" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/vendor/bootstrap/css/bootstrap.min.css") ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css") ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css") ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/vendor/animate/animate.css") ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/vendor/css-hamburgers/hamburgers.min.css") ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/vendor/animsition/css/animsition.min.css") ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/vendor/select2/select2.min.css") ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/vendor/daterangepicker/daterangepicker.css") ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/css/util.css") ?>">
    <link rel="stylesheet" type="text/css" href="<?= assets_url("vendor/login/css/main.css") ?>">
    <!--===============================================================================================-->
</head>

<body style="background-color: #666666;">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form method="POST" action="<?= base_url($mode == 'token' ? 'ws/user/sendtoken' : 'ws/user/reset') ?>" class="login100-form validate-form">
                    <?php if ($mode == 'token') : ?>
                        <span class="login100-form-title p-b-43">
                            Masukkan Email Anda Untuk Reset Password
                        </span>

                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input required class="input100" type="email" name="email">
                            <span class="focus-input100"></span>
                            <span class="label-input100">Email</span>
                        </div>
                    <?php else : ?>
                        <?php if ($valid === true) : ?>
                            <input type="hidden" name="token" value="<?= $token ?>" />
                            <div class="wrap-input100 validate-input" data-validate="Password is required">
                                <input minlength="8" required class="input100" type="password" name="password">
                                <span class="focus-input100"></span>
                                <span class="label-input100">Password <span class="symbol-required"></span></span>
                            </div>
                            <div class="wrap-input100 validate-input" data-validate="Password is required">
                                <input minlength="8" required class="input100" type="password" name="repassword">
                                <span class="focus-input100"></span>
                                <span class="label-input100">Masukkan Password Lagi <span class="symbol-required"></span></span>
                            </div>
                        <?php else : ?>
                            <div class="container-login100-form-btn">
                                <h1 class="text-info"><?= $valid ?></h1>
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                    <br>
                    <?php if ($mode == 'token' || ($mode == 'reset' && $valid === true)) : ?>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                <?= $mode == 'token' ? 'Send Email' : 'Reset Password' ?>
                            </button>
                        </div>
                    <?php endif ?>
                    <p class="text-danger"><?= $message ?></p>

                </form>
                <div class="login100-more" style="background-image: url('<?= assets_url('img/background/bg-login.jpg') ?>');">
                </div>
            </div>
        </div>
    </div>





    <!--===============================================================================================-->
    <script src="<?= assets_url("vendor/login/vendor/jquery/jquery-3.2.1.min.js") ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= assets_url("vendor/login/vendor/animsition/js/animsition.min.js") ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= assets_url("vendor/login/vendor/bootstrap/js/popper.js") ?>"></script>
    <script src="<?= assets_url("vendor/login/vendor/bootstrap/js/bootstrap.min.js") ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= assets_url("vendor/login/vendor/select2/select2.min.js") ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= assets_url("vendor/login/vendor/daterangepicker/moment.min.js") ?>"></script>
    <script src="<?= assets_url("vendor/login/vendor/daterangepicker/daterangepicker.js") ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= assets_url("vendor/login/vendor/countdowntime/countdowntime.js") ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= assets_url("vendor/login/js/main.js") ?>"></script>

</body>

</html>