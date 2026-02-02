<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<script type="text/javascript">
	
    
    
    
	
</script>

<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?=(!empty($foto))?base_url($foto):base_url().'/assets/dist/img/no-pict.jpg'?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?=$gelar_depan?> <?=$Nama_Dosen?>, <?=$gelar_belakang?></h3>

                <a href="javascript:void(0)" onclick="edit_profil('<?=$id_dosen?>'); return false;" class="btn btn-primary btn-block"><b>Edit Profil</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> NIY</strong>

                <p class="text-muted">
                  <?=$NIY?>
                </p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i> NIDN</strong>

                <p class="text-muted"><?=$NIDN_NUPN?></p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i> TTL</strong>

                <p class="text-muted">
                  <?=$TTL?>
                </p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i> Pangkat / Gol. / Ruang</strong>

                <p class="text-muted"><?=(!empty($Pangkat_Gol_Ruang))?getDataRow('ref_option',['opt_group' => 'pangkat', 'opt_id' => $Pangkat_Gol_Ruang])['opt_val']:"-"?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Jabatan</strong>

                <p class="text-muted"><?=(!empty($Jabatan))?getDataRow('ref_option',['opt_group' => 'jabatan_fungsional', 'opt_id' => $Jabatan])['opt_val']:"-"?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Status</strong>

                <p class="text-muted"><?=(!empty($Status))?getDataRow('ref_option',['opt_group' => 'status_dosen', 'opt_id' => $Status])['opt_val']:"-"?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Homebase</strong>

                <p class="text-muted"><?=(!empty($Program_Studi))?getDataRow('prodi',['singkatan'=>$Program_Studi])['nm_prodi']:"-"?></p>
                
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Tahun Mulai Tugas</strong>

                <p class="text-muted"><?=$tahun_tugas?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Alamat</strong>

                <p class="text-muted"><?=$Alamat?></p>
                
                <hr>

                
                <strong><i class="fas fa-book mr-1"></i> Alamat Email</strong>
                <p class="text-muted"><?=$Alamat_Email?></p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Jenis Kelamin</strong>
                <p class="text-muted">
                    <?php
                        echo ($jenis_kelamin == "L") ? "Laki-laki" :
                            (($jenis_kelamin == "P") ? "Perempuan" : "-");
                    ?>
                </p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Ibu Kandung</strong>
                <p class="text-muted"><?=$ibu_kandung?></p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Status Kawin</strong>
                <p class="text-muted">
                    <?php
                        echo ($status_kawin == "Kawin") ? "Kawin" :
                            (($status_kawin == "Belum Kawin") ? "Belum Kawin" : "-");
                    ?>
                </p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Agama</strong>
                <p class="text-muted">
                    <?=(!empty($Agama)) ? getDataRow('ref_option',['opt_group'=>'agama','opt_id'=>$Agama])['opt_val'] : "-"?>
                </p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Profil Sinta</strong>

                <p class="text-muted"><?=$profil_sinta?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Link Google Scholar</strong>

                <p class="text-muted"><?=$scholar?></p>
                
                
              </div>
              <!-- /.card-body -->
            </div>
            
            <?php if(!empty(getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['link_referral'])){?>
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Link PMB</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a id="waButton" href=""><img src="<?=base_url('assets/dist/img/share_wa.png');?>" width="100%"></img></a>
              </div>
              <!-- /.card-body -->
            </div>
            <?php } ?>
            <?php if(!empty(getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['qrcode'])){?>
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">QRCode PMB</h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                <img src="<?=getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['qrcode'];?>" width="100%"></img>
              </div>
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <?php } ?>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#pendidikan" onclick="loadPendidikan()" data-toggle="tab">Pendidikan</a></li>
                  <li class="nav-item"><a class="nav-link" href="#penelitian" onclick="loadPenelitian()" data-toggle="tab">Penelitian</a></li>
                  <li class="nav-item"><a class="nav-link" href="#pengabdian" onclick="loadPengabdian()" data-toggle="tab">Pengabdian</a></li>
                  <li class="nav-item"><a class="nav-link" href="#penghargaan" onclick="loadPenghargaan()" data-toggle="tab">Penghargaan</a></li>
                  <li class="nav-item"><a class="nav-link" href="#jurnal" onclick="loadJurnal()" data-toggle="tab">Jurnal</a></li>
                  <li class="nav-item"><a class="nav-link" href="#buku" onclick="loadBuku()" data-toggle="tab">Buku</a></li>
                  <!--<li class="nav-item"><a class="nav-link" href="#riwayat_mengajar" data-toggle="tab">Riwayat Mengajar</a></li>-->
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="pendidikan">
                        <div class="mailbox-controls">
                              <div class="row">
                                  
                                    <div class="btn-group">
                                      <a href="<?=base_url("$controller/tmb_riwayat_pddk?kd_dosen=$Kode")?>" judul="Tambah Riwayat Pendidikan" tabel="pendidikan" role="button" class="btn btn-success btn-sm tambah" data-placement="top" title="Tambah Riwayat Pendidikan">
                                        <i class="fa fa-plus"></i> Tambah Riwayat Pendidikan
                                      </a>
                                      
                                    </div>
                              </div>
                        </div>
                        <div class="table-responsive">
                            <table id="data_pendidikan" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th class="text-center">Jenjang</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Gelar Akademik</th>
                                        <th class="text-center">Tahun Lulus</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
            
                                </tbody>
            
                            </table>
                        </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="penelitian">
                        <div class="mailbox-controls">
                              <div class="row">
                                  
                                    <div class="btn-group">
                                      <a href="<?=base_url("$controller/tmb_penelitian?kd_dosen=$Kode")?>" judul="Tambah Penelitian" tabel="penelitian" role="button" class="btn btn-success btn-sm tambah" data-placement="top" title="Tambah Riwayat Pendidikan">
                                        <i class="fa fa-plus"></i> Tambah Penelitian
                                      </a>
                                      
                                    </div>
                              </div>
                        </div>
                        <div class="table-responsive">
                            <table id="data_penelitian" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
										<th class="text-center">No.</th>										
										<th class="text-center">Judul</th>
										<th class="text-center">Tahun</th>
										<th class="text-center">Sumber Dana</th>
										<th class="text-center">Tingkat</th>
										<th class="text-center">File</th>
                                        <th class="text-center">Aksi</th>
									</tr>
                                </thead>
                                <tbody>
            
                                </tbody>
            
                            </table>
                        </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="pengabdian">
                        <div class="mailbox-controls">
                              <div class="row">
                                  
                                    <div class="btn-group">
                                      <a href="<?=base_url("$controller/tmb_pengabdian?kd_dosen=$Kode")?>" judul="Tambah Pengabdian" tabel="pengabdian" role="button" class="btn btn-success btn-sm tambah" data-placement="top" title="Tambah Pengabdian">
                                        <i class="fa fa-plus"></i> Tambah Pengabdian
                                      </a>
                                      
                                    </div>
                              </div>
                        </div>
                        <div class="table-responsive">
                            <table id="data_pengabdian" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
										<th class="text-center">No.</th>										
										<th class="text-center">Judul</th>
										<th class="text-center">Tahun</th>
										<th class="text-center">Sumber Dana</th>
										<th class="text-center">Tingkat</th>
										<th class="text-center">File Laporan</th>
                                        <th class="text-center">Aksi</th>
									</tr>
                                </thead>
                                <tbody>
            
                                </tbody>
            
                            </table>
                        </div>
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="penghargaan">
                        <div class="mailbox-controls">
                              <div class="row">
                                  
                                    <div class="btn-group">
                                      <a href="<?=base_url("$controller/tmb_penghargaan?kd_dosen=$Kode")?>" judul="Tambah Penghargaan" tabel="penghargaan" role="button" class="btn btn-success btn-sm tambah" data-placement="top" title="Tambah Penghargaan">
                                        <i class="fa fa-plus"></i> Tambah Penghargaan
                                      </a>
                                      
                                    </div>
                              </div>
                        </div>
                        <div class="table-responsive">
                            <table id="data_penghargaan" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
										<th class="text-center">No.</th>										
										<th class="text-center">Judul</th>
										<th class="text-center">Jenis</th>
										<th class="text-center">Tahun</th>
										<th class="text-center">Tingkat</th>
										<th class="text-center">Bukti</th>
                                        <th class="text-center">Aksi</th>
									</tr>
                                </thead>
                                <tbody>
            
                                </tbody>
            
                            </table>
                        </div>
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="jurnal">
                        <div class="mailbox-controls">
                              <div class="row">
                                  
                                    <div class="btn-group">
                                      <a href="<?=base_url("$controller/tmb_jurnal?kd_dosen=$Kode")?>" judul="Tambah Jurnal Ilmiah" tabel="jurnal" role="button" class="btn btn-success btn-sm tambah" data-placement="top" title="Tambah Jurnal Ilmiah">
                                        <i class="fa fa-plus"></i> Tambah Jurnal Ilmiah
                                      </a>
                                      
                                    </div>
                              </div>
                        </div>
                        <div class="table-responsive">
                            <table id="data_jurnal" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
										<th class="text-center">No.</th>										
										<th class="text-center">Judul Artikel</th>
										<th class="text-center">Nama Jurnal</th>
										<th class="text-center">Tahun Terbit</th>
										<th class="text-center">Nomor / Volume</th>
										<th class="text-center">ISSN</th>
										<th class="text-center">Link Artikel</th>
                                        <th class="text-center">Aksi</th>
									</tr>
                                </thead>
                                <tbody>
            
                                </tbody>
            
                            </table>
                        </div>
                  </div>
                  <div class="tab-pane" id="buku">
                        <div class="mailbox-controls">
                              <div class="row">
                                  
                                    <div class="btn-group">
                                      <a href="<?=base_url("$controller/tmb_buku?kd_dosen=$Kode")?>" judul="Tambah Buku" tabel="buku" role="button" class="btn btn-success btn-sm tambah" data-placement="top" title="Tambah Buku">
                                        <i class="fa fa-plus"></i> Tambah Buku
                                      </a>
                                      
                                    </div>
                              </div>
                        </div>
                        <div class="table-responsive">
                            <table id="data_buku" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
										<th class="text-center">No.</th>										
										<th class="text-center">Judul Buku</th>
										<th class="text-center">Tahun Terbit</th>
										<th class="text-center">Penerbit</th>
										<th class="text-center">ISBN</th>
										<th class="text-center">Link ISBN</th>
                                        <th class="text-center">Aksi</th>
									</tr>
                                </thead>
                                <tbody>
            
                                </tbody>
            
                            </table>
                        </div>
                  </div>
                  <!--
                  <div class="tab-pane" id="riwayat_mengajar">
                    
                  </div>
                  -->
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="tambahModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_tambah" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Dosen / Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Kode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="id_dosen" name="id_dosen" />
                            <input type="text" class="form-control" id="Kode" name="Kode"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Gelar Depan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gelar_depan" name="gelar_depan"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Gelar Belakang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="Nama_Dosen" name="Nama_Dosen"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">NIY</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="NIY" name="NIY"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">TTL</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="TTL" name="TTL"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">NIDN / NUPN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="NIDN_NUPN" name="NIDN_NUPN"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="Alamat" name="Alamat"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Kewarganegaraan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kewarganegaraan" name="kewarganegaraan"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Alamat Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="Alamat_Email" name="Alamat_Email"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Ibu Kandung</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ibu_kandung" name="ibu_kandung"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Status Kawin</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="status_kawin" name="status_kawin">
                                <option value="">-- Pilih Status Kawin --</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Agama</label>
                        <div class="col-sm-9">
                            <?php
                                    
                                echo cmb_dinamis('Agama', 'ref_option', 'opt_val', 'opt_id', ((isset($diri['Agama']))?$diri['Agama']:NULL), null, 'id="Agama"',null,null, ['opt_group'=>'agama']);
                                ?>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Pangkat / Golongan</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Pangkat_Gol_Ruang', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Pangkat_Gol_Ruang" style="width: 100%;"', null, null, ['opt_group' => 'pangkat']);
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jabatan Fungsional</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Jabatan', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Jabatan" style="width: 100%;"', null, null, ['opt_group' => 'jabatan_fungsional']);
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Status', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Status" style="width: 100%;"', null, null, ['opt_group' => 'status_dosen']);
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tahun Tugas</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="tahun_tugas" name="tahun_tugas"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Homebase</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Program_Studi', 'prodi', 'nm_prodi', 'singkatan', null, null, 'id="Program_Studi" style="width: 100%;"');
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Profil Sinta</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="profil_sinta" name="profil_sinta"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Profil Google Scholar</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="scholar" name="scholar"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" class="custom-file-input" id="foto" name="foto"
                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])"> >
                                    <label class="custom-file-label" for="input_post_thumbnail">Choose file</label>
                                </div>

                            </div>

                            <div class="invalid-feedback">

                            </div>

                            <div class="col-sm-4 pt-2">
                                <div class="position-relative">
                                    <img id="pic" class="img-fluid" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url('assets');?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
var table;
$(function() {
    loadPendidikan('<?=$Kode?>');
    bsCustomFileInput.init();
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $(document).ready(function(){
        
        const button = document.getElementById('waButton');
        let link_ref = "<?=(!empty(getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['link_referral']))?getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['link_referral']:'';?>";
        let text = "Buat kalian yang pingin jadi *Akademisi yang Santri dan Santri yang Akademisi*... Ayo segera gabung di kampus *IAI Bani Fattah Jombang || The Center Of Tafaqquh Fiddin*... Ayoo tunggu apalagi Klik tautan berikut ini.... ";
        
        // let sharehref = `whatsapp://send?text=${encodeURIComponent(imageSrc)}`;
        
        button.setAttribute('href', 'whatsapp://send?text='+text+link_ref);
    });
    $('[data-mask]').inputmask();
    $('#tambahModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#pic').removeAttr('src');
        $(this).find('#username').attr('readonly', false);
    });
    
    table = $('#data').DataTable({
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("masterdata/$controller/ajaxList") ?>",
            "type": "POST",
            "data": function(data) {
                data.prodi = $('#prodi').val();
                data.status_dosen = $('#status_dosen').val();
                data.jabatan_fungsional = $('#jabatan_fungsional').val();
                data.pangkat = $('#pangkat').val();
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });

    $('th input[type=checkbox], td input[name=check]').prop('checked', false);
                        
    var active_class = 'active';
    $('#data > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header
        
        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[name=check]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[name=check]').eq(0).prop('checked', false);
        });
    });
})

function reload_table(){
    table.ajax.reload(null, false);
}

function loadPendidikan(){
    let kd_dosen = "<?=$Kode?>";
    $('#data_pendidikan').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    		},
        "destroy": true,
        "paging": false,
        "lengthChange": false,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("$controller/loadPendidikanDosen") ?>",
            "type": "POST",
            "data": function(data) {
                data.kd_dosen = kd_dosen;
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function loadPenelitian(){
    let kd_dosen = "<?=$Kode?>";
    $('#data_penelitian').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(2).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    		},
        "destroy": true,
        "paging": false,
        "lengthChange": false,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("$controller/loadPenelitian") ?>",
            "type": "POST",
            "data": function(data) {
                data.kd_dosen = kd_dosen;
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function loadPengabdian(){
    let kd_dosen = "<?=$Kode?>";
    $('#data_pengabdian').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(2).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    		},
        "destroy": true,
        "paging": false,
        "lengthChange": false,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("$controller/loadPengabdian") ?>",
            "type": "POST",
            "data": function(data) {
                data.kd_dosen = kd_dosen;
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function loadPenghargaan(){
    let kd_dosen = "<?=$Kode?>";
    $('#data_penghargaan').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(2).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    		},
        "destroy": true,
        "paging": false,
        "lengthChange": false,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("$controller/loadPenghargaan") ?>",
            "type": "POST",
            "data": function(data) {
                data.kd_dosen = kd_dosen;
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function loadJurnal(){
    let kd_dosen = "<?=$Kode?>";
    $('#data_jurnal').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    		},
        "destroy": true,
        "paging": false,
        "lengthChange": false,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("$controller/loadJurnal") ?>",
            "type": "POST",
            "data": function(data) {
                data.kd_dosen = kd_dosen;
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function loadBuku(){
    let kd_dosen = "<?=$Kode?>";
    $('#data_buku').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(2).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    		},
        "destroy": true,
        "paging": false,
        "lengthChange": false,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("$controller/loadBuku") ?>",
            "type": "POST",
            "data": function(data) {
                data.kd_dosen = kd_dosen;
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function hapus_data_dosen(tabel,pk,id) {
    //var link = "<?=site_url("masterdata/$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Data akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/hapus_data_dosen");?>",
                type: "post",
                data: "tabel="+tabel+"&id="+id+"&pk="+pk,
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
                    //$(".overlay").css("display","none");
                    
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    }).then(() => {
                        if(tabel === "tb_riwayat_pendidikan"){
                            loadPendidikan();
                        }
                        if(tabel === "tb_penelitian"){
                            loadPenelitian();
                        }
                        if(tabel === "tb_pengabdian"){
                            loadPengabdian();
                        }
                        if(tabel === "tb_penghargaan"){
                            loadPenghargaan();
                        }
                        if(tabel === "tb_artikel"){
                            loadJurnal();
                        }
                        if(tabel === "tb_buku"){
                            loadBuku();
                        }
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Wrong!!',
                        text:thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function edit_profil(id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("$controller/getDataDosen");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#tambahModal').modal('show');
                $('#exampleModalLabel').text('Edit Data Dosen / Pegawai');
                $.each(response.data, function(key, value) {
                    if (key != "foto") {
                        $('#' + key).val(value);
                        if ($('#' + key).is('.select2')) {
                            
                                $('#' + key).val(value).trigger('change');
                            
                        }
                    } else if (key == "foto") {
                        if(value != null){
                            $('#pic').attr('src', "<?=base_url()?>/" + value);
                        }
                    }
                    if(key == 'username' || key == 'Kode'){
                        $('#' + key).attr('readonly',true);
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopsss',
                    text: 'blablabla'
                })
            }
        }
    })
}

function edit(link,id) {
    var link = link;      
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:65vh;">No Support</object>';
    var judul = $('#id'+id).attr('judul');
    var tabel = $('#id'+id).attr('tabel');
    
    $.showModal({
      title:judul,
      message: iframe,
      closeButton:true,
      reload_table:true,
      tbl:tabel,
      //confirmButton:true,
      scrollable:false
    });
    return false;     
}

function simpan() {

    var data = new FormData($("#form_tambah")[0]);
    $('#form_tambah').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller");?>",
                type: "post",
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
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
                    	$('#tambahModal').modal('hide');
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        })
                    } else if (data.msg == 'warning'){
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                        $.each(data.validation, function(key, value) {
                            
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });
                    }else{
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })

}


<!-- Fungsi untuk modal dinamis -->
(function(a){
    a.showModal=function(b){
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
      if(b.closeButton===true){
        html+='<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>'
      }
      
      html+="</div>";
      html+="</div>";
      html+="</div>";
      html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){
        a(this).remove()
         
        if(b.reload_table===true && b.tbl === 'pendidikan'){
            loadPendidikan();
        } 
        if(b.reload_table===true && b.tbl === 'penelitian'){
            loadPenelitian();
        }
        if(b.reload_table===true && b.tbl === 'pengabdian'){
            loadPengabdian();
        }
        if(b.reload_table===true && b.tbl === 'penghargaan'){
            loadPenghargaan();
        }
        if(b.reload_table===true && b.tbl === 'jurnal'){
            loadJurnal();
        }
        if(b.reload_table===true && b.tbl === 'buku'){
            loadBuku();
        } 
        if(b.table_reload===true ){
            reload_table();
        } 
      })}})(jQuery);

$(function(){    
  $('.tambah').on('click',function(){
    var link = $(this).attr('href');      
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:65vh;">No Support</object>';
    var judul = $(this).attr('judul');
    var tabel = $(this).attr('tabel');
    
    $.showModal({
      title:judul,
      message: iframe,
      closeButton:true,
      reload_table:true,
      tbl:tabel,
      //confirmButton:true,
      scrollable:false
    });
    return false;        
  });    
});

</script>
<?=$this->endSection();?>