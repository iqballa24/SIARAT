<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Archive LSP HCMI</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/style.css'); ?>">
</head>

<body class="hold-transition login-page bg-white">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 bg-login d-none d-lg-block">
                <div class="image-login">
                </div>
            </div>
            <div class="col-md-8 d-flex align-items-center">
                <div class="login-box mx-auto">
                    <div class="login-logo">
                        <a href="#"><b>Arsip</b> LSP HCMI</a>
                    </div>
                    <!-- /.login-logo -->
                    <div class="card">
                        <div class="card-body login-card-body">
                            <p class="login-box-msg">Sign in to start your session</p>
                            <?= form_error('username', '<div class="alert alert-warning" role="alert"><small class="text-white pl-3">', '</small></div>'); ?>
                            <form class="user" method="post" action="<?php echo site_url('admin/auth/login/'); ?>">
                                <div class="input-group mb-3">
                                    <input name="username" type="text" class="form-control" placeholder="Username" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input name="password" type="password" class="form-control" placeholder="Password" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- /.col -->
                                    <div class="col-12">
                                        <input type="submit" name="submit" value="Login" class="btn btn-login btn-user btn-block">
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>

                        </div>
                        <!-- /.login-card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
    <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
    <script src="<?= base_url('assets/dist/js/index.js'); ?>"></script>

</body>

</html>