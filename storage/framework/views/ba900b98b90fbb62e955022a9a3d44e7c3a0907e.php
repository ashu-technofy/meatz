<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo e(url('/')); ?>/assets/admin/images/favicon.ico">

    <title><?php echo e(app_setting('title') ?? env('APP_NAME')); ?> | تسجيل دخول</title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/admin/vendor_components/bootstrap/dist/css/bootstrap.min.css">

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/admin/vendor_components/bootstrap/dist/css/bootstrap-extend.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/admin/vendor_components/font-awesome/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/admin/vendor_components/Ionicons/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/admin/css/master_style.css">

    <!-- bonitoadmin Skins. Choose a skin from the css/skins
	   folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo e(url('/')); ?>/assets/admin/css/skins/_all-skins.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Cairo';
        }

        input {
            padding-left: 30px !important;
        }

        input,
        button,
        span {
            font-size: 15px !important;
        }
        
        [type="checkbox"]:checked + label::before {
            top: -15px;
            right: -5px;
            width: 12px;
            height: 22px;
            border-top: 2px solid transparent;
            border-right: 2px solid transparent;
            border-left: 2px solid #2cabe3;
            border-bottom: 2px solid #2cabe3;
            -webkit-transform: rotate(300deg);
            -ms-transform: rotate(300deg);
            transform: rotate(300deg);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transform-origin: 100% 100%;
            -ms-transform-origin: 100% 100%;
            transform-origin: 100% 100%;
        }
    </style>

</head>

<body class="hold-transition login-page"
    style="background-color:#000; background-image: url('<?php echo e(url('assets/admin/images/login-register.jpg')); ?>')">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?php echo e(url('/')); ?>/assets/admin/index.html">
                <b style="
                color: #555;
                font-size: 50px;
                font-weight: bold;
            "><?php echo e(app_setting('title') ?? env('APP_NAME')); ?> </b>
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">تسجيل الدخول</p>
            <?php if(session()->has('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>
            <form method="post" class="form-element">
                <?php echo csrf_field(); ?>
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="البريد الإلكترونى" name="email" required>
                    <span class="ion ion-email form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" required placeholder="كلمة المرور">
                    <span class="ion ion-locked form-control-feedback"></span>
                </div>
                <div class="row" style="direction: rtl;">
                    <div class="col-6">
                        <div class="checkbox">
                            <input name="remember" value="1" type="checkbox" id="basic_checkbox_1">
                            <label for="basic_checkbox_1">تذكرنى</label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-info btn-block btn-flat margin-top-10">تسجيل
                            الدخول</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->


    <!-- jQuery 3 -->
    <script src="<?php echo e(url('/')); ?>/assets/admin/vendor_components/jquery/dist/jquery.min.js"></script>

    <!-- popper -->
    <script src="<?php echo e(url('/')); ?>/assets/admin/vendor_components/popper/dist/popper.min.js"></script>

    <!-- Bootstrap 4.0-->
    <script src="<?php echo e(url('/')); ?>/assets/admin/vendor_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html><?php /**PATH /var/www/html/meatz/Modules/User/Views/auth/login.blade.php ENDPATH**/ ?>