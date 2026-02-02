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
            $fotoProfil = (!empty(getDataUser(session()->get('akun_username'))['foto_profil']))?getDataUser(session()->get('akun_username'))['foto_profil']:'';
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
                <a href="<?=site_url('akademik/krs')?>" menu="krs" class="nav-link">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>KRS</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=site_url('akademik/perkuliahan')?>" menu="perkuliahan" class="nav-link">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>Perkuliahan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=site_url('akademik/ujian')?>" menu="ujian" class="nav-link">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>Ujian</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=site_url('akademik/khs')?>" menu="khs" class="nav-link">
                  <i class="nav-icon far fa-calendar-alt"></i>
                  <p>KHS</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=site_url('akademik/kuliahulang')?>" menu="kuliahulang" class="nav-link">
                  <i class="nav-icon fa fa-list"></i>
                  <p>Kuliah Ulang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?=site_url('akademik/cuti')?>" menu="cuti" class="nav-link">
                  <i class="nav-icon fa fa-list"></i>
                  <p>Permohonan Cuti</p>
                </a>
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
            <?php 
                //$id_data_diri = getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'];
                //$id_his_pdk = getDataRow('histori_pddk', ['id_data_diri' => $data['id_data_diri'], 'status' => 'A'])['id_his_pdk'];
                $data_ijazah = getDataRow('tb_ijazah', ['id_his_pdk' => getDataRow('histori_pddk', ['id_data_diri' => getDataRow('db_data_diri_mahasiswa', ['username' => session()->get('akun_username')])['id'], 'status' => 'A'])['id_his_pdk']]);
                if(!empty($data_ijazah)){
            ?>
            <li class="nav-item">
                <a href="<?=site_url('ijazah')?>" menu="ijazah" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Ijazah</p>
                </a>
            </li>
            <?php } ?>
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