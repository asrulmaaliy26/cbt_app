<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<!-- Meta Tags 
<meta name="description" content="<?//=(empty(konfigurasi_get('meta_description')['konfigurasi_value']))?konfigurasi_get('meta_description')['konfigurasi_default']:konfigurasi_get('meta_description')['konfigurasi_value'];?>">
<meta name="keyword" content="<?//=(empty(konfigurasi_get('meta_keyword')['konfigurasi_value']))?konfigurasi_get('meta_keyword')['konfigurasi_default']:konfigurasi_get('meta_keyword')['konfigurasi_value'];?>">
-->

<!-- Page Title 
<title><?//=(empty(konfigurasi_get('web_title')['konfigurasi_value']))?konfigurasi_get('web_title')['konfigurasi_default']:konfigurasi_get('web_title')['konfigurasi_value'];?> <?//=(empty(konfigurasi_get('tagline')['konfigurasi_value']))?" | ".konfigurasi_get('tagline')['konfigurasi_default']:" | ".konfigurasi_get('tagline')['konfigurasi_value'];?></title>
-->
<title>Akademik V2</title>
<!-- Favicon and Touch Icons 
<link rel="shortcut icon" href="<?//=(empty(konfigurasi_get('favicon')['konfigurasi_value']))?base_url(konfigurasi_get('favicon')['konfigurasi_default']):base_url(konfigurasi_get('favicon')['konfigurasi_value']);?>" type="image/x-icon">
<link href="<?//=(empty(konfigurasi_get('favicon')['konfigurasi_value']))?base_url(konfigurasi_get('favicon')['konfigurasi_default']):base_url(konfigurasi_get('favicon')['konfigurasi_value']);?>" rel="apple-touch-icon">
<link href="<?//=(empty(konfigurasi_get('favicon')['konfigurasi_value']))?base_url(konfigurasi_get('favicon')['konfigurasi_default']):base_url(konfigurasi_get('favicon')['konfigurasi_value']);?>" rel="apple-touch-icon" sizes="72x72">
<link href="<?//=(empty(konfigurasi_get('favicon')['konfigurasi_value']))?base_url(konfigurasi_get('favicon')['konfigurasi_default']):base_url(konfigurasi_get('favicon')['konfigurasi_value']);?>" rel="apple-touch-icon" sizes="114x114">
<link href="<?//=(empty(konfigurasi_get('favicon')['konfigurasi_value']))?base_url(konfigurasi_get('favicon')['konfigurasi_default']):base_url(konfigurasi_get('favicon')['konfigurasi_value']);?>" rel="apple-touch-icon" sizes="144x144">
-->
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <!--<img alt="" class="img-fluid" src="<?//=(empty(konfigurasi_get('logo')['konfigurasi_value']))?base_url(konfigurasi_get('logo')['konfigurasi_default']):base_url(konfigurasi_get('logo')['konfigurasi_value']);?>">-->
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <?php
			$session = \Config\Services::session();
			if($session->getFlashdata('warning')){
		?>
		<div class="alert alert-danger">
			<ul>
				<?php
					foreach($session->getFlashdata('warning') as $val)
					{
				?>
					<li><?=$val;?></li>
				<?php		
					} 
				?>
			</ul>
		</div>
		<?php		
			} 
			if ($session->getFlashdata('success')) {
		?>
		<div class="alert alert-success"><?php echo $session->getFlashdata('success')?></div>
		<?php
			}
		?>
      <form method="post" action="login" class="clearfix">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" value="<?php if($session->getFlashdata('username')) echo $session->getFlashdata('username')?>" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password_hash">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" value="1" name="remember_me">
              <label for="remember">
                Remember Me
              </label>
            </div>
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
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.min.js"></script>
</body>
</html>
