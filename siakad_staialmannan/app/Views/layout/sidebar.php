<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?=base_url('assets');?>/logo_iaibafa.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <?php 
                  if(session()->get('akun_level') === "Admin"){
                    
                        $fotoProfil = (!empty(getDataUser(session()->get('akun_username'))['foto_profil']))?getDataUser(session()->get('akun_username'))['foto_profil']:'';
                  }
        ?>
      <div class="image">
        <img src="<?=(!empty($fotoProfil))?base_url($fotoProfil):base_url().'/assets/logo_iaibafa.png'?>" class="img-circle elevation-2"  alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?=session()->get('akun_nama_lengkap');?></a>
      </div>
    </div>

   
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php if(session()->get('akun_level') === "Admin"){?>
            <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-bars"></i>
                  <p>
                      Data Master
                      <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="<?=site_url('masterdata/tahunakademik')?>" menu="tahunakademik" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Tahun Akademik</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="<?=site_url('masterdata/mastermatakuliah')?>" menu="mastermatakuliah" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Mata Kuliah</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="<?=site_url('masterdata/kurikulum')?>" menu="kurikulum" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Kurikulum</p>
                      </a>
                  </li>
                  
                  <li class="nav-item">
                      <a href="<?=site_url('masterdata/kelas')?>" menu="kelas" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Kelas</p>
                      </a>
                  </li>
                  <!--
                  <li class="nav-item">
                      <a href="<?=site_url('dashboard/mapel')?>" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Mata Pelajaran</p>
                      </a>
                  </li>
                  -->
                  
                  <li class="nav-item">
                    <a href="<?=site_url('masterdata/dosen')?>" menu="dosen" class="nav-link">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                            Dosen
                        </p>
                    </a>
                  </li>
                  <li class="nav-item">
                      <a href="<?=site_url('masterdata/mahasiswa')?>" menu="mahasiswa" class="nav-link">
                          <i class="nav-icon far fa-user"></i>
                          <p>
                              Mahasiswa
                          </p>
                      </a>
                  </li>
                </ul>
                </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-bars"></i>
                  <p>
                      Akademik
                      <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/distribusi_matakuliah')?>" menu="distribusi_matakuliah" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Distribusi Matakuliah</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/perkuliahan')?>" menu="perkuliahan" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Perkuliahan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/krs')?>" menu="krs" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>KRS</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/khs')?>" menu="khs" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>KHS</p>
                        </a>
                    </li>
                  
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-bars"></i>
                  <p>
                      PMB
                      <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?=site_url('pmb/calon_mhs')?>" menu="pmb/calon_mhs" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Calon Mahasiswa</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?=site_url('users')?>" menu="users" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Manajemen User</p>
                </a>
            </li>
            <?php } ?>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>