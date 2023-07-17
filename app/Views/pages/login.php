<?php
$session = session();
$message = $session->getFlashdata('loginMessage');
$data = $session->getFlashdata('loginData');
if(empty($data))
    $data = ['username' => null, 'password' => null];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
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
                <form method="POST" action="<?= base_url('ws/user/login') ?>" class="login100-form validate-form">
                    <span class="login100-form-title p-b-43">
                        Login untuk melanjutkan
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input value="<?= $data['username'] ?>" required class="input100" type="text" name="user">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Username atau Email</span>
                    </div>


                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input value="<?= $data['password'] ?>" required class="input100" type="password" name="password">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>

                    <!-- <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div>
                            <a href="#" class="txt1">
                                Forgot Password?
                            </a>
                        </div>
                    </div> -->

                    <br>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>
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