<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="id">
<head>
    <?php
        $infografis = getDataRow('infografis', ['is_aktif' => 'Y'], null, null, '1', 'rand()');
        $img = base_url($infografis['slider_img']);
    ?>
  <title>Pendaftaran Mahasiswa STAI Al-Mannan Tulungagung</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Website resmi pendaftaran mahasiswa baru STAI Al-Mannan Tulungagung">
    <meta name="keyword" content="STAI Al-Mannan, PMB, PMB STAI Al-Mannan Tulungagung, Pendaftaran STAI Al-Mannan Tulungagung">
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="PMB STAI Al-Mannan Tulungagung" />
    <meta property="og:title" content="PMB STAI Al-Mannan Tulungagung" />
    <meta property="og:description" content="Website resmi pendaftaran mahasiswa baru STAI Al-Mannan Tulungagung" />
    <meta property="og:url" content="<?=base_url('pendaftaran')?>" />
    <meta property="og:image" content="<?=$img;?>" />
    
    <meta itemprop="name" content="PMB STAI Al-Mannan Tulungagung">
    <meta itemprop="description" content="Website resmi pendaftaran mahasiswa baru STAI Al-Mannan Tulungagung">
    <meta itemprop="image" content="<?=$img;?>">

  <link rel="shortcut icon" href="<?=base_url('assets/favicon.png');?>" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
  <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/owlcarousel/assets/owl.theme.default.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="<?=base_url('assets');?>/logo.png" alt="STAI Al-Mannan" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Pendaftaran Mahasiswa STAI Al-Mannan Tulungagung</span>
      </a>
    <!--
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">

        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index3.html" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="#" class="dropdown-item">Some action </a></li>
              <li><a href="#" class="dropdown-item">Some other action</a></li>

              <li class="dropdown-divider"></li>


              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                  </li>


                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                    </ul>
                  </li>


                  <li><a href="#" class="dropdown-item">level 2</a></li>
                  <li><a href="#" class="dropdown-item">level 2</a></li>
                </ul>
              </li>

            </ul>
          </li>
        </ul>

      </div>
    -->
      
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> <?=$templateJudul?></h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
            
            <div class="col-lg-4">
                <?php 
                    $periodePmb = dataDinamis('setting_gelombang', ['Aktif' => '1']);
                    foreach($periodePmb as $row){
                ?>
                <div class="card card-primary card-outline">
                  <div class="card-body">
                    <h4 class="card-title"><b><?=$row->Nama_Periode?></b></h4><br>
                    <hr>
                    <p class="card-text">
                        <strong>
                          <?=$row->Nama_Gelombang?> <br>
                          <?=date_indo($row->Tgl_Mulai)?> s/d <?=date_indo($row->Tgl_Akhir)?><br>
                          Biaya Pendaftaran Rp. <?=number_format($row->biaya,0,",",".")?>
                        </strong>
                    </p>
                    <a href="<?=base_url()?>/pendaftaran/<?=$row->jenjang?><?=(isset($kode_referral))?'?kode_referral='.$kode_referral:''?>" target="_blank" class="btn btn-primary  btn-sm">Daftar Sekarang</a>
                    <hr>
                    <p class="card-text">
                        <strong>
                          Sudah Daftar?? Klik Tombol dibawah untuk login!!
                        </strong>
                    </p>
                    <a href="<?=base_url()?>" target="_blank" class="btn btn-success btn-sm">LOGIN</a>
                  </div>
                </div><!-- /.card -->
                <?php } ?>
            </div>
            <!-- /.col-lg-4 -->
            
            <div class="col-lg-8">
                <?php $dataInfografis = dataDinamis('infografis', ['is_aktif' => 'Y', 'deleted_at' => NULL]);
                        if(!empty($dataInfografis)){
                       
                ?>
                <div class="owl-carousel owl-theme">
                    <?php foreach($dataInfografis as $row){ ?>
                    <div class="item" >
                      <img src="<?=base_url("$row->slider_img");?>" class="img-fluid" alt="<?=$row->slider_title?>">
                    </div>
                    <?php } ?>
                </div>
                
                <?php } ?>
            </div>
                
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://staialmannan.com">STAI Al-Mannan</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/owlcarousel/owl.carousel.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.min.js"></script>

<script>
            $(document).ready(function() {
              $('.owl-carousel').owlCarousel({
                items: 1,
                margin: 10,
                autoHeight: true,
                loop: true,
                autoplay:true,
                autoplayTimeout:5000,
                autoplayHoverPause:true
              });
            })
          </script>

</body>
</html>
