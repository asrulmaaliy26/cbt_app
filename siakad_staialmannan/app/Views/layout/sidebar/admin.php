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
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/transkrip')?>" menu="transkrip" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Transkrip</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/akm')?>" menu="akm" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>AKM</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/nilai')?>" menu="nilai" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Nilai</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/kuliahulang')?>" menu="kuliahulang" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Kuliah Ulang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/cuti')?>" menu="cuti" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Cuti Perkuliahan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/ujian')?>" menu="ujian" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Ujian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=site_url('akademik/kelulusan')?>" menu="kelulusan" class="nav-link">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <p>Kelulusan / DO</p>
                        </a>
                    </li>
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
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-bars"></i>
                  <p>
                      PMB
                      <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
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
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?=site_url('ijazah')?>" menu="ijazah" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Ijazah</p>
                </a>
            </li>
            <!--<li class="nav-item">-->
            <!--    <a href="<?=site_url('users')?>" menu="users" class="nav-link">-->
            <!--        <i class="nav-icon fas fa-users"></i>-->
            <!--        <p>Manajemen User</p>-->
            <!--    </a>-->
            <!--</li>-->
            
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