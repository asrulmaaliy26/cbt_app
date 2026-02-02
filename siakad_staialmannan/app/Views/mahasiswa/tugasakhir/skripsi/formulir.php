
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$templateJudul?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/select2/css/select2.min.css">
<link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/toastr/toastr.min.css">
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">
<!-- BS Stepper -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/bs-stepper/css/bs-stepper.min.css">
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 class="m-0"><?=$templateJudul?> <?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id'=>$id_data_diri])['Nama_Lengkap'])?></h4>
            
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                
                <div class="card-body">
                	<div class="row">
	                    <div class="col-6">
	                        <div class="table-responsive">
			                    <table class="table table-sm">
			                    	<tr>
				                        <th style="width:40%">Nama</th>
				                        <td><?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);?></td>
									</tr>
									<tr>
										<th >NIM</th>
										<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['NIM'];?></td>
									</tr>
									<tr>
										<th>Prodi</th>
										<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Prodi'];?></td>
									</tr>
									
			                      
			                    </table>
			                </div>
	                    </div>
	                    <div class="col-6">
	                    	<div class="table-responsive">
			                    <table class="table table-sm">
			                    	<tr>
				                        <th style="width:40%">Tahun Angkatan</th>
				                        <td><?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['th_angkatan']?>
				                        </td>
									</tr>
									<tr>
										<th >Kelas</th>
										<td><?=(getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Kelas'] == "PA") ? "Putera" : ((getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Kelas'] == "PI") ? "Puteri" : getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Kelas']);?></td>
									</tr>
									<tr>
										<th>Program</th>
										<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Program'];?></td>
									</tr>
									
			                      
			                    </table>
			                </div>
	                    </div>
	                </div>
                </div>
            </div>
            
            <div class="card card-primary card-outline">
                <div class="card-body p-0">
                        <div class="bs-stepper">
                          <div class="bs-stepper-header" role="tablist">
                            <!-- your steps here -->
                            <div class="step" data-target="#judul-part">
                              <button type="button" class="step-trigger" role="tab" aria-controls="judul-part" id="judul-part-trigger">
                                <span class="bs-stepper-circle">1</span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#abstrak-part">
                              <button type="button" class="step-trigger" role="tab" aria-controls="abstrak-part" id="abstrak-part-trigger">
                                <span class="bs-stepper-circle">2</span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#kesimpulan-part">
                              <button type="button" class="step-trigger" role="tab" aria-controls="kesimpulan-part" id="kesimpulan-part-trigger">
                                <span class="bs-stepper-circle">3</span>
                              </button>
                            </div>
                            
                            
                            <div class="line"></div>
                            <div class="step" data-target="#file-upload-part">
                              <button type="button" class="step-trigger" role="tab" aria-controls="file-upload-part" id="file-upload-part-trigger">
                                <span class="bs-stepper-circle">4</span>
                              </button>
                            </div>
                          </div>
                          <div class="bs-stepper-content">
                              <form id="form_disposisi" class="needs-validation" onSubmit="return false" novalidate enctype="multipart/form-data">
                                <!-- your steps content here -->
                                <input type="text" class="form-control" value="<?=$id_his_pdk?>" hidden name="id_his_pdk" id="id_his_pdk">
                                <div id="judul-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="judul-part-trigger">
                                  <div class="form-group">
                                    <label for="judul-part-inp"><h3>Tuliskan judul skripsi Saudara!</h3></label>
                                    <textarea class="form-control" rows="10" id="judul-part-inp" name="judul-part-inp"></textarea>
                                    <div class="invalid-feedback">Judul skripsi tidak boleh kosong!!</div>
                                  </div>
                                  <button class="btn btn-primary btn-next-form" >Next</button>
                                </div>
                                <div id="abstrak-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="abstrak-part-trigger">
                                  <div class="form-group">
                                    <label for="abstrak-part-inp"><h3>Tulis abstrak skripsi Saudara!</h3></label>
                                    <textarea class="form-control artikel" rows="10" id="abstrak-part-inp" name="abstrak-part-inp"></textarea>
                                    <div class="invalid-feedback">Abstrak tidak boleh kosong!!</div>
                                  </div>
                                  <button class="btn btn-primary btn-prev-form" >Previous</button>
                                  <button class="btn btn-primary btn-next-form" >Next</button>
                                </div>
                                <div id="kesimpulan-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="kesimpulan-part-trigger">
                                  <div class="form-group">
                                    <label for="kesimpulan-part-inp"><h3>Bagaimana kesimpulan skripsi Saudara!</h3></label>
                                    <textarea class="form-control artikel" rows="10" id="kesimpulan-part-inp" name="kesimpulan-part-inp"></textarea>
                                    <div class="invalid-feedback">Rumusan Masalah / Fokus Penelitian tidak boleh kosong!!</div>
                                  </div>
                                  <button class="btn btn-primary btn-prev-form" >Previous</button>
                                  <button class="btn btn-primary btn-next-form" >Next</button>
                                </div>
                                
                                <div id="file-upload-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="file-upload-part-trigger">
                                  <div class="form-group row">
                                    <label for="pembimbing" class="col-md-7">Pembimbing!</label>
                                    <div class="col-md-5">
                                        <?php
                                            echo cmb_dinamis('dosen_pembimbing', 'data_dosen', 'Nama_Dosen', 'Kode', null, null, 'id="dosen_pembimbing"  style="width: 100%;" ');
                                        ?>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="kwitansi_pendaftaran" class="col-md-7">Kwitansi Pembayaran Pendaftaran Munaqasyah Skripsi <code>(pdf/jpg)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('kwitansi_pendaftaran','<?=$id_his_pdk?>','Kwitansi Pendafaran Munaqasyah'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="kwitansi_pendaftaran" name="kwitansi_pendaftaran">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_kwitansi_pendaftaran"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="bebas_bak" class="col-md-7">Surat Keterangan Bebas Tanggungan dari BAK <code>(pdf/jpg)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('bebas_bak','<?=$id_his_pdk?>', 'Surat Keterangan Bebas Tanggungan BAK'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="bebas_bak" name="bebas_bak">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_bebas_bak"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="ktm" class="col-md-7">Kartu Tanda Mahasiswa (KTM) <code>(pdf/jpg)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('ktm','<?=$id_his_pdk?>','KTM'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="ktm" name="ktm">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_ktm"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="khs" class="col-md-7">KHS Semester 1 s.d 7 dengan nilai Lulus <code>(pdf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('khs','<?=$id_his_pdk?>','KHS'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="khs" name="khs">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_khs"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="kartu_bimbingan" class="col-md-7">Kartu Bimbingan dengan Tanda Tangan Pembimbing sebanyak 8 kali <code>(pdf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('kartu_bimbingan','<?=$id_his_pdk?>','Kartu Bimbingan'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="kartu_bimbingan" name="kartu_bimbingan">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_kartu_bimbingan"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="persetujuan_munaqasyah" class="col-md-7">Lembar Persetujuan Munaqasyah dengan Tanda Tangan Pembimbing <code>(pdf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('persetujuan_munaqasyah','<?=$id_his_pdk?>','Lembar Persetujuan Pembimbing'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="persetujuan_munaqasyah" name="persetujuan_munaqasyah">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_persetujuan_munaqasyah"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="posmaru" class="col-md-7">Sertifikat PBAK <code>(pdf/jpg)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('posmaru','<?=$id_his_pdk?>','Sertifikat PBAK'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="posmaru" name="posmaru">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_posmaru"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="sertifikat_kkn" class="col-md-7">Sertifikat KKN <code>(pdf/jpg)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('sertifikat_kkn','<?=$id_his_pdk?>', 'Sertifikat KKN'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="sertifikat_kkn" name="sertifikat_kkn">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_sertifikat_kkn"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="ppl" class="col-md-7">Sertifikat PPL (Prodi HKI PPL KUA dan PPL PA dijadikan 1 File) <code>(pdf/jpg)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('ppl','<?=$id_his_pdk?>','Sertifikat PPL'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="ppl" name="ppl">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_ppl"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="sertifikat_seminar" class="col-md-7">Sertifikat Seminar 3 jenis kegiatan (dijadikan 1 file) <code>(pdf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('sertifikat_seminar','<?=$id_his_pdk?>','Sertifikat Seminar'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="sertifikat_seminar" name="sertifikat_seminar">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_sertifikat_seminar"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="toefl_toafl" class="col-md-7">Sertifikat TOEFL / TOAFL <code>(pdf/jpg)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('toefl_toafl','<?=$id_his_pdk?>','Sertifikat TOEFL / TOAFL'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="toefl_toafl" name="toefl_toafl">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_toefl_toafl"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="plagiasi" class="col-md-7">Surat keterangan bebas plagiasi dari LPJI <code>(pdf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('plagiasi','<?=$id_his_pdk?>','Surat Bebas Plagiasi'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="plagiasi" name="plagiasi">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_plagiasi"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="kuesioner" class="col-md-7">Angket kuesioner bimbingan tugas akhir <code>(pdf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('kuesioner','<?=$id_his_pdk?>','Kuesioner Bimbingan'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="kuesioner" name="kuesioner">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_kuesioner"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="skripsi" class="col-md-7">File Skripsi <span class="text-red"><strong>(File hasil cek plagiasi dari LPJI)</strong></span> <code>(pdf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('skripsi','<?=$id_his_pdk?>','File Skripsi'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="skripsi" name="skripsi">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_skripsi"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="powerpoint" class="col-md-7">Power Point Presentasi <code>(ppt/pptx)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('powerpoint','<?=$id_his_pdk?>','Powerpoint Presentasi'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="powerpoint" name="powerpoint">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_powerpoint"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="bag_depan" class="col-md-7">Bagian Depan Skripsi (Cover, Halaman Persembahan, Kata Pengantar, Motto, Daftar Isi, Abstrak, dll.) <code>(doc/docx/rtf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('bag_depan','<?=$id_his_pdk?>','Halaman Depan Skripsi (Cover dll.)'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="bag_depan" name="bag_depan">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_bag_depan"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="bab1" class="col-md-7">BAB I <code>(doc/docx/rtf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('bab1','<?=$id_his_pdk?>','BAB I'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="bab1" name="bab1">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_bab1"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                  </div>
                                  <div class="form-group row">
                                    <label for="bab2" class="col-md-7">BAB II <code>(doc/docx/rtf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('bab2','<?=$id_his_pdk?>','BAB II'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="bab2" name="bab2">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_bab2"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="bab3" class="col-md-7">BAB III <code>(doc/docx/rtf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('bab3','<?=$id_his_pdk?>','BAB III'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="bab3" name="bab3">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_bab3"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="bab4" class="col-md-7">BAB IV <code>(doc/docx/rtf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('bab4','<?=$id_his_pdk?>','BAB IV'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="bab4" name="bab4">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_bab4"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="bab5" class="col-md-7">BAB V <code>(doc/docx/rtf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('bab5','<?=$id_his_pdk?>','BAB V'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="bab5" name="bab5">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_bab5"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="bab6" class="col-md-7">BAB VI <span class="text-green"><strong>(Jika Ada)</strong></span> <code>(doc/docx/rtf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('bab6','<?=$id_his_pdk?>','BAB VI'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="bab6" name="bab6">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_bab6"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="pustaka" class="col-md-7">Daftar Pustaka <code>(doc/docx/rtf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('pustaka','<?=$id_his_pdk?>','Daftar Pustaka'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="pustaka" name="pustaka">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_pustaka"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="lampiran" class="col-md-7">Lampiran-lampiran <span class="text-green"><strong>(Jika Ada)</strong></span> <code>(doc/docx/rtf)</code></label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0)" onclick="unggah('lampiran','<?=$id_his_pdk?>','Lampiran-lampiran'); return false;" class="btn btn-primary"><b>Upload</b></a>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                          
                                            <input type="text" class="form-control" readonly id="lampiran" name="lampiran">
                                            <span class="input-group-append">
                                                <a role="button" class="btn btn-danger btn-flat" id="btn_lampiran"><i class="fas fa-times"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="alert alert-danger" id="card_validasi" hidden>
                            			<ul id="list_error">
                            				
                            			</ul>
                            	  </div>
                                  <button class="btn btn-primary btn-prev-form" >Previous</button>
                                  <button type="button" class="btn btn-primary" onclick="simpan()">Simpan </button>
                                </div>
                              </form>
                          </div>
                        </div>
                      </div>
            </div>
            
        </div>
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="uploadModal" data-backdrop="static" role="dialog" aria-labelledby="uploadModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_upload" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Edit Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row " hidden>
                        <label class="col-sm-3 col-form-label">id_his_pdk</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="id_his_pdk_upload" name="id_his_pdk_upload" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row " hidden>
                        <label class="col-sm-3 col-form-label">id_his_pdk</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"  id="jenis_berkas" name="jenis_berkas" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label" id="nm_berkas">Foto</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="berkas" name="berkas"> 
                                    <label class="custom-file-label" for="berkas">Choose file</label>
                                    
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            
                        </div>
                        
                    </div>
                    <div class="card card-danger card-outline" id="card_validasi_berkas" hidden>
                        <div class="card-body">
                            <div class="alert alert-danger">
                    			<ul id="list_error_berkas">
                    				
                    			</ul>
                    		</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="upload_berkas()">Upload </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ./wrapper -->
<!-- Page specific script -->
<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>

<!-- BS-Stepper -->
<script src="<?=base_url('assets');?>/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- Summernote -->
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-file.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-ext-rtl.js"></script>
<!-- Select2 -->
<script src="<?=base_url('assets');?>/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('assets');?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url('assets');?>/plugins/toastr/toastr.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url('assets');?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.js"></script>
<script>
var table_mk;
$(function() {
	bsCustomFileInput.init();
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('#judul-part-inp').summernote({
        tabsize: 2,
        height: 50,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['ltr', 'rtl']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {
            /*
            onPaste: function(e) {
              e.preventDefault();
              Swal.fire({
					title: "Ooooppsss....!",
					text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
					icon: "error",
				});
            },
            */
        }
    });
    
    $('.artikel').summernote({
        tabsize: 2,
        height: 400,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['ltr', 'rtl']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {
            /*
            onPaste: function(e) {
              e.preventDefault();
              Swal.fire({
					title: "Ooooppsss....!",
					text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
					icon: "error",
				});
            },
            */
        }
    });
    
    $('#uploadModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.invalid-feedback').text('');
        $(this).find('li').remove();
        $(this).find('#card_validasi_berkas').attr('hidden', true);
    });
    
    //BS-Stepper Init
    var stepperFormEl = document.querySelector('.bs-stepper')
        window.stepperForm = new Stepper(stepperFormEl, {
        animation: true
    })
    
    var btnNextList = [].slice.call(document.querySelectorAll('.btn-next-form'))
    var btnPrevList = [].slice.call(document.querySelectorAll('.btn-prev-form'))
    var stepperPanList = [].slice.call(stepperFormEl.querySelectorAll('.bs-stepper-pane'))
    var judul = document.getElementById('judul-part-inp')
    var abstrak = document.getElementById('abstrak-part-inp')
    var kesimpulan = document.getElementById('kesimpulan-part-inp')
    var form = stepperFormEl.querySelector('.bs-stepper-content form')
    
    btnNextList.forEach(function (btn) {
        btn.addEventListener('click', function () {
          window.stepperForm.next()
        })
    })
    btnPrevList.forEach(function (btn) {
        btn.addEventListener('click', function () {
          window.stepperForm.previous()
        })
    })
    
    stepperFormEl.addEventListener('show.bs-stepper', function (event) {
        //form.classList.remove('was-validated')
        var nextStep = event.detail.indexStep
        var currentStep = nextStep
    
        if (currentStep > 0) {
          currentStep--
        }
    
        var stepperPan = stepperPanList[currentStep]
    
        if ((stepperPan.getAttribute('id') === 'judul-part' && !judul.value.length) ||
        (stepperPan.getAttribute('id') === 'abstrak-part' && !abstrak.value.length) ||
        (stepperPan.getAttribute('id') === 'kesimpulan-part' && !kesimpulan.value.length)) {
          event.preventDefault()
          //form.classList.add('was-validated')
          //console.log('Moved to step ' + form.classList)
          $('#' +stepperPan.getAttribute('id')+'-inp').addClass('is-invalid');
        }
    })
})

function unggah(field, id_his_pdk, nm_berkas) {
    //let berkas = field.replace("_", " ").toUpperCase();
    $('#uploadModal').on('show.bs.modal', function () {
        var modal = $(this)
        $(this).find('#uploadModalLabel').text("Upload "+nm_berkas);
        $(this).find('#jenis_berkas').val(field);
        $(this).find('#id_his_pdk_upload').val(id_his_pdk);
        $(this).find('#nm_berkas').text(nm_berkas);
    })
    $('#uploadModal').modal('show');
}

function upload_berkas(){
    let text = $('#jenis_berkas').val();
    //let berkas = text.replace("_", " ").toUpperCase();
    let nm_berkas = $('#nm_berkas').text();
    var data = new FormData($("#form_upload")[0]);
    data.append('nm_berkas', nm_berkas);
    Swal.fire({
        title: 'Anda yakin akan mengupload '+nm_berkas+' ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("tugasakhir/$controller/");?>"+"/upload_berkas",
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
                    	$('#uploadModal').modal('hide');
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            $('#'+text).val(data.link);
                            $('#btn_'+text).attr('href',data.link);
                            $('#btn_'+text).attr('target',"_blank");
                            $('#btn_'+text).attr('class','btn btn-success btn-flat');
                            $("#btn_"+text).find("i").attr('class',"fas fa-check");
                        })
                    } else if (data.msg == 'warning'){
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                        $('#card_validasi_berkas').attr('hidden', false)

                        const ul = $('#list_error_berkas');
                        $.each(data.validation, function (_, value) {
                            tr = $("<li />");
                            tr.append("<li>" + value + "</li>");
                            tr.appendTo(ul);
                        })
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
                	if (xhr.status === 0) {
                       var textError = 'Not connected.\nPlease verify your network connection.';
                    } else if (xhr.status == 404) {
                        var textError = 'The requested page not found.';
                    }  else if (xhr.status == 401) {
                        var textError = 'Sorry!! You session has expired. Please login to continue access.';
                    } else if (xhr.status == 500) {
                        var textError = 'Internal Server Error.';
                    } else if (ajaxOptions === 'parsererror') {
                        var textError = 'Requested JSON parse failed.';
                    } else if (ajaxOptions === 'timeout') {
                        var textError = 'Time out error.';
                    } else if (ajaxOptions === 'abort') {
                        var textError = 'Ajax request aborted.';
                    } else {
                        var textError = 'Unknown error occured. Please try again.';
                    }
                	Swal.fire({
                        icon: 'error',
                        title: "Ooppss!! Something wrong!!!",
                        html: thrownError + "<br>" + xhr.statusText+ "<br>" + xhr.responseText + "<br>" + textError,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    })
}

function simpan() {

    var data = new FormData($("#form_disposisi")[0]);
    $('#card_validasi').attr('hidden', true);
    $("#list_error").find("li").remove();
    Swal.fire({
        title: 'Anda yakin akan menyimpan pendaftaran munaqasyah skripsi ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("tugasakhir/$controller/$metode");?>",
                type: "post",
                data: data,
                processData: false,
                contentType: false,
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
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        })
        				
                    } else if (data.msg == 'warning') {
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                        
                        $('#card_validasi').attr('hidden', false)

                        const ul = $('#list_error');
                        $.each(data.validation, function (_, value) {
                            tr = $("<li />");
                            tr.append("<li>" + value + "</li>");
                            tr.appendTo(ul);
                        })
                    } else {
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
                	if (xhr.status === 0) {
                       var textError = 'Not connected.\nPlease verify your network connection.';
                    } else if (xhr.status == 404) {
                        var textError = 'The requested page not found.';
                    }  else if (xhr.status == 401) {
                        var textError = 'Sorry!! You session has expired. Please login to continue access.';
                    } else if (xhr.status == 500) {
                        var textError = 'Internal Server Error.';
                    } else if (ajaxOptions === 'parsererror') {
                        var textError = 'Requested JSON parse failed.';
                    } else if (ajaxOptions === 'timeout') {
                        var textError = 'Time out error.';
                    } else if (ajaxOptions === 'abort') {
                        var textError = 'Ajax request aborted.';
                    } else {
                        var textError = 'Unknown error occured. Please try again.';
                    }
                	Swal.fire({
                        icon: 'error',
                        title: "Ooppss!! Something wrong!!!",
                        html: thrownError + "<br>" + xhr.statusText+ "<br>" + xhr.responseText + "<br>" + textError,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                    //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })

}

function uploadImage(image) {
    var data = new FormData();
    data.append("image", image, image.name);
    $.ajax({
        url: "<?php echo site_url('summernote/upload_image')?>",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "POST",
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
        success: function(url) {
            $('.summernote').summernote("insertImage", url);
            Swal.close();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function deleteImage(src) {
    $.ajax({
        data: {
            src: src
        },
        type: "POST",
        url: "<?php echo site_url('summernote/delete_image')?>",
        cache: false,
        success: function(response) {
            console.log(response);
        }
    });
}

function myOwnCallBack(file) {
    let data = new FormData();
    data.append("file", file, file.name);
    $.ajax({
        data: data,
        type: "POST",
        url: "<?php echo site_url('summernote/upload_file')?>", //Your own back-end uploader
        cache: false,
        contentType: false,
        processData: false,
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
        success: function(url) {
            
            let listMimeImg = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/gif', 'image/svg'];
            let listMimeAudio = ['audio/mpeg', 'audio/ogg', 'audio/mp3'];
            let listMimeVideo = ['video/mpeg', 'video/mp4', 'video/webm'];
            let listMimePdf = ['application/pdf'];
            let elem;

            if (listMimeImg.indexOf(file.type) > -1) {
                //Picture
                $('.summernote').summernote('editor.insertImage', url);
            } else if (listMimeAudio.indexOf(file.type) > -1) {
                //Audio
                elem = document.createElement("audio");
                elem.setAttribute("src", url);
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('.summernote').summernote('editor.insertNode', elem);
            } else if (listMimeVideo.indexOf(file.type) > -1) {
                //Video
                elem = document.createElement("video");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "300");
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('.summernote').summernote('editor.insertNode', elem);
            } else if (listMimePdf.indexOf(file.type) > -1) {
                //Video
                elem = document.createElement("iframe");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "600");
                elem.setAttribute("allow", "autoplay");
                $('.summernote').summernote('editor.insertNode', elem);
            } else {
                //Other file type
                var node;
                node = document.createElement("a");
                let linkText = document.createTextNode(file.name);
                node.appendChild(linkText);
                node.title = file.name;
                node.href = url;
                $('.summernote').summernote('insertNode', node);
            }
            Swal.close();
        }
    });
}


</script>
<?php
	$session = \Config\Services::session();
	if($session->getFlashdata('info') == 'warning'):
?>
<script type="text/javascript">
				Swal.fire({
					title: "Oooopppsss....!",
					text: "Maaf!! Anda tidak dijinkan mengakses Formulir Pendaftaran Munaqasyah Skripsi karena Anda belum melakukan pemrograman KRS di Semester ini.",
					icon: "warning",
					showConfirmButton: false,
                    allowOutsideClick: false,
				});
			</script>
<?php elseif($session->getFlashdata('krs_tidak_aktif')):?>
<script type="text/javascript">
				Swal.fire({
					title: "Periode Tidak Aktif!",
					text: "<?=$session->getFlashdata('krs_tidak_aktif')?>",
					icon: "error",
					showConfirmButton: false,
                    allowOutsideClick: false,
				});
			</script>
<?php endif;?>
</body>
</html>