<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?=base_url()?>" class="brand-link">
    <img src="<?=base_url('assets');?>/logo.png" alt="STAI AL-MANNAN" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">STAI AL-MANNAN</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <?php 
                  //if(session()->get('akun_level') === "Admin"){
                    
                        $fotoProfil = (!empty(getDataUser(session()->get('akun_username'))['foto_profil']))?getDataUser(session()->get('akun_username'))['foto_profil']:'';
                  //}
        ?>
      <div class="image">
        <img src="<?=(!empty($fotoProfil))?base_url($fotoProfil):base_url().'/assets/logo.png'?>" class="img-circle elevation-2"  alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?=session()->get('akun_nama_lengkap');?></a>
      </div>
    </div>

   
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            
                    <li class="nav-item">
                        <a href="<?=site_url('pmb/setting_pmb')?>" menu="pmb/setting_pmb" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Setting PMB</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('pmb/calon_mhs')?>" menu="pmb/calon_mhs" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Calon Mahasiswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('pmb/rekap_maba')?>" menu="pmb/rekap_maba" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Rekap MABA</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('pmb/grafik')?>" menu="pmb/grafik" class="nav-link">
                          <i class="nav-icon fas fa-chart-bar"></i>
                          <p>Grafik</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('pmb/infografis')?>" menu="pmb/infografis" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Infografis / Brosur</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('pmb/affiliate')?>" menu="pmb/affiliate" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Refferal</p>
                        </a>
                    </li>
                
            
            <li class="nav-item">
                <a href="<?=site_url('akun')?>" menu="akun" class="nav-link">
                  <i class="nav-icon fas fa-user"></i>
                  <p>
                      Akun Saya
                  </p>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>