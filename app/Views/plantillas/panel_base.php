<?php
// imprime http://localhost:8080/
 //dd(base_url(""));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $nombre_pagina ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/plugins/fontawesome-free/css/all.min.css");?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css");?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css");?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/plugins/jqvmap/jqvmap.min.css");?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/dist/css/adminlte.min.css");?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/plugins/overlayScrollbars/css/OverlayScrollbars.min.css");?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/plugins/daterangepicker/daterangepicker.css");?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/plugins/summernote/summernote-bs4.min.css");?>">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/plugins/toastr/toastr.css");?>">
  <link rel="stylesheet" href="<?php echo base_url("recursos_panel/plugins/toastr/toastr.min.css");?>">
  

  <!-- CSS ESPECIFICO DE LA VISTA -->
<?= $this->renderSection("CSS") ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo base_url("imagenes/uptlogo.png");?>" alt="LogoUPTx" height="300" width="300">
  </div>
  
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= route_to('administracion_dashboard') ?>" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <a
                    class="button"
                    href="<?= route_to('salir')?>"
                    ><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M13.033 2v-2l10 3v18l-10 3v-2h-9v-7h1v6h8v-18h-8v7h-1v-8h9zm1 20.656l8-2.4v-16.512l-8-2.4v21.312zm-3.947-10.656l-3.293-3.293.707-.707 4.5 4.5-4.5 4.5-.707-.707 3.293-3.293h-9.053v-1h9.053z"/></svg></a>
                
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class=""></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class=""></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class=""></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <!-- Notifications Dropdown Menu -->

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a  class="brand-link">
      <img src="<?php echo base_url("imagenes/logo.png");?>" alt="AdminLTE Logo" class="brand-image " style="opacity: .8">
      <span class="brand-text font-weight-light">8vo E</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url(RECURSOS_PANEL_IMG_PERFILES_USER.$imagen_user) ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $nombre_user ?></a>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <?= $menu_lateral ?>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
      <?= $breadcrumb_panel ?>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<!-- Contenido ESPECIFICO DE LA VISTA -->
<?= $this->renderSection("contenido") ?>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url("recursos_panel/plugins/jquery/jquery.min.js"); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url("recursos_panel/plugins/jquery-ui/jquery-ui.min.js"); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url("recursos_panel/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
<!-- ChartJS -->
<script src= "<?= base_url("recursos_panel/plugins/chart.js/Chart.min.js");?>"></script>
<!-- Sparkline -->
<script src= "<?= base_url("recursos_panel/plugins/sparklines/sparkline.js");?>"></script>
<!-- JQVMap -->
<script src= "<?= base_url("recursos_panel/plugins/jqvmap/jquery.vmap.min.js");?>"></script>
<script src= "<?= base_url("recursos_panel/plugins/jqvmap/maps/jquery.vmap.usa.js");?>"></script>
<!-- jQuery Knob Chart -->
<script src= "<?= base_url("recursos_panel/plugins/jquery-knob/jquery.knob.min.js");?>"></script>
<!-- daterangepicker -->
<script src= "<?= base_url("recursos_panel/plugins/moment/moment.min.js");?>"></script>
<script src= "<?= base_url("recursos_panel/plugins/daterangepicker/daterangepicker.js");?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src= "<?= base_url("recursos_panel/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js");?>"></script>
<!-- Summernote -->
<script src= "<?= base_url("recursos_panel/plugins/summernote/summernote-bs4.min.js");?>"></script>
<!-- overlayScrollbars -->
<script src= "<?= base_url("recursos_panel/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js");?>"></script>
<!-- AdminLTE App -->
<script src= "<?= base_url("recursos_panel/dist/js/adminlte.js");?>"></script>
<!-- AdminLTE for demo purposes -->
<script src= "<?= base_url("recursos_panel/dist/js/demo.js");?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src= "<?= base_url("recursos_panel/dist/js/pages/dashboard.js");?>"></script>
<!-- Toastr -->
<script src= "<?= base_url("recursos_panel/plugins/toastr/toastr.min.js"); ?>"></script>

<!--mensaje -->
<script>
<?= mostrar_mensaje()?>

</script>

<!-- JS ESPECIFICO DE LA VISTA -->
<?= $this->renderSection("JS") ?>

</body>
</html>
