<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LSP HCMI | Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">

  <!-- Custom styles for this page -->
  <link href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
  
  <!-- Page level plugins -->
  <script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap4.min.js'); ?>"></script>
  <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
  
</head>
<?php foreach ($data_setting as $data) : ?>
<body class="hold-transition sidebar-mini <?= $data['mode']; ?>-mode text-md" >
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
      <?php $this->load->view('admin/theme/alert');; ?>
      
      
      <!-- Main content -->
      <?php $this->load->view('admin/'.$theme_page);; ?>
      <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <!-- footer -->
    <?php $this->load->view('admin/theme/footer');; ?>

  </div>
  <!-- ./wrapper -->

  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/dist/js/demo.js'); ?>"></script>
  <!-- Js yang digunakan pada theme -->
  <script src="<?= base_url('assets/dist/js/index.js'); ?>"></script>

</body>
<?php endforeach ?>

</html>