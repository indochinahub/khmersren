<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/adminlte3/plugins/fontawesome-free/css/all.min.css">  
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/adminlte3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/adminlte3/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/adminlte3/dist/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/adminlte3/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/adminlte3/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?php echo base_url();?>"><b>Khmersren</b>.com</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?php echo base_url(["User","login"]);?>" method="post">
        <?php if(form_error('username')){ echo form_error('username');}?>
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username"
            <?php if($username){ echo "value='$username'"; } ?>
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <?php if(form_error('password')){ echo form_error('password');}?>
        <div class="input-group mb-3">
          <input type="password"  name="password" class="form-control" placeholder="Password"
            <?php if($password){ echo "value='$password'"; } ?>
          >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->


<!-- jQuery -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/jquery/jquery.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/jquery-ui/jquery-ui.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/bootstrap/js/bootstrap.bundle.js"></script>
<!-- ChartJS -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/chart.js/Chart.js"></script>
<!-- Sparkline -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/jqvmap/jquery.vmap.js"></script>
<script src="<?= base_url() ?>/assets/adminlte3/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/daterangepicker/daterangepicker.js"></script>

<!-- Summernote -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/summernote/summernote-bs4.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url() ?>/assets/adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>/assets/adminlte3/dist/js/adminlte.js"></script>

</body>
</html>
