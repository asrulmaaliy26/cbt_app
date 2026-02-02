<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIM STAI AL-MANNAN | <?=$templateJudul?></title>
  <link rel="shortcut icon" href="<?=base_url('assets/favicon.png');?>" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets')?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/toastr/toastr.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?=base_url('assets')?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url('assets')?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  

</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?=base_url('assets');?>/logo.png" alt="STAI Al-Mannan" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              <?php 
                        $fotoProfil = (!empty(getDataUser(session()->get('akun_username'))['foto_profil']))?getDataUser(session()->get('akun_username'))['foto_profil']:'';
                  
              ?>
              <img src="<?=(!empty($fotoProfil))?base_url($fotoProfil):base_url().'/assets/logo.png'?>" class="user-image img-circle elevation-2" alt="User Image">
              <span class="d-none d-md-inline"><?=session()->get('akun_nama_lengkap');?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-primary">
                <img src="<?=(!empty($fotoProfil))?base_url($fotoProfil):base_url().'/assets/logo.png'?>" class="img-circle elevation-2" alt="User Image">
        
                <p>
                  <?=session()->get('akun_nama_lengkap');?>
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <a href="<?=site_url('akun')?>" class="btn btn-default btn-flat">Akun Saya</a>
                <a href="<?=base_url('logout')?>" class="btn btn-default btn-flat float-right">Sign out</a>
              </li>
            </ul>
        </li>
      <li class="nav-item">
        <!--
        <a class="nav-link" href="<?=base_url('logout')?>" data-placement="bottom" title="Sign-out" role="button">
          <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
        </a>
        -->

        <select class="custom-select form-control-border" onchange="changeRole()" id="role">
          <option></option>
          <?php
            $groupUser = getUserGroup(session()->get('akun_id'))->getResultArray();
            foreach ($groupUser as $row) {
          ?>
          <option value="<?=$row['group_id'];?>" <?= (!empty(session()->get('akun_level')) && session()->get('akun_level')==$row['name'])?"selected":"";?>><?=$row['name'];?></option>
          <?php }?>
          
        </select>
      </li>
        
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->
  <?php
        if(session()->get('akun_group_folder') !== null){
            $menu = session()->get('akun_group_folder');
        }else{
            $menu = 'blank_menu';
        }
  ?>
    
  <!-- Main Sidebar Container -->
  <?=$this->include("layout/sidebar/$menu");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?=$this->include('layout/contentHeader');?>
    <!-- /.content-header -->

    <!-- Main content -->
    <?= $this->renderSection('content');?>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://staialmannan.com">STAI Al-Mannan</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('assets');?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url('assets');?>/plugins/toastr/toastr.min.js"></script>
<!-- Select2 -->
<script src="<?=base_url('assets');?>/plugins/select2/js/select2.full.min.js"></script>
<!-- daterangepicker -->
<script src="<?=base_url('assets');?>/plugins/moment/moment.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.js"></script>



<script type="text/javascript">
    $(function() {
        //var current_page_URL = location.href;
        var current_page_URL = "<?=$aktif_menu?>";
        $('ul.nav-sidebar li a').each(function () {
            if($(this).attr('href') !== '#'){
                //var target_URL = $(this).prop("href");
                var target_URL = $(this).attr("menu");
                if (target_URL == current_page_URL) {
                  $(this).addClass('active').parent().parent().parent('li').addClass('menu-open').children('a').addClass('active');
                  $(this).addClass('active').parent().parent().parent('li').addClass('menu-open').children('a').addClass('active').parent().parent().parent('li').addClass('menu-open').children('a').addClass('active');
                }
            }
        })
    });
    
    function changeRole() {
        var role = $('#role option:selected').val();
        $.ajax({
              url: "<?php echo site_url("dashboard");?>",
              type: "post",
              data: "role="+role,
              dataType: 'json',
              beforeSend: function() {
                  Swal.fire({
                      title: 'Please Wait!!',
                      allowOutsideClick: false,
                      showConfirmButton: false,
                      didOpen: () => {
                          Swal.showLoading()
                      },
                  });
              },
              success: function(data) {
                Swal.close();
                  if (data.msg == 'success') {
                      Swal.fire({
                        icon: 'success',
                        title: data.pesan,
                        allowOutsideClick: false,
                    }).then(() => {
                        window.location.href = "<?=base_url("dashboard")?>";
                    })

                  } else {
                      const Toast = Swal.mixin({
                          toast: true,
                          position: 'top-end',
                          showConfirmButton: false,
                          timer: 3000,
                          timerProgressBar: true,
                          didOpen: (toast) => {
                              toast.addEventListener('mouseenter', Swal.stopTimer)
                              toast.addEventListener('mouseleave', Swal.resumeTimer)
                          }
                      })

                      Toast.fire({
                          icon: data.msg,
                          title: data.pesan
                      })
                  }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                Swal.close();
                  console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
        });
    }
    
    <!-- Fungsi untuk modal dinamis -->
    (function(a){
    a.createModal=function(b){
      defaults={
        title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false
      };
      var b=a.extend({},defaults,b);
      var c=(b.scrollable===true)?'style="max-height: 800px;overflow-y: auto;"':"";
      html='<div class="modal fade" id="myModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
      html+='<div class="modal-dialog modal-xl" role="document">';
      html+='<div class="modal-content">';
      html+='<div class="modal-header">';
      if(b.title.length>0){
        html+='<h5 class="modal-title">'+b.title+"</h5>"
      }
      html+='<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
      
      html+="</div>";
      html+='<div class="modal-body" '+c+">";
      html+=b.message;
      html+="</div>";
      html+='<div class="modal-footer">';
      if(b.status_transaksi && b.status_transaksi!=='Sukses'){
        html+='<a role="button" href="javascript:void(0)" onclick="confirmBayar('+b.id_transaksi+')" class="btn btn-sm btn-success" rel="noopener">Konfirmasi</a>'
      }
      if(b.status_transaksi && b.status_transaksi==='Sukses'){
        html+='<a role="button" href="'+b.link_cetak+'" class="btn btn-sm btn-primary" rel="noopener" target="_blank"><i class="fas fa-print"></i> Print</a>'
      }
      if(b.closeButton===true){
        html+='<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>'
      }
      
      html+="</div>";
      html+="</div>";
      html+="</div>";
      html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){
        a(this).remove()
        if(b.reload_table===true && b.tbl_id === 'table_mk'){
            reload_table_mk();
        } 
        if(b.reload_table===true && b.tbl_id === 'table_mhs'){
            reload_table_mhs();
        } 
        
        if(b.table_reload===true ){
            reload_table();
        } 
      })}})(jQuery);
  

</script>

</body>
</html>
