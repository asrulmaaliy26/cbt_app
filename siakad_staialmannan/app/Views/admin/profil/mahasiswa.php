<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<script type="text/javascript">
	/*
    $(document).ready(function(){
        
        const button = document.getElementById('waButton');
        let link_ref = "";
        let text = "Buat kalian yang pingin jadi *Akademisi yang Santri dan Santri yang Akademisi*... Ayo segera gabung di kampus *IAI Bani Fattah Jombang || The Center Of Tafaqquh Fiddin*... Ayoo tunggu apalagi Klik tautan berikut ini.... ";
        
        // let sharehref = `whatsapp://send?text=${encodeURIComponent(imageSrc)}`;
        
        button.setAttribute('href', 'whatsapp://send?text='+text+link_ref);
    });
    */
    
</script>

<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?=(!empty($mhs['Foto_Diri']))?base_url($mhs['Foto_Diri']):base_url().'/assets/dist/img/no-pict.jpg'?>"
                       alt="User profile picture">
                </div>

                <h5 class="profile-username text-center"><?=$mhs['Nama_Lengkap']?></h5>

                <a href="javascript:void(0)" onclick="edit('foto','<?=$mhs['id']?>'); return false;" class="btn btn-primary btn-block"><b>Edit Foto</b></a>
                <a href="javascript:void(0)" onclick="cetakKtm('<?=$mhs['id']?>'); return false;" class="btn btn-primary btn-block"><b>Cetak KTM</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <?php if(!empty(getDataRow('pmb_affiliate', ['id_referrer' => $mhs['id']])['link_referral'])){?>
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
            
          </div>
          <!-- /.col -->
          <div class="col-md-10">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#data_diri" data-toggle="tab">Data Diri</a></li>
                  <li class="nav-item"><a class="nav-link" href="#his_pdk" onclick="loadHisPdk('<?=$mhs['id']?>')" data-toggle="tab">Histori Pendidikan</a></li>
                  <li class="nav-item"><a class="nav-link" href="#nilai" onclick="loadProdiHisPdk('<?=$mhs['id']?>')" data-toggle="tab">Nilai</a></li>
                  <li class="nav-item"><a class="nav-link" href="#krs" onclick="loadDataKrs('<?=$mhs['id']?>')" data-toggle="tab">KRS</a></li>
                  <li class="nav-item"><a class="nav-link" href="#akm" onclick="loadDataAkm('<?=$mhs['id']?>')" data-toggle="tab">Aktifitas Perkuliahan</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="data_diri">
                	    <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">BIODATA DIRI</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">    
        		                    <div class="col-6">
        		                        <div class="table-responsive">
        				                    <table class="table table-sm">
        				                    	<tr>
        					                        <th style="width:40%">Nama</th>
        					                        <td><?=$mhs['Nama_Lengkap'];?></td>
        										</tr>
        										<tr>
        											<th >Tempat, Tgl Lahir</th>
        											<td><?=$mhs['Kota_Lhr'];?>, <?=$mhs['Tgl_Lhr'];?></td>
        										</tr>
        										<tr>
        											<th>NISN</th>
        											<td><?=$mhs['NISN'];?></td>
        										</tr>
        										<tr>
        											<th>NIK</th>
        											<td><?=$mhs['No_KTP'];?></td>
        										</tr>
        										<tr>
        											<th>No. KK</th>
        											<td><?=$mhs['No_KK'];?></td>
        										</tr>
        										<tr>
        											<th>Gender</th>
        											<td><?=($mhs['Jenis_Kelamin'] == "L") ? "Laki-Laki" : (($mhs['Jenis_Kelamin'] == "P") ? "Perempuan" : "");?></td>
        										</tr>
        										<tr>
        											<th>Gol. Darah</th>
        											<td><?=$mhs['Gol_Darah'];?></td>
        										</tr>
        										<tr>
        											<th>Agama</th>
        											<td><?=(!empty($mhs['Agama']))?getDataRow('ref_option',['opt_group' => 'agama', 'opt_id' => $mhs['Agama']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Kewarganegaraan</th>
        											<td><?=$mhs['Kewarganegaraan'];?></td>
        										</tr>
        										<tr>
        											<th>Alamat</th>
        											<td><?=$mhs['Alamat'];?> <?=$mhs['No_Rmh'];?> <?=$mhs['Dusun'];?> <?=$mhs['RT'];?> <?=$mhs['RW'];?> <?=$mhs['Desa'];?> <?=$mhs['Kec'];?> <?=$mhs['Kab'];?> <?=$mhs['Prov'];?> <?=$mhs['Kode_Pos'];?></td>
        										</tr>
        										<tr>
        											<th>No. HP</th>
        											<td><?=$mhs['No_HP'];?></td>
        										</tr>
        										<tr>
        											<th>No. Whatsapp</th>
        											<td><?=$mhs['no_wa'];?></td>
        										</tr>
        										<tr>
        											<th>Email</th>
        											<td><?=getDataRow('users', ['username' => $mhs['username']])['email'];?></td>
        										</tr>
        										<tr>
        											<th>No. KIP / KKS / PIP / PKH </th>
        											<td><?=$mhs['No_KPS'];?></td>
        										</tr>
        										
        										
        				                    </table>
        				                </div>
        		                    </div>
        		                    <div class="col-6">
        		                    	<div class="table-responsive">
        				                    <table class="table table-sm">
        				                    	<tr>
        											<th>Anak Ke</th>
        											<td><?=$mhs['Anak_Ke'];?> Dari <?=$mhs['Jml_Saudara']?> bersaudara</td>
        										</tr>
        										<tr>
        											<th>Status Perkawinan</th>
        											<td><?=$mhs['Status_Perkawinan'];?></td>
        										</tr>
        										<tr>
        											<th>Pekerjaan</th>
        											<td><?=(!empty($mhs['Pekerjaan']))?getDataRow('ref_option',['opt_group' => 'pekerjaan', 'opt_id' => $mhs['Pekerjaan']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Biaya Ditanggung?</th>
        											<td><?=$mhs['Biaya_ditanggung'];?></td>
        										</tr>
        										
        										<tr>
        											<th>Jenis Domisili</th>
        											<td><?=(!empty($mhs['Jenis_Domisili']))?getDataRow('ref_option',['opt_group' => 'jns_tinggal', 'opt_id' => $mhs['Jenis_Domisili']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Alamat Domisili / Nama Pondok</th>
        											<td><?=$mhs['Tempat_Domisili'];?></td>
        										</tr>
        										<tr>
        											<th>No. Telp Domisili</th>
        											<td><?=$mhs['No_Telp_Hp'];?></td>
        										</tr>
        										<tr>
        											<th>Transportasi</th>
        											<td><<?=(!empty($mhs['Transportasi']))?getDataRow('ref_option',['opt_group' => 'alat_transport', 'opt_id' => $mhs['Transportasi']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Status Asal Sekolah</th>
        											<td><?=$mhs['Status_Asal_Sekolah'];?></td>
        										</tr>
        										<tr>
        											<th>Jenis Sekolah Asal</th>
        											<td><?=$mhs['Jenis_SLTA'];?></td>
        										</tr>
        										<tr>
        											<th>Jurusan</th>
        											<td><?=$mhs['Kejuruan_SLTA'];?></td>
        										</tr>
        										
        										<tr>
        											<th>Nama Asal Sekolah</th>
        											<td><?=$mhs['Nama_Lengkap_SLTA_Asal'];?></td>
        										</tr>
        										
        										<tr>
        											<th>Alamat Sekolah</th>
        											<td><?=$mhs['Alamat_Lengkap_Sekolah_Asal'];?></td>
        										</tr>
        										<tr>
        											<th>Tahun Lulus</th>
        											<td><?=$mhs['Th_Lulus_SLTA'];?></td>
        										</tr>
        										<tr>
        											<th>No. Seri Ijazah</th>
        											<td><?=$mhs['No_Seri_Ijazah_SLTA'];?></td>
        										</tr>
        				                      
        				                    </table>
        				                </div>
        		                    </div>
        		                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">Dosen Wali</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <th style="width:40%">Nama</th>
                                            <td><?=$mhs['dosen_wali'];?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title">BIODATA ORANG TUA</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
        		                    <div class="col-6">
        		                        <div class="col-12">
                                            <h5>Ayah</h5>
                                        </div>
        		                        <div class="table-responsive">
        				                    <table class="table table-sm">
        				                    	<tr>
        					                        <th style="width:40%">Nama</th>
        					                        <td><?=$ortu['Nama_Ayah'];?></td>
        										</tr>
        										<tr>
        											<th >NIK</th>
        											<td><?=$ortu['Nomor_KTP_Ayah'];?></td>
        										</tr>
        										<tr>
        											<th>Tempat, Tgl. lahir</th>
        											<td><?=$ortu['Tempat_Lhr_Ayah'];?>, <?=$ortu['Tgl_Lhr_Ayah'];?></td>
        										</tr>
        										<tr>
        											<th>Agama</th>
        											<td><?=(!empty($ortu['Agama_Ayah']))?getDataRow('ref_option',['opt_group' => 'agama', 'opt_id' => $ortu['Agama_Ayah']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Gol. Darah</th>
        											<td><?=$ortu['Gol_Darah_Ayah'];?></td>
        										</tr>
        										<tr>
        											<th>Kewarganegaraan</th>
        											<td><?=$ortu['Kewarganegaraan_Ayah'];?></td>
        										</tr>
        										<tr>
        											<th>Alamat</th>
        											<td><?=$ortu['Alamat_Ayah'];?> <?=$ortu['No_Rmh_Ayah'];?> <?=$ortu['Dusun_Ayah'];?> <?=$ortu['RT_Ayah'];?> <?=$ortu['RW_Ayah'];?> <?=$ortu['Desa_Ayah'];?> <?=$ortu['Kec_Ayah'];?> <?=$ortu['Kab_Ayah'];?> <?=$ortu['Prov_Ayah'];?> <?=$ortu['Kode_Pos_Ayah'];?></td>
        										</tr>
        										<tr>
        											<th>Pendidikan</th>
        											<td><?=(!empty($ortu['Pendidikan_Terakhir_Ayah']))?getDataRow('ref_option',['opt_group' => 'jenj_pendidikan', 'opt_id' => $ortu['Pendidikan_Terakhir_Ayah']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Penghasilan</th>
        											<td><?=(!empty($ortu['Penghasilan_Ayah']))?getDataRow('ref_option',['opt_group' => 'penghasilan', 'opt_id' => $ortu['Penghasilan_Ayah']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Pekerjaan</th>
        											<td><?=(!empty($ortu['Pekerjaan_Ayah']))?getDataRow('ref_option',['opt_group' => 'pekerjaan', 'opt_id' => $ortu['Pekerjaan_Ayah']])['opt_val']:"-";?></td>
        										</tr>
        										
        				                    </table>
        				                </div>
        		                    </div>
        		                    <div class="col-6">
        		                        <div class="col-12">
                                            <h5>Ibu</h5>
                                        </div>
        		                    	<div class="table-responsive">
        				                    <table class="table table-sm">
        				                    	<tr>
        					                        <th style="width:40%">Nama</th>
        					                        <td><?=$ortu['Nama_Ibu'];?></td>
        										</tr>
        										<tr>
        											<th >NIK</th>
        											<td><?=$ortu['Nomor_KTP_Ibu'];?></td>
        										</tr>
        										<tr>
        											<th>Tempat, Tgl. lahir</th>
        											<td><?=$ortu['Tempat_Lhr_Ibu'];?>, <?=$ortu['Tgl_Lhr_Ibu'];?></td>
        										</tr>
        										<tr>
        											<th>Agama</th>
        											<td><?=(!empty($ortu['Agama_Ibu']))?getDataRow('ref_option',['opt_group' => 'agama', 'opt_id' => $ortu['Agama_Ibu']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Gol. Darah</th>
        											<td><?=$ortu['Gol_Darah_Ibu'];?></td>
        										</tr>
        										<tr>
        											<th>Kewarganegaraan</th>
        											<td><?=$ortu['Kewarganegaraan_Ibu'];?></td>
        										</tr>
        										<tr>
        											<th>Alamat</th>
        											<td><?=$ortu['Alamat_Ibu'];?> <?=$ortu['No_Rmh_Ibu'];?> <?=$ortu['Dusun_Ibu'];?> <?=$ortu['RT_Ibu'];?> <?=$ortu['RW_Ibu'];?> <?=$ortu['Desa_Ibu'];?> <?=$ortu['Kec_Ibu'];?> <?=$ortu['Kab_Ibu'];?> <?=$ortu['Prov_Ibu'];?> <?=$ortu['Kode_Pos_Ibu'];?></td>
        										</tr>
        										<tr>
        											<th>Pendidikan</th>
        											<td><?=(!empty($ortu['Pendidikan_Terakhir_Ibu']))?getDataRow('ref_option',['opt_group' => 'jenj_pendidikan', 'opt_id' => $ortu['Pendidikan_Terakhir_Ibu']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Penghasilan</th>
        											<td><?=(!empty($ortu['Penghasilan_Ibu']))?getDataRow('ref_option',['opt_group' => 'penghasilan', 'opt_id' => $ortu['Penghasilan_Ibu']])['opt_val']:"-";?></td>
        										</tr>
        										<tr>
        											<th>Pekerjaan</th>
        											<td><?=(!empty($ortu['Pekerjaan_Ibu']))?getDataRow('ref_option',['opt_group' => 'pekerjaan', 'opt_id' => $ortu['Pekerjaan_Ibu']])['opt_val']:"-";?></td>
        										</tr>
        				                      
        				                    </table>
        				                </div>
        		                    </div>
        		                </div>
                            </div>
                        </div>            
		                
		                
		                <div class="row">
		                    <a href="javascript:void(0)" onclick="edit('db_data_diri_mahasiswa','<?=$mhs['id']?>'); return false;" class="btn btn-primary btn-block"><b>Edit Profil</b></a>
		                </div>
        	                
                  </div>
                  
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="his_pdk">
                      <div class="mailbox-controls">
                          <div class="row">
                              
                                <div class="btn-group">
                                  <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Tambah Histori Pendidikan" data-toggle="modal" data-target="#HisPdkModal">
                                    <i class="fa fa-plus"></i> Tambah Histori Pendidikan
                                  </button>
                                  
                                </div>
                          </div>
                                
                        
                      </div>
                      <div class="table-responsive">
                        <table id="data_his_pdk" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>NIM</th>
                                    <th>Jenis Pendaftaran</th>
                                    <th>Periode</th>
                                    <th>Tgl Masuk</th>
                                    <th>Prodi</th>
                                    <th>Program</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
        
                            </tbody>
        
                        </table>
                      </div>
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="nilai">
                        <div class="mailbox-controls">
                          <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                        <label class="col-sm-3">Prodi</label>
                                        <div class="col-sm-9">
                                            <select name="prodi_his" id="prodi_his" class="form-control form-control-sm select2" onchange="loadSMTNilai()" style="width:100%">
        						                	
        						            </select>
        						        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                        <label class="col-sm-3">SMT</label>
                                        <div class="col-sm-9">
                                            <select name="s" id="s" class="form-control form-control-sm  select2" style="width:100%">
        						                	
        						            </select>
        						        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                  <button type="button" class="btn btn-success btn-xs" data-placement="top" title="Load Data Nilai" onclick="loadNilai()">
                                    <i class="fa fa-sync"></i> 
                                  </button>
                                  <button type="button" class="btn btn-success btn-xs" data-placement="top" title="Tambah Matakuliah Yang Belum Ditempuh / Transfer Untuk Mahasiswa Pindahan" onclick="loadFormTambahMk()">
                                    <i class="fa fa-plus"></i> 
                                  </button>
                                </div>
                          </div>
                                
                        
                      </div>
                      <div class="table-responsive">
                        <table id="data_nilai" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Kode</th>
                                    <th>Matakuliah</th>
                                    <th>SMT</th>
                                    <th>UTS</th>
                                    <th>TGS</th>
                                    <th>UAS</th>
                                    <th>P</th>
                                    <th>Nilai</th>
                                    <th>H</th>
                                    
                                    <th><?php if(session()->get('akun_level') == "Admin") { echo "S";} else{ echo "Status";}?></th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
        
                            </tbody>
        
                        </table>
                      </div>
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="krs">
                        <div class="table-responsive">
                            <table id="data_krs" class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2">No.</th>
                                        <th rowspan="2">Tahun</th>
                                        <th rowspan="2">Program</th>
                                        <th rowspan="2">Prodi</th>
                                        <!--<th rowspan="2">SMT</th>-->
                                        <th rowspan="2">Status</th>
                                        <th rowspan="2">Validasi BAK</th>
                                        <th rowspan="2">Validasi Publikasi</th>
                                        <th class="text-center" colspan="2">Berkas</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
            
                                </tbody>
            
                            </table>
                        </div>
                  </div>
                  <div class="tab-pane" id="akm">
                        <div class="table-responsive">
                        <table id="data_akm" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th>Th. Akademik</th>
                                    <th>Prodi</th>
                                    <th>Program</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Jml SKS</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
        
                            </tbody>
        
                        </table>
                      </div>
                  </div>
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
<div class="modal fade" id="editFotoModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_edit_foto" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row " hidden>
                        <label class="col-sm-3 col-form-label">Kode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="id_foto_data_diri" name="id_foto_data_diri" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept="image/png, image/jpeg, image/jpg" class="custom-file-input" id="Foto_Diri" name="Foto_Diri"
                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])"> >
                                    
                                    <label class="custom-file-label" for="Foto_Diri">Choose file</label>
                                    
                                </div>
                                <div class="invalid-feedback"></div>
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
                    <button type="button" class="btn btn-primary" onclick="simpan_foto()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editDataDiriModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_edit_data_diri" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Diri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row " hidden>
                        <label class="col-sm-3 col-form-label">Kode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="id_data_diri" name="id_data_diri" />
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">BIODATA DIRI</h5>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-12 col-sm-6 pr-4">
                                    <div class="form-group">
                                        <label class="col-form-label">Nama Lengkap <code>(*)</code></label>
                                            <input type="text" class="form-control" id="Nama_Lengkap" name="Nama_Lengkap" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">NISN <small><em>(Jika
                                                    ada)</em></small></label>
                                            <input type="text" class="form-control" id="NISN" name="NISN" />
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">NIK <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="No_KTP" maxlength="16" name="No_KTP" />
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">No. KK <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="No_KK" maxlength="16"
                                                        name="No_KK" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Tempat Lahir <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="Kota_Lhr" name="Kota_Lhr" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Tgl Lahir <code>(*)</code></label>
        
                                                    <div class="input-group date" id="reservationdate"
                                                        data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input"
                                                            id="Tgl_Lhr" data-toggle="datetimepicker" name="Tgl_Lhr"
                                                            data-target="#reservationdate" placeholder="YYYY-MM-DD" />
                                                        <div class="input-group-append" data-target="#reservationdate"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                        <div class="invalid-feedback">
        
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">

                                            <div class="form-group">
                                                <label class="col-form-label">Gender <code>(*)</code></label>
                                                    <select name="Jenis_Kelamin" id="Jenis_Kelamin" class="form-control select2">
                                                        <option></option>
                                                        <option value="L" > Laki-laki </option>
                                                        <option value="P" > Perempuan </option>
                                                    </select>
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Golongan Darah</label>
                                                    <select name="Gol_Darah" id="Gol_Darah" class="form-control select2">
                                                        <<option value="">  </option>
        													<option value="A" > A </option>
        													<option value="B" > B </option>
        													<option value="AB" > AB </option>
        													<option value="O" > O </option>
                                                    </select>
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Agama <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Agama', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Agama"',null,null, ['opt_group'=>'agama']);
                                                ?>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Kewarganegaraan <code>*</code></label>
                                            <input type="text" class="form-control" id="Kewarganegaraan" name="Kewarganegaraan" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Jalan / Gang<code>(jika ada)</code></label>
                                                    <input type="text" class="form-control" id="Alamat" name="Alamat" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                        
                                            <div class="form-group">
                                                <label class="col-form-label">No. Rumah <code>( jika ada)</code></label>
                                                    <input type="text" class="form-control" id="No_Rmh" name="No_Rmh" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="col-form-label">RT<code>(*)</code></label>
                                                    <input type="text" class="form-control" id="RT" name="RT" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="col-form-label">RW<code>(*)</code></label>
                                                    <input type="text" class="form-control" id="RW" name="RW" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Dusun<code>(*)</code></label>
                                                <input type="text" class="form-control" id="Dusun" name="Dusun" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Propinsi <code>(*)</code></label>

                                            <select name="Prov" id="Prov" class="form-control select2">

                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kabupaten <code>(*)</code></label>

                                            <select name="Kab" id="Kab" class="form-control select2">

                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kecamatan <code>(*)</code></label>

                                            <select name="Kec" id="Kec" class="form-control select2">

                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Desa <code>(*)</code></label>
        
                                                    <select name="Desa" id="Desa" class="form-control select2">
        
                                                    </select>
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
        
                                            <div class="form-group">
                                                <label class="col-form-label">Kodepos <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="Kode_Pos" name="Kode_Pos" />
        
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Email <code>(*)</code></label>
                                            <input type="text" class="form-control" id="Email"
                                                name="Email" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">No HP <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="No_HP"
                                                        name="No_HP" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">No WA <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="no_wa"
                                                        name="no_wa" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                </div>
                                <div class="col-12 col-sm-6 pl-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Anak Ke- <code>(*)</code></label>
                                                    <input type="number" class="form-control" id="Anak_Ke"
                                                        name="Anak_Ke" />
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Jml. Saudara <code>(*)</code></label>
                                                    <input type="number" class="form-control" id="Jml_Saudara"
                                                        name="Jml_Saudara" />
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Pekerjaan <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Pekerjaan', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Pekerjaan"',null,null, ['opt_group'=>'pekerjaan']);
                                                ?>

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Status Perkawinan <code>(*)</code></label>
                                            <select name="Status_Perkawinan" id="Status_Perkawinan" class="form-control select2">
                                                <<option value="">  </option>
													<option value="Menikah" >Menikah</option>
													<option value="Belum Menikah" >Belum Menikah</option>
													<option value="Duda" >Duda</option>
													<option value="Janda" >Janda</option>
                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Biaya Ditanggung Oleh? <code>(*)</code></label>
                                            <select name="Biaya_ditanggung" id="Biaya_ditanggung" class="form-control select2">
                                                <<option value="">  </option>
													<option value="Orang Tua" >Orang Tua</option>
													<option value="Wali" >Wali</option>
													<option value="Mandiri" >Mandiri</option>
													<option value="Beasiswa Tahfidz" >Beasiswa Tahfidz</option>
													<option value="Beasiswa IPNU-IPPNU" >Beasiswa IPNU-IPPNU</option>
													<option value="Beasiswa Tidak Mampu IAIBAFA" >Beasiswa Tidak Mampu IAIBAFA</option>
													<option value="Beasiswa Tidak Mampu Pemerintah" >Beasiswa Tidak Mampu Pemerintah</option>
													<option value="Beasiswa Berprestasi IAIBAFA" >Beasiswa Berprestasi IAIBAFA</option>
													<option value="Beasiswa Berprestasi Pemerintah" >Beasiswa Berprestasi Pemerintah</option>
													<option value="Beasiswa Guru Madin Pemprof Jatim" >Beasiswa Guru Madin Pemprof Jatim</option>
                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Jns. Domisili <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Jenis_Domisili', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Jenis_Domisili" onchange="getDomisili()"',null,null, ['opt_group'=>'jns_tinggal']);
                                                ?>

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="form-group" id="box_alamat_pondok" hidden>
                                        <label class="col-form-label">Alamat Domisili / Nama Pondok <code>(*)</code></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="Tempat_Domisili"
                                                name="Tempat_Domisili" />
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="box_no_telp_domisili" hidden>
                                        <label class="col-form-label">No. Telp. Domisili <code>(*)</code></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="No_Telp_Hp"
                                                name="No_Telp_Hp" />
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Transportasi <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Transportasi', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Transportasi"',null,null, ['opt_group'=>'alat_transport']);
                                                ?>

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Punya KKS/PIP/PKH/KIP? <code>(*)</code></label>
                                            <select name="Penerima_KPS" onchange="getKKS()" id="Penerima_KPS"
                                                class="form-control select2">
                                                <option></option>
                                                <option value="1"> Ya </option>
                                                <option value="0"> Tidak </option>
                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group" id="box_no_kks" hidden>
                                        <label class="col-form-label">No. KKS/PIP/PKH</label>
                                            <input type="text" class="form-control" id="No_KPS"
                                                name="No_KPS" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Status Asal Sekolah<code>(*)</code></label>
                                            <select name="Status_Asal_Sekolah" id="Status_Asal_Sekolah" class="form-control select2">
                                                <<option value="">  </option>
													<option value="Negeri" >Negeri</option>
													<option value="Swasta" >Swasta</option>
                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Jenis Asal Sekolah<code>(*)</code></label>
                                            <select name="Jenis_SLTA" id="Jenis_SLTA" class="form-control select2">
                                                <<option value="">  </option>
													<option value="MA" > MA </option>
													<option value="SMA" > SMA </option>
													<option value="SMK" > SMK </option>
													<option value="Paket C" > Paket C </option>
													<option value="Madrasah Diniyyah Kesetaraan" > Madrasah Diniyyah Kesetaraan </option>
                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Jurusan <code>(*)</code></label>
                                            <input type="text" class="form-control" id="Kejuruan_SLTA"
                                                name="Kejuruan_SLTA" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Nama Asal Sekolah <code>(*)</code></label>
                                            <input type="text" class="form-control" id="Nama_Lengkap_SLTA_Asal"
                                                name="Nama_Lengkap_SLTA_Asal" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="form-group">
    					                <label for="asal_sekolah">Alamat Lengkap Sekolah Asal</label>
    					                <input type="text" class="form-control" id="Alamat_Lengkap_Sekolah_Asal" name="Alamat_Lengkap_Sekolah_Asal" >
    					                <div class="invalid-feedback"></div>
    					            </div>
    					            <div class="form-group">
                                        <label class="col-form-label">Tahun Lulus SLTA <code>(*)</code></label>
                                            <input type="text" class="form-control" id="Th_Lulus_SLTA"
                                                name="Th_Lulus_SLTA" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">No. Seri Ijazah SLTA</label>
                                            <input type="text" class="form-control" id="No_Seri_Ijazah_SLTA"
                                                name="No_Seri_Ijazah_SLTA" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Dosen Wali</h5>
                        </div>
                        <div class="card-body">
                            
                            <div class="form-group">
                                <label class="col-form-label">Nama Dosen Wali </label>
                                    <input type="text" class="form-control" id="dosen_wali" name="dosen_wali" />

                                    <div class="invalid-feedback">

                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title">IDENTITAS ORANG TUA</h5>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-12 col-lg-6 pr-4">
                                    <h5 class="mt-1 mb-1">Identitas Ayah</h5>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-form-label">Nama Ayah <code>(*)</code></label>
                                            <input type="text" class="form-control" id="Nama_Ayah" name="Nama_Ayah" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">NIK <code>(*)</code></label>
                                            <input type="text" class="form-control" id="Nomor_KTP_Ayah" maxlength="16"
                                                name="Nomor_KTP_Ayah" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Tempat Lahir <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="Tempat_Lhr_Ayah" name="Tempat_Lhr_Ayah" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Tgl Lahir <code>(*)</code></label>
        
                                                    <div class="input-group date" id="reservationdate_ayah"
                                                        data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input"
                                                            id="Tgl_Lhr_Ayah" data-toggle="datetimepicker" name="Tgl_Lhr_Ayah"
                                                            data-target="#reservationdate_ayah" placeholder="YYYY-MM-DD" />
                                                        <div class="input-group-append" data-target="#reservationdate_ayah"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                        <div class="invalid-feedback">
        
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">

                                            <label class="col-form-label">Agama <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Agama_Ayah', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Agama_Ayah"',null,null, ['opt_group'=>'agama']);
                                                ?>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Golongan Darah</label>
                                                    <select name="Gol_Darah_Ayah" id="Gol_Darah_Ayah" class="form-control select2">
                                                        <<option value="">  </option>
        													<option value="A" > A </option>
        													<option value="B" > B </option>
        													<option value="AB" > AB </option>
        													<option value="O" > O </option>
                                                    </select>
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="cek_alamat_ayah">
                                            <label class="form-check-label" for="cek_alamat_ayah">Beri tanda checklis jika alamat ayah sama dengan mahasiswa</label>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kewarganegaraan <code>*</code></label>
                                            <input type="text" class="form-control" id="Kewarganegaraan_Ayah" name="Kewarganegaraan_Ayah" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Jalan / Gang<code>(jika ada)</code></label>
                                                    <input type="text" class="form-control" id="Alamat_Ayah" name="Alamat_Ayah" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                        
                                            <div class="form-group">
                                                <label class="col-form-label">No. Rumah <code>( jika ada)</code></label>
                                                    <input type="text" class="form-control" id="No_Rmh_Ayah" name="No_Rmh_Ayah" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="col-form-label">RT<code>(*)</code></label>
                                                    <input type="text" class="form-control" id="RT_Ayah" name="RT_Ayah" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="col-form-label">RW<code>(*)</code></label>
                                                    <input type="text" class="form-control" id="RW_Ayah" name="RW_Ayah" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Dusun<code>(*)</code></label>
                                                <input type="text" class="form-control" id="Dusun_Ayah" name="Dusun_Ayah" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Propinsi <code>(*)</code></label>

                                            <select name="Prov_Ayah" id="Prov_Ayah" class="form-control select2">

                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kabupaten <code>(*)</code></label>

                                            <select name="Kab_Ayah" id="Kab_Ayah" class="form-control select2">

                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kecamatan <code>(*)</code></label>

                                            <select name="Kec_Ayah" id="Kec_Ayah" class="form-control select2">

                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Desa <code>(*)</code></label>
        
                                                    <select name="Desa_Ayah" id="Desa_Ayah" class="form-control select2">
        
                                                    </select>
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
        
                                            <div class="form-group">
                                                <label class="col-form-label">Kodepos <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="Kode_Pos_Ayah" name="Kode_Pos_Ayah" />
        
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Pekerjaan Ayah <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Pekerjaan_Ayah', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Pekerjaan_Ayah"',null,null, ['opt_group'=>'pekerjaan']);
                                                ?>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Pendidikan Ayah <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Pendidikan_Terakhir_Ayah', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Pendidikan_Terakhir_Ayah"',null,null, ['opt_group'=>'jenj_pendidikan']);
                                                ?>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Penghasilan Ayah <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Penghasilan_Ayah', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Penghasilan_Ayah"',null,null, ['opt_group'=>'penghasilan']);
                                                ?>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 pl-4">
                                    <h5 class="mt-1 mb-1">Identitas Ibu</h5>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-form-label">Nama Ibu <code>(*)</code></label>
                                            <input type="text" class="form-control" id="Nama_Ibu" name="Nama_Ibu" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">NIK <code>(*)</code></label>
                                            <input type="text" class="form-control" id="Nomor_KTP_Ibu" maxlength="16"
                                                name="Nomor_KTP_Ibu" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Tempat Lahir <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="Tempat_Lhr_Ibu" name="Tempat_Lhr_Ibu" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Tgl Lahir <code>(*)</code></label>
        
                                                    <div class="input-group date" id="reservationdate_ibu"
                                                        data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input"
                                                            id="Tgl_Lhr_Ibu" data-toggle="datetimepicker" name="Tgl_Lhr_Ibu"
                                                            data-target="#reservationdate_ibu" placeholder="YYYY-MM-DD" />
                                                        <div class="input-group-append" data-target="#reservationdate_ibu"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                        <div class="invalid-feedback">
        
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">

                                            <label class="col-form-label">Agama <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Agama_Ibu', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Agama_Ibu"',null,null, ['opt_group'=>'agama']);
                                                ?>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Golongan Darah</label>
                                                    <select name="Gol_Darah_Ibu" id="Gol_Darah_Ibu" class="form-control select2">
                                                        <<option value="">  </option>
        													<option value="A" > A </option>
        													<option value="B" > B </option>
        													<option value="AB" > AB </option>
        													<option value="O" > O </option>
                                                    </select>
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="cek_alamat_ibu">
                                            <label class="form-check-label" for="cek_alamat_ibu">Beri tanda checklis jika alamat ibu sama dengan mahasiswa</label>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kewarganegaraan <code>*</code></label>
                                            <input type="text" class="form-control" id="Kewarganegaraan_Ibu" name="Kewarganegaraan_Ibu" />

                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Jalan / Gang<code>(jika ada)</code></label>
                                                    <input type="text" class="form-control" id="Alamat_Ibu" name="Alamat_Ibu" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                        
                                            <div class="form-group">
                                                <label class="col-form-label">No. Rumah <code>( jika ada)</code></label>
                                                    <input type="text" class="form-control" id="No_Rmh_Ibu" name="No_Rmh_Ibu" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="col-form-label">RT<code>(*)</code></label>
                                                    <input type="text" class="form-control" id="RT_Ibu" name="RT_Ibu" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="col-form-label">RW<code>(*)</code></label>
                                                    <input type="text" class="form-control" id="RW_Ibu" name="RW_Ibu" />
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Dusun<code>(*)</code></label>
                                                <input type="text" class="form-control" id="Dusun_Ibu" name="Dusun_Ibu" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Propinsi <code>(*)</code></label>

                                            <select name="Prov_Ibu" id="Prov_Ibu" class="form-control select2">

                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kabupaten <code>(*)</code></label>

                                            <select name="Kab_Ibu" id="Kab_Ibu" class="form-control select2">

                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Kecamatan <code>(*)</code></label>

                                            <select name="Kec_Ibu" id="Kec_Ibu" class="form-control select2">

                                            </select>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Desa <code>(*)</code></label>
        
                                                    <select name="Desa_Ibu" id="Desa_Ibu" class="form-control select2">
        
                                                    </select>
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
        
                                            <div class="form-group">
                                                <label class="col-form-label">Kodepos <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="Kode_Pos_Ibu" name="Kode_Pos_Ibu" />
        
        
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Pekerjaan Ibu <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Pekerjaan_Ibu', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Pekerjaan_Ibu"',null,null, ['opt_group'=>'pekerjaan']);
                                                ?>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Pendidikan Ibu <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Pendidikan_Terakhir_Ibu', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Pendidikan_Terakhir_Ibu"',null,null, ['opt_group'=>'jenj_pendidikan']);
                                                ?>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Penghasilan Ibu <code>(*)</code></label>
                                            <?php
                                                
                                                echo cmb_dinamis('Penghasilan_Ibu', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Penghasilan_Ibu"',null,null, ['opt_group'=>'penghasilan']);
                                                ?>
                                            <div class="invalid-feedback">

                                            </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_data_diri()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="HisPdkModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_his_pdk" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelHis">Tambah Histori Pendidikan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row " hidden>
                        <label class="col-sm-3 col-form-label">Kode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="id_his_pdk" name="id_his_pdk" />
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Periode Pendaftaran</label>
                        <div class="col-sm-9">
                            <select name="mulai_smt" id="mulai_smt" class="form-control select2" style="width: 100%;">
                                <option></option>
                                
                                <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                    
                                    foreach ($tahunAkademik as $key ) {
                                ?>
                                <option value="<?=$key->kode?>" ><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                <?php    }    ?>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Jenis Pendaftaran</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('jns_daftar', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="jns_daftar"  style="width:100%;"',null,null, ['opt_group'=>'jns_pendaftaran']);
                            ?>
                            <div class="invalid-feedback"></div>

                        </div>
                    </div>
                                    
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Tgl Masuk</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="tgl_masuk_date"
                                data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    id="tgl_masuk" data-toggle="datetimepicker" name="tgl_masuk"
                                    data-target="#tgl_masuk_date" placeholder="YYYY-MM-DD" />
                                <div class="input-group-append" data-target="#tgl_masuk_date"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                                    
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Program</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Program', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="Program"  style="width:100%;"',null,null, ['opt_group'=>'program_kuliah']);
                            ?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                                        
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Prodi</label>
                        <div class="col-sm-9">
                            <?php
                                
                                echo cmb_dinamis('Prodi', 'prodi', 'nm_prodi', 'singkatan', null, null, 'id="Prodi"');
                                ?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                                    
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Kelas</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Kelas', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Kelas"  style="width:100%;"',null,null, ['opt_group'=>'program_kelas']);
                            ?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">NIM</label>
                        <div class="col-sm-9">
                            <div class="input-group ">
                                <input type="text" class="form-control" id="NIM" name="NIM" />
                                <div class="input-group-append">
                                    
                                    <a role="button" class="btn btn-success" title="Generate NIM" data-palcement="top"  href="javascript:void(0)" onclick="generateNim()">
                                        <i class="fa fa-sync"></i>
                                    </a>
                                    
                                </div>
                            </div>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Status</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('status', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="status"  style="width:100%;" onchange="changeStatus()"',null,null, ['opt_group'=>'status_mhs']);
                            ?>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div id="box-lulus" hidden>
                    <hr>    
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Tahun Keluar</label>
                            <div class="col-sm-9">
                                
                                <select name="keluar_smt" id="keluar_smt" class="form-control select2" style="width: 100%;">
                                    <option></option>
                                    
                                    <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                        
                                        foreach ($tahunAkademik as $key ) {
                                    ?>
                                    <option value="<?=$key->kode?>" ><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                    <?php    }    ?>
                                </select>
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Jenis Keluar</label>
                            <div class="col-sm-9">
                                <?php
                                    echo cmb_dinamis('jns_keluar', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="jns_keluar" style="width:100%"', null, null, ['opt_group' => 'jns_keluar', 'is_aktif' => 'Y']);
                                ?>
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Tgl. Keluar / Lulus</label>
                            <div class="col-sm-9">
                                <div class="input-group date" id="tgl_keluar_date"
                                    data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        id="tgl_keluar" data-toggle="datetimepicker" name="tgl_keluar"
                                        data-target="#tgl_keluar_date" placeholder="YYYY-MM-DD" />
                                    <div class="input-group-append" data-target="#tgl_keluar_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Tgl. SK Yudisium / Keluar</label>
                            <div class="col-sm-9">
                                <div class="input-group date" id="tgl_yudisium_date"
                                    data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        id="tgl_sk_yudisium" data-toggle="datetimepicker" name="tgl_sk_yudisium"
                                        data-target="#tgl_yudisium_date" placeholder="YYYY-MM-DD" />
                                    <div class="input-group-append" data-target="#tgl_yudisium_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-3">No. SK Yudisium / Keluar</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="sk_yudisium" name="sk_yudisium" />
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>  
                        <div class="form-group row">
                            <label class="col-form-label col-sm-3">Keterangan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="ket" name="ket" />
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>  
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Asal PT</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nm_pt_asal" name="nm_pt_asal" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>    
                                    
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Asal Prodi</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="nm_prodi_asal"
                                name="nm_prodi_asal" />

                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">SKS Diakui</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="sks_diakui"
                                name="sks_diakui" />

                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan_histori_pddk()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_upload_syarat_krs" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_upload_krs" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Syarat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row" hidden>
                        <label class="col-sm-3 col-form-label">Kode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="id_krs" name="id_krs" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jenis Berkas</label>
                        <div class="col-sm-9">
                            <select name="jns_berkas" id="jns_berkas" class="form-control select2">
                                <<option value="">  </option>
									<option value="pembayaran" >Pembayaran KRS</option>
									<option value="publikasi" >Publikasi</option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                            
                        </div>
                        
                    </div>
                    
                            
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">File</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept="image/png, image/jpeg, image/jpg" class="custom-file-input" id="file_syarat" name="file_syarat"
                                        oninput="pic_syarat.src=window.URL.createObjectURL(this.files[0])"> >
                                    
                                    <label class="custom-file-label" for="file_syarat">Choose file</label>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                            </div>
                            
                            <div class="col-sm-4 pt-2">
                                <div class="position-relative">
                                    <img id="pic_syarat" class="img-fluid" />
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="upload_krs()">Simpan </button>
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
<!-- InputMask -->
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>

<script>
var table;
$(function() {
    bsCustomFileInput.init();
    $('[data-mask]').inputmask();
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $(document).ready(function(){
        
        const button = document.getElementById('waButton');
        let link_ref = "<?=(!empty(getDataRow('pmb_affiliate', ['id_referrer' => $mhs['id']])['link_referral']))?getDataRow('pmb_affiliate', ['id_referrer' => $mhs['id']])['link_referral']:'';?>";
        let text = "Buat kalian yang pingin jadi *Akademisi yang Santri dan Santri yang Akademisi*... Ayo segera gabung di kampus *IAI Bani Fattah Jombang || The Center Of Tafaqquh Fiddin*... Ayoo tunggu apalagi Klik tautan berikut ini.... ";
        
        // let sharehref = `whatsapp://send?text=${encodeURIComponent(imageSrc)}`;
        
        //button.setAttribute('href', 'whatsapp://send?text='+text+link_ref);
        button.setAttribute('href', 'https://api.whatsapp.com/send?text='+text+link_ref);
        button.setAttribute('target', '_blank');
    });
    
    $('#editFotoModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#pic').removeAttr('src');
        $(this).find('#username').attr('readonly', false);
    });
    $('#editDataDiriModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#pic').removeAttr('src');
        $(this).find('#username').attr('readonly', false);
    });
    $('#HisPdkModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
    });
    $('#modal_upload_syarat_krs').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#pic_syarat').removeAttr('src');
    });
    $('#reservationdate, #reservationdate_ayah, #reservationdate_ibu, #tgl_masuk_date, #tgl_keluar_date, #tgl_yudisium_date').datetimepicker({
        format: 'YYYY-MM-DD',
        viewMode: 'years'
    });
    
    // Autocomplete Select2
    $('#Prov').select2({
        placeholder: '--- Cari Propinsi ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getWilayahAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'provinsi',
                    groupBy: 'provinsi',
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    $('#Kab').select2({
        placeholder: '--- Cari Kabupaten ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getKabAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'kabupaten',
                    groupBy: 'kabupaten',
                    whereProp: $('#Prov option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    $('#Kec').select2({
        placeholder: '--- Cari Kecamatan ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getKecAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'kecamatan',
                    groupBy: 'kecamatan',
                    whereProp: $('#Prov option:selected').val(),
                    whereKab: $('#Kab option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    $('#Desa').select2({
        placeholder: '--- Cari Desa ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getDesaAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'kelurahan',
                    groupBy: '',
                    whereProp: $('#Prov option:selected').val(),
                    whereKab: $('#Kab option:selected').val(),
                    whereKec: $('#Kec option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.text + " (" + item.kodepos + ")",
                            id: item.id,
                            kodepos: item.kodepos
                        }
                    }),
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    }).on('select2:select', function(e) {
        //console.log($(this).select2('data')[0]);
        //var data = $(this).find(':selected').val();
        //console.log($(this).select2('data')[0]);
        var data = $(this).select2('data')[0];
        $('#Kode_Pos').val(data.kodepos);
    });
    
    $('#Prov_Ayah').select2({
        placeholder: '--- Cari Propinsi ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getWilayahAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'provinsi',
                    groupBy: 'provinsi',
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    $('#Kab_Ayah').select2({
        placeholder: '--- Cari Kabupaten ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getKabAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'kabupaten',
                    groupBy: 'kabupaten',
                    whereProp: $('#Prov_Ayah option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    $('#Kec_Ayah').select2({
        placeholder: '--- Cari Kecamatan ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getKecAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'kecamatan',
                    groupBy: 'kecamatan',
                    whereProp: $('#Prov_Ayah option:selected').val(),
                    whereKab: $('#Kab_Ayah option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    $('#Desa_Ayah').select2({
        placeholder: '--- Cari Desa ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getDesaAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'kelurahan',
                    groupBy: '',
                    whereProp: $('#Prov_Ayah option:selected').val(),
                    whereKab: $('#Kab_Ayah option:selected').val(),
                    whereKec: $('#Kec_Ayah option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.text + " (" + item.kodepos + ")",
                            id: item.id,
                            kodepos: item.kodepos
                        }
                    }),
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    }).on('select2:select', function(e) {
        //console.log($(this).select2('data')[0]);
        //var data = $(this).find(':selected').val();
        //console.log($(this).select2('data')[0]);
        var data = $(this).select2('data')[0];
        $('#Kode_Pos_Ayah').val(data.kodepos);
    });
    
    $('#Prov_Ibu').select2({
        placeholder: '--- Cari Propinsi ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getWilayahAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'provinsi',
                    groupBy: 'provinsi',
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    $('#Kab_Ibu').select2({
        placeholder: '--- Cari Kabupaten ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getKabAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'kabupaten',
                    groupBy: 'kabupaten',
                    whereProp: $('#Prov_Ibu option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    $('#Kec_Ibu').select2({
        placeholder: '--- Cari Kecamatan ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getKecAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'kecamatan',
                    groupBy: 'kecamatan',
                    whereProp: $('#Prov_Ibu option:selected').val(),
                    whereKab: $('#Kab_Ibu option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
    $('#Desa_Ibu').select2({
        placeholder: '--- Cari Desa ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getDesaAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field: 'kelurahan',
                    groupBy: '',
                    whereProp: $('#Prov_Ibu option:selected').val(),
                    whereKab: $('#Kab_Ibu option:selected').val(),
                    whereKec: $('#Kec_Ibu option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.text + " (" + item.kodepos + ")",
                            id: item.id,
                            kodepos: item.kodepos
                        }
                    }),
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    }).on('select2:select', function(e) {
        //console.log($(this).select2('data')[0]);
        //var data = $(this).find(':selected').val();
        //console.log($(this).select2('data')[0]);
        var data = $(this).select2('data')[0];
        $('#Kode_Pos_Ibu').val(data.kodepos);
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
    
    $("#cek_alamat_ayah").click(function () {
		if ($(this).is(":checked")) {
			
			$('#Alamat_Ayah').val($('#Alamat').val());
            $('#No_Rmh_Ayah').val($('#No_Rmh').val());
            $('#Kewarganegaraan_Ayah').val($('#Kewarganegaraan').val());
            $('#Dusun_Ayah').val($('#Dusun').val());
            $('#RW_Ayah').val($('#RW').val());
            $('#RT_Ayah').val($('#RT').val());
            $('#Dusun_Ayah').val($('#Dusun').val());
            $('#Desa_Ayah').val($('#Desa option:selected').val()).trigger('change');
            $('#Kec_Ayah').val($('#Kec option:selected').val()).trigger('change');
            $('#Kab_Ayah').val($('#Kab option:selected').val()).trigger('change');
            $('#Prov_Ayah').val($('#Prov option:selected').val()).trigger('change');

		}else{
			$('#Alamat_Ayah').val('');
            $('#No_Rmh_Ayah').val('');
            $('#Kewarganegaraan_Ayah').val('');
            $('#Dusun_Ayah').val('');
            $('#RW_Ayah').val('');
            $('#RT_Ayah').val('');
            $('#Dusun_Ayah').val('');
            $('#Desa_Ayah').val('').trigger('change');
            $('#Kec_Ayah').val('').trigger('change');
            $('#Kab_Ayah').val('').trigger('change');
            $('#Prov_Ayah').val('').trigger('change');

		}
	})
	
	$("#cek_alamat_ibu").click(function () {
		if ($(this).is(":checked")) {
			
			$('#Alamat_Ibu').val($('#Alamat').val());
            $('#No_Rmh_Ibu').val($('#No_Rmh').val());
            $('#Kewarganegaraan_Ibu').val($('#Kewarganegaraan').val());
            $('#Dusun_Ibu').val($('#Dusun').val());
            $('#RW_Ibu').val($('#RW').val());
            $('#RT_Ibu').val($('#RT').val());
            $('#Dusun_Ibu').val($('#Dusun').val());
            $('#Desa_Ibu').val($('#Desa option:selected').val()).trigger('change');
            $('#Kec_Ibu').val($('#Kec option:selected').val()).trigger('change');
            $('#Kab_Ibu').val($('#Kab option:selected').val()).trigger('change');
            $('#Prov_Ibu').val($('#Prov option:selected').val()).trigger('change');

		}else{
			$('#Alamat_Ibu').val('');
            $('#No_Rmh_Ibu').val('');
            $('#Kewarganegaraan_Ibu').val('');
            $('#Dusun_Ibu').val('');
            $('#RW_Ibu').val('');
            $('#RT_Ibu').val('');
            $('#Dusun_Ibu').val('');
            $('#Desa_Ibu').val('').trigger('change');
            $('#Kec_Ibu').val('').trigger('change');
            $('#Kab_Ibu').val('').trigger('change');
            $('#Prov_Ibu').val('').trigger('change');

		}
	})
})

function reload_table(){
    table.ajax.reload(null, false);
}

function getKKS() {
    var val = $('#Penerima_KPS option:selected').val();
    if (val == "1") {
        $('#box_no_kks').attr('hidden', false)
    } else {
        $('#box_no_kks').attr('hidden', true)
    }
}

function changeStatus() {
    var val = $('#status option:selected').val();
    if (val == "D" || val == "K" || val == "L" || val == "N") {
        $('#box-lulus').attr('hidden', false)
    } else {
        $('#box-lulus').attr('hidden', true)
    }
}

function getDomisili() {
    var val = $('#Jenis_Domisili option:selected').val();
    if (val == 4 || val == 5 || val == 3 || val == 2 || val == 99) {
        $('#box_no_telp_domisili, #box_alamat_pondok').attr('hidden', false)
    } else {
        $('#box_no_telp_domisili, #box_alamat_pondok').attr('hidden', true)
    }
}

function loadHisPdk(id){
    $('#data_his_pdk').DataTable({
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
            "url": "<?php echo site_url("$controller/loadHisPdk") ?>",
            "type": "POST",
            "data": function(data) {
                data.id_data_diri = id;
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function generateNim(){
    var data = new FormData($("#form_his_pdk")[0]);
    
    Swal.fire({
        title: 'Anda yakin akan membuat NIM baru ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller");?>"+"/generate_nim",
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
                    	$('#NIM').val(data.nim);
                    	Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
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
                            $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
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
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    })
    
}

function hapus(id) {
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
                url: "<?php echo site_url("masterdata/$controller");?>",
                type: "post",
                data: "aksi=hapus&id=" + id,
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
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus',
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
                        });

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
                            icon: 'error',
                            title: 'Data gagal dihapus'
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function edit(data_edit, id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("$controller/getDataMhs");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                if( data_edit == 'foto'){
                    $('#editFotoModal').modal('show');
                }else if(data_edit == 'db_data_diri_mahasiswa'){
                    $('#editDataDiriModal').modal('show');
                }else{
                    $('#editDataOrtuModal').modal('show');
                }
                
                $.each(response.data, function(key, value) {
                    if (key != "Foto_Diri") {
                        $('#' + key).val(value);
                        if ($('#' + key).is('.select2')) {
                            
                               if (key != "Prov" || key != "Kab" || key != "Kec" || key != "Desa" || key != "Prov_Ayah" || key != "Kab_Ayah" || key != "Kec_Ayah" || key != "Desa_Ayah" || key != "Prov_Ibu" || key != "Kab_Ibu" || key != "Kec_Ibu" || key != "Desa_Ibu") {
                                    $('#' + key).val(value).trigger('change');
                                }
                                if (key == "Prov" || key == "Kab" || key == "Kec" || key == "Desa" || key == "Prov_Ayah" || key == "Prov" || key == "Kab" || key == "Kec" || key == "Desa" || key == "Kab_Ayah" || key == "Prov" || key == "Kab" || key == "Kec" || key == "Desa" || key == "Kec_Ayah" || key == "Prov" || key == "Kab" || key == "Kec" || key == "Desa" || key == "Desa_Ayah" || key == "Prov_Ibu" || key == "Kab_Ibu" || key == "Kec_Ibu" || key == "Desa_Ibu") {
                                    var newOption = new Option(value, value, true, true);
                                    $('#' + key).append(newOption).trigger('change');
                                }
                            
                        }
                    } else if (key == "Foto_Diri") {
                        if(value != null){
                            $('#pic').attr('src', "<?=base_url()?>/" + value);
                        }
                    }
                    if(key == 'username' || key == 'Kode'){
                        $('#' + key).attr('readonly',true);
                    }
                    if(key == 'id' ){
                        $('#id_data_diri').val(value);
                        $('#id_foto_data_diri').val(value);
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

function edit_his_pdk(id_his_pdk) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("$controller/getDataHisPdk");?>",
        data: "id_his_pdk=" + id_his_pdk,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#HisPdkModal').modal('show');
                $('#exampleModalLabelHis').text('Edit Histori Pendidikan');
                $.each(response.data, function(key, value) {
                    if ($('#' + key).is('.select2')) {
                        
                            $('#' + key).val(value).trigger('change');
                        
                    }else{
                        $('#' + key).val(value);
                    }
                });
                changeStatus();
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

function simpan_foto() {

    var data = new FormData($("#form_edit_foto")[0]);
    $('#form_edit_foto').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller");?>"+"/update_foto_mhs",
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
                    	$('#editFotoModal').modal('hide');
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
                            if(key != 'Foto_Diri'){
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
                            }else{
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
                            }
                            
                            
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
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    })

}

function simpan_data_diri() {

    var data = new FormData($("#form_edit_data_diri")[0]);
    
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller");?>"+"/update_data_diri_mhs",
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
                    	$('#editDataDiriModal').modal('hide');
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
                            if(key != 'Foto_Diri'){
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
                            }else{
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
                            }
                            
                            
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
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    })

}

function simpan_histori_pddk() {

    var data = new FormData($("#form_his_pdk")[0]);
    data.append('id_data_diri', "<?=$mhs['id'];?>");
    Swal.fire({
        title: 'Anda yakin akan menyimpan Histori Pendidikan ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller");?>"+"/simpan_histori_pddk",
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
                    	$('#HisPdkModal').modal('hide');
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            loadHisPdk(data.id_data_diri);
                        })
                    } else if (data.msg == 'warning'){
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                        $.each(data.validation, function(key, value) {
                            if(key != 'Foto_Diri'){
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
                            }else{
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
                            }
                            
                            
                        });
                    }else{
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            loadHisPdk(data.id_data_diri);
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    })

}

function hapus_his_pdk(id_his_pdk) {
   
    Swal.fire({
        title: 'Are you sure?',
        text: "Data akan dihapus!",
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
                url: "<?php echo site_url("$controller");?>"+"/hapus_his_pdk",
                type: "post",
                data: "id_his_pdk=" + id_his_pdk,
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
                    
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    }).then(() => {
                        loadHisPdk(data.id_data_diri);
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function loadProdiHisPdk(id_data_diri){
    
    $.ajax({
        url: "<?php echo site_url("$controller/loadProdiHisPdk");?>",
        method: "POST",
        data: {
            id_data_diri: id_data_diri
        },
        success: function(html) {
            $("#prodi_his").html(html);
            //loadPelajaran();
        }
    })
}

function loadSMTNilai(){
    var id_his_pdk = $('#prodi_his').find(':selected').val();
    $.ajax({
        url: "<?php echo site_url("$controller/loadSMTNilai");?>",
        method: "POST",
        data: {
            id_his_pdk: id_his_pdk
        },
        success: function(html) {
            $("#s").html(html);
            //loadPelajaran();
        }
    })
}

function loadNilai(){
    var id_his_pdk = $('#prodi_his').find(':selected').val();
    var smt = $('#s').find(':selected').val();
    if(id_his_pdk == ''){
        Swal.fire({
            icon: 'warning',
            title: 'Prodi tidak boleh kosong',
            allowOutsideClick: false
        })
    }else{
        $('#data_nilai').DataTable({
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
                "url": "<?php echo site_url("$controller/loadNilai") ?>",
                "type": "POST",
                "data": function(data) {
                    data.id_his_pdk = id_his_pdk;
                    data.smt = smt;
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });
    }
}

function simpan_uts(id) {
	var uts = $("#uts"+id).val();
	$.ajax({
		url: "<?php echo site_url("$controller/simpan_uts")?>",
        data: "id="+id+"&nilai_uts="+uts,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            if(data.status){
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
            }else{
                if(data.msg == 'warning'){
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai UTS: <pre><code>' +
								          JSON.stringify(data.validation)+
								        '</code></pre>',
                        allowOutsideClick: false,
                    })
                }else{
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    })
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            Swal.close();
        	Swal.fire({
                icon: 'error',
                title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
	})

}

function simpan_tugas(id) {
		var nilai = $("#tugas"+id).val();
		$.ajax({
			url: "<?php echo site_url("$controller/simpan_tugas")?>",
            data: "id="+id+"&nilai="+nilai,
            type: "POST",
        dataType: "JSON",
        success: function (data) {
            if(data.status){
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
            }else{
                if(data.msg == 'warning'){
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai Tugas: <pre><code>' +
								          JSON.stringify(data.validation)+
								        '</code></pre>',
                        allowOutsideClick: false,
                    })
                }else{
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    })
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            Swal.close();
        	Swal.fire({
                icon: 'error',
                title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
		})

	}
	
function simpan_uas(id) {
		var nilai = $("#uas"+id).val();
		$.ajax({
			url: "<?php echo site_url("$controller/simpan_uas")?>",
            data: "id="+id+"&nilai="+nilai,
            type: "POST",
        dataType: "JSON",
        success: function (data) {
            if(data.status){
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
            }else{
                if(data.msg == 'warning'){
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai Tugas: <pre><code>' +
								          JSON.stringify(data.validation)+
								        '</code></pre>',
                        allowOutsideClick: false,
                    })
                }else{
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    })
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            Swal.close();
        	Swal.fire({
                icon: 'error',
                title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
		})

	}

function simpan_p(id) {
		var nilai = $("#p"+id).val();
		$.ajax({
			url: "<?php echo site_url("$controller/simpan_p")?>",
            data: "id="+id+"&nilai="+nilai,
            type: "POST",
        dataType: "JSON",
        success: function (data) {
            if(data.status){
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
            }else{
                if(data.msg == 'warning'){
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        html : 'Gagal menyimpan nilai Tugas: <pre><code>' +
								          JSON.stringify(data.validation)+
								        '</code></pre>',
                        allowOutsideClick: false,
                    })
                }else{
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    })
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            Swal.close();
        	Swal.fire({
                icon: 'error',
                title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
		})

	}

function loadDataKrs(id_data_diri){
    
        $('#data_krs').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
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
                "url": "<?php echo site_url("$controller/loadDataKrs") ?>",
                "type": "POST",
                "data": function(data) {
                    data.id_data_diri = id_data_diri;
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });
}

function formulir(id_krs) {
    var link = "<?=base_url("akademik/krs/formulir_krs?id_krs=")?>"+id_krs;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Formulir Pemrograman KRS',
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      //reload_table:true,
      //tbl_id:'table_mk',
      scrollable:false
    });
    return false;
}

function getDataKrs(id_krs){
    $.ajax({
        type: "post",
        url: "<?php echo site_url("$controller/getDataKrs");?>",
        data: "id_krs=" + id_krs,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                
                $('#modal_upload_syarat_krs').modal('show');
                
                $.each(response.data, function(key, value) {
                    
                    if(key == 'id' ){
                        $('#id_krs').val(value);
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

function upload_krs() {

    var data = new FormData($("#form_upload_krs")[0]);
    $('#form_upload_krs').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller");?>"+"/upload_krs",
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
                    	$('#modal_upload_syarat_krs').modal('hide');
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            loadDataKrs(data.id_data_diri);
                        })
                    } else if (data.msg == 'warning'){
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                        $.each(data.validation, function(key, value) {
                            if( key == 'file_syarat'){
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.custom-file').find('.invalid-feedback').text(value);
                            }else{
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
                            }
                            
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
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    })

}

function lihat(link){
    //var link = link;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Bukti',
      message: iframe,
      ///link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      //printButton:true,
      //confirmButton:true,
      scrollable:false
    });
    return false;
}

function loadDataAkm(id_data_diri){
    
        $('#data_akm').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
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
                "url": "<?php echo site_url("$controller/loadDataAkm") ?>",
                "type": "POST",
                "data": function(data) {
                    data.id_data_diri = id_data_diri;
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });
}

function detail_akm(id_krs) {
    var link = "<?=base_url("akademik/akm/detail?id=")?>"+id_krs;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Detail Aktifitas Perkuliahan',
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      //reload_table:true,
      //tbl_id:'table_mk',
      scrollable:false
    });
    return false;
}

function transfer_nilai(id_ljk) {
    var link = "<?=base_url("$controller/transfer_nilai?id_ljk=")?>"+id_ljk;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    
    $.createModal({
      title:'Transfer Nilai',
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      //reload_table:true,
      //tbl_id:'table_mk',
      scrollable:false
    });
    return false;
}

function loadFormTambahMk() {
    var id_his_pdk = $('#prodi_his option:selected').val();
    var link = "<?=base_url("$controller/form_tambah_nilai?id_his_pdk=")?>"+id_his_pdk;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    if(id_his_pdk == ''){
        Swal.fire({
            icon: 'warning',
            title: 'Prodi tidak boleh kosong',
            allowOutsideClick: false
        })
    }else{
        $.createModal({
          title:'Tambah Nilai Yang Belum Ditempuh / Transfer Nilai',
          message: iframe,
          //link_cetak: link_cetak,
          //id_transaksi: id_trx,
          //status_transaksi: status_trx,
          closeButton:true,
          //reload_table:true,
          //tbl_id:'table_mk',
          scrollable:false
        });
        return false;
    }
}

function hapus_nilai(id_ljk) {
   
    Swal.fire({
        title: 'Are you sure?',
        text: "Data akan dihapus!",
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
                url: "<?php echo site_url("$controller");?>"+"/hapus_nilai",
                type: "post",
                data: "id_ljk=" + id_ljk,
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
                    
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    }).then(() => {
                        loadNilai();
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function reset_nilai(id_ljk) {
   
    Swal.fire({
        title: 'Are you sure?',
        text: "Nilai akan direset!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reset it!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller");?>"+"/reset_nilai",
                type: "post",
                data: "id_ljk=" + id_ljk,
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
                    
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    }).then(() => {
                        loadNilai();
                    });

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function cetakKtm(id) {
    var link = "<?=site_url("$controller/cetakKtm?id=")?>"+id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Mencetak Kartu Tanda Mahasiswa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/cekNim");?>",
                type: "post",
                data: {
                    id: id
                },
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
                    if (data.msg) {
                        halaman = window.open(link, "",
                            "width=800,height=600,status=1,scrollbar=yes");
                        return false;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Anda belum memiliki Nomor Induk Mahasiswa (NIM). Silahkan konsultasi ke kantor BAAK!!'
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

</script>
<?=$this->endSection();?>