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
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-bars"></i>
                  <p>
                      Data Master
                      <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  
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
                        <a href="<?=site_url('akademik/aktkuliahdosen')?>" menu="aktkuliahdosen" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Aktifitas Perkuliahan</p>
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
                    <!--
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/nilai')?>" menu="nilai" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Nilai</p>
                        </a>
                    </li>
                    -->
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-bars"></i>
                  <p>
                      Tugas Akhir
                      <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?=site_url('tugasakhir/disposisi')?>" menu="disposisi" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Disposisi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('tugasakhir/proposal')?>" menu="proposal" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Seminar Proposal</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('tugasakhir/skripsi')?>" menu="skripsi" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Munaqasyah Skripsi</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?=site_url('ijazah')?>" menu="ijazah" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Ijazah</p>
                </a>
            </li>
            <li class="nav-item">
              <a href="<?=site_url('profil')?>" menu="profil" class="nav-link">
                  <i class="nav-icon far fa-id-card"></i>
                  <p>
                      Profil
                  </p>
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