<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Widgets</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/backend/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/backend/dist/css/adminlte.min.css'); ?>">

  <!-- Custom styles for this page -->
  <link href="<?= base_url('assets/backend/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
  
  <!-- Page level plugins -->
  <script src="<?= base_url('assets/backend/plugins/jquery/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/backend/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
  <script src="<?= base_url('assets/backend/vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script>
  <script src="<?= base_url('assets/backend/vendor/sweetalert/sweetalert2.all.min.js'); ?>"></script>
  
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Load Navbar -->
   <?php $this->load->view('admin/theme/navbar');; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
   <?php $this->load->view('admin/theme/sidebar');; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1><?= $judul; ?></h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Alert -->
      <div class="flash-data" data-tempdata="<?= $this->session->tempdata('message') ?>"></div>
      <div class="flash-data-info" data-tempdata="<?= $this->session->tempdata('info') ?>"></div>
      <div class="flash-data-error" data-tempdata="<?= $this->session->tempdata('error') ?>"></div>
      
      <!-- Main content -->
      <?php $this->load->view('admin/'.$theme_page);; ?>
      <!-- /.content -->

      <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
        <i class="fas fa-chevron-up"></i>
      </a>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer text-center">
      <strong>Copyright &copy; 2021 <a href="https://lsphcmi.com">LSP HCMI</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/backend/dist/js/adminlte.min.js'); ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/backend/dist/js/demo.js'); ?>"></script>

  <!-- Js yang digunakan pada theme -->
  <script src="<?= base_url('assets/backend/js/sb-admin-2.min.js'); ?>"></script>
  <script src="<?= base_url('assets/backend/js/index.js'); ?>"></script>

</body>

</html>