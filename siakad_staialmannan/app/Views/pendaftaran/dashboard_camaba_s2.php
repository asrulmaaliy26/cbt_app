<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
          
            <section class="col-lg-8 connectedSortable">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" id="form_pendaftaran" enctype="multipart/form-data">
                            <!-- START DATA AKADEMIK 
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title"><b>DATA AKADEMIK</b></h5>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-6 pr-2">
                                            <div class="form-group row">
    											<label class="col-form-label col-sm-6"> Kelas Program </label>
    											<label class="col-sm-6"> <?=$pmb['Kelas_Program_Kuliah']?> </label>
    											
    										</div>
    										
    										<div class="form-group">
    											<label class="col-form-label"> Pilihan Prodi <code>*</code></label>
    											<select  id="prodi1" name="prodi1" class="form-control select2" data-placeholder="Klik Pilihan..." style="width:100%;">
    													<option >  </option>
    													<option value="HKI" <?=(!empty($pmb) && $pmb['Prodi_Pilihan_1'] == 'HKI')?'selected':''?>>Hukum Keluarga Islam (HKI)</option>
    													<option value="ES" <?=(!empty($pmb) && $pmb['Prodi_Pilihan_1'] == 'ES')?'selected':''?>>Ekonomi Syari'ah (ES)</option>
    													<option value="PBA" <?=(!empty($pmb) && $pmb['Prodi_Pilihan_1'] == 'PBA')?'selected':''?>>Pendidikan Bahasa Arab (PBA)</option>
    													<option value="MPI" <?=(!empty($pmb) && $pmb['Prodi_Pilihan_1'] == 'MPI')?'selected':''?>>Manajemen Pendidikan Islam (MPI)</option>
    													<option value="PGMI" <?=(!empty($pmb) && $pmb['Prodi_Pilihan_1'] == 'PGMI')?'selected':''?>>Pendidikan Guru MI (PGMI)</option>
    													<option value="IAT" <?=(!empty($pmb) && $pmb['Prodi_Pilihan_1'] == 'IAT')?'selected':''?>>Ilmu Al-Qur'an dan Tafsir (IAT)</option>
    													<option value="ILHA" <?=(!empty($pmb) && $pmb['Prodi_Pilihan_1'] == 'ILHA')?'selected':''?>>Ilmu Hadits (ILHA)</option>
    											</select>
    											<div class="invalid-feedback"></div>
    										</div>
    										
    										
                                        </div>
                                        <div class="col-sm-6 pl-2">
                                            <div class="form-group">
    											<label class="col-form-label"> Status Pendaftaran <code>*</code></label>
    											<select  id="status_pendaftaran" name="status_pendaftaran" class="form-control select2" data-placeholder="Klik Pilihan..." style="width:100%;" onchange="changeStatusPendaftaran()">
    													<option>  </option>
    													<option value="Mahasiswa Baru" <?=(!empty($pmb) && $pmb['Status_Pendaftaran'] == 'Mahasiswa Baru')?'selected':''?>> Mahasiswa Baru </option>
    													<option value="Pindahan PT Lain" <?=(!empty($pmb) && $pmb['Status_Pendaftaran'] == 'Pindahan PT Lain')?'selected':''?>> Pindahan PT Lain </option>
    													<option value="Pindah Prodi Internal" <?=(!empty($pmb) && $pmb['Status_Pendaftaran'] == 'Pindah Prodi Internal')?'selected':''?>> Pindah Prodi Internal </option>
    											</select>
                                                <div class="invalid-feedback"></div>
    											
    										</div>
    										
    										
                                        </div>
                                    </div>
                                    
                                    <div class="row" id="pindahan" hidden>
                                        <div class="col-sm-6 pr-2">
                                                <div class="form-group">
    												<label class="col-form-label" >NIM Asal</label>
    
    												<input type="text" id="nimko_asal" name="nimko_asal" class="form-control" value="<?=(!empty($pmb))?$pmb['NIMKO_Asal']:''?>"/>
    												<div class="invalid-feedback"></div>	
    											</div>
    
    											<div class="form-group">
    												<label class="col-form-label" >Prodi Asal</label>
    
    												<input type="text" id="prodi_asal" name="prodi_asal" class="form-control" value="<?=(!empty($pmb))?$pmb['Prodi_Asal']:''?>"/>
    												<div class="invalid-feedback"></div>	
    											</div>
    											
    											
    											<div class="form-group">
    												<label class="col-form-label" >Perguruan Tinggi Asal</label>
    
    												<input type="text" id="pt_asal" name="pt_asal" class="form-control" value="<?=(!empty($pmb))?$pmb['PT_Asal']:''?>"/>
    												<div class="invalid-feedback"></div>		
    											</div>
                                        </div>
                                        <div class="col-sm-6 pl-2" >
    											<div class="form-group">
    												<label class="col-form-label" >Semester Asal</label>
    
    												<select id="smt_asal" name="smt_asal" class="select2 form-control" data-placeholder="Klik Pilihan..." style="width:100%;">
    													<option value="">  </option>
    													<option value="1" <?=(!empty($pmb) && $pmb['Semester_Asal'] == '1')?'selected':''?>>Satu</option>
    													<option value="2" <?=(!empty($pmb) && $pmb['Semester_Asal'] == '2')?'selected':''?>>Dua</option>
    													<option value="3" <?=(!empty($pmb) && $pmb['Semester_Asal'] == '3')?'selected':''?>>Tiga</option>
    													<option value="4" <?=(!empty($pmb) && $pmb['Semester_Asal'] == '4')?'selected':''?>>Empat</option>
    													<option value="5" <?=(!empty($pmb) && $pmb['Semester_Asal'] == '5')?'selected':''?>>Lima</option>
    													<option value="6" <?=(!empty($pmb) && $pmb['Semester_Asal'] == '6')?'selected':''?>>Enam</option>
    													<option value="7" <?=(!empty($pmb) && $pmb['Semester_Asal'] == '7')?'selected':''?>>Tujuh</option>
    													<option value="8" <?=(!empty($pmb) && $pmb['Semester_Asal'] == '8')?'selected':''?>>Delapan</option>
    												</select>
    												<div class="invalid-feedback"></div>
    											</div>
    
    											
    											<div class="form-group">
    												<label class="col-form-label" >SKS Asal</label>
    
    												<input type="text" id="sks_asal" name="sks_asal" class="form-control" value="<?=(!empty($pmb))?$pmb['Jml_SKS_Asal']:''?>"/>
    												<div class="invalid-feedback"></div>
    											</div>
    
    											<div class="form-group">
    												<label class="col-form-label" >IPK Asal</label>
    
    												<input type="text" id="ipk_asal" name="ipk_asal" class="form-control" value="<?=(!empty($pmb))?$pmb['IPK_Asal']:''?>"/>
    												<div class="invalid-feedback"></div>	
    											</div>
    
    										</div>
                                        
                                    </div>
                                </div>
                            </div>
                            END DATA AKADEMIK -->
                            
                            <!-- START BIO DATA DIRI -->
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title"><b>BIODATA DIRI</b></h5>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-6 pr-2">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Lengkap <code>(*)</code></label>
                                                    <input type="text" class="form-control" id="id" name="id" value="<?=(!empty($data_diri))?$data_diri['id']:''?>" hidden/>
                                                    <input type="text" class="form-control" id="Nama_Lengkap" name="Nama_Lengkap" value="<?=(!empty($data_diri))?$data_diri['Nama_Lengkap']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
            
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">NIK <code>(*)</code></label>
                                                            <input type="text" class="form-control" id="No_KTP" maxlength="16" name="No_KTP" value="<?=(!empty($data_diri))?$data_diri['No_KTP']:''?>"/>
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">No. KK <code>(*)</code></label>
                                                            <input type="text" class="form-control" id="No_KK" maxlength="16" name="No_KK" value="<?=(!empty($data_diri))?$data_diri['No_KK']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Tempat Lahir <code>(*)</code></label>
                                                            <input type="text" class="form-control" id="Kota_Lhr" name="Kota_Lhr" value="<?=(!empty($data_diri))?$data_diri['Kota_Lhr']:''?>"/>
                
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
                                                                    data-target="#reservationdate" placeholder="DD-MM-YYYY" value="<?=(!empty($data_diri))?$data_diri['Tgl_Lhr']:''?>"/>
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
                                                            <select name="Jenis_Kelamin" id="Jenis_Kelamin" class="form-control select2" style="width:100%;">
                                                                <option></option>
                                                                <option value="L" <?=(!empty($data_diri) && $data_diri['Jenis_Kelamin'] == 'L')?'selected':''?>> Laki-laki </option>
                                                                <option value="P" <?=(!empty($data_diri) && $data_diri['Jenis_Kelamin'] == 'P')?'selected':''?>> Perempuan </option>
                                                            </select>
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Golongan Darah</label>
                                                            <select name="Gol_Darah" id="Gol_Darah" class="form-control select2" style="width:100%;">
                                                                <<option value="">  </option>
                													<option value="A" <?=(!empty($data_diri) && $data_diri['Gol_Darah'] == 'A')?'selected':''?>> A </option>
                													<option value="B" <?=(!empty($data_diri) && $data_diri['Gol_Darah'] == 'B')?'selected':''?>> B </option>
                													<option value="AB" <?=(!empty($data_diri) && $data_diri['Gol_Darah'] == 'AB')?'selected':''?>> AB </option>
                													<option value="O" <?=(!empty($data_diri) && $data_diri['Gol_Darah'] == 'O')?'selected':''?>> O </option>
                                                            </select>
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Agama <code>*</code></label>
                                                    <?php
                                                         
                                                        echo cmb_dinamis('Agama', 'ref_option', 'opt_val', 'opt_id', ((!empty($data_diri['Agama']))?$data_diri['Agama']:NULL), null, 'id="Agama" style="width:100%;"',null,null, ['opt_group'=>'agama']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Anak Ke- <code>*</code></label>
                                                            <input type="number" class="form-control" id="Anak_Ke" name="Anak_Ke" value="<?=(!empty($data_diri))?$data_diri['Anak_Ke']:''?>"/>
                                                            <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Jml. Saudara <code>*</code></label>
                                                            <input type="number" class="form-control" id="Jml_Saudara" name="Jml_Saudara" value="<?=(!empty($data_diri))?$data_diri['Jml_Saudara']:''?>"/>
                                                            <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pekerjaan', 'ref_option', 'opt_val', 'opt_id', ((!empty($data_diri['Pekerjaan']))?$data_diri['Pekerjaan']:NULL), null, 'id="Pekerjaan" style="width:100%;"',null,null, ['opt_group'=>'pekerjaan']);
                                                        ?>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Status Perkawinan <code>*</code></label>
                                                    <select name="Status_Perkawinan" id="Status_Perkawinan" class="form-control select2" style="width:100%;">
                                                        <<option value="">  </option>
            												<option value="Menikah" <?=(!empty($data_diri) && $data_diri['Status_Perkawinan'] == 'Menikah')?'selected':''?>>Menikah</option>
            												<option value="Belum Menikah" <?=(!empty($data_diri) && $data_diri['Status_Perkawinan'] == 'Belum Menikah')?'selected':''?>>Belum Menikah</option>
            												<option value="Duda" <?=(!empty($data_diri) && $data_diri['Status_Perkawinan'] == 'Duda')?'selected':''?>>Duda</option>
            												<option value="Janda" <?=(!empty($data_diri) && $data_diri['Status_Perkawinan'] == 'Janda')?'selected':''?>>Janda</option>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Biaya Ditanggung Oleh? <code>*</code></label>
                                                    <select name="Biaya_ditanggung" id="Biaya_ditanggung" class="form-control select2" style="width:100%;">
                                                        <<option value="">  </option>
            												<option value="Orang Tua" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Orang Tua')?'selected':''?>>Orang Tua</option>
            												<option value="Wali" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Wali')?'selected':''?>>Wali</option>
            												<option value="Mandiri" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Mandiri')?'selected':''?>>Mandiri</option>
            												<option value="Beasiswa Tahfidz" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Beasiswa Tahfidz')?'selected':''?>>Beasiswa Tahfidz</option>
            												<option value="Beasiswa IPNU-IPPNU" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Beasiswa IPNU-IPPNU')?'selected':''?>>Beasiswa IPNU-IPPNU</option>
            												<option value="Beasiswa Tidak Mampu IAIBAFA" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Beasiswa Tidak Mampu IAIBAFA')?'selected':''?>>Beasiswa Tidak Mampu IAIBAFA</option>
            												<option value="Beasiswa Tidak Mampu Pemerintah" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Beasiswa Tidak Mampu Pemerintah')?'selected':''?>>Beasiswa Tidak Mampu Pemerintah</option>
            												<option value="Beasiswa Berprestasi IAIBAFA" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Beasiswa Berprestasi IAIBAFA')?'selected':''?>>Beasiswa Berprestasi IAIBAFA</option>
            												<option value="Beasiswa Berprestasi Pemerintah" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Beasiswa Berprestasi Pemerintah')?'selected':''?>>Beasiswa Berprestasi Pemerintah</option>
            												<option value="Beasiswa Guru Madin Pemprof Jatim" <?=(!empty($data_diri) && $data_diri['Biaya_ditanggung'] == 'Beasiswa Guru Madin Pemprof Jatim')?'selected':''?>>Beasiswa Guru Madin Pemprof Jatim</option>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">No HP <code>*</code></label>
                                                            <input type="text" class="form-control" id="No_HP" name="No_HP" value="<?=(!empty($data_diri))?$data_diri['No_HP']:''?>"/>
                
                                                            <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">No WA <code>*</code></label>
                                                            <input type="text" class="form-control" id="no_wa" name="no_wa" value="<?=(!empty($data_diri))?$data_diri['no_wa']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                        </div>
                                        <div class="col-sm-6 pl-2">
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Kewarganegaraan <code>*</code></label>
                                                    <input type="text" class="form-control" id="Kewarganegaraan" name="Kewarganegaraan" value="<?=(!empty($data_diri))?$data_diri['Kewarganegaraan']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Jalan / Gang</label>
                                                            <input type="text" class="form-control" id="Alamat" name="Alamat" value="<?=(!empty($data_diri))?$data_diri['Alamat']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                
                                                    <div class="form-group">
                                                        <label class="col-form-label">No. Rumah </label>
                                                            <input type="text" class="form-control" id="No_Rmh" name="No_Rmh" value="<?=(!empty($data_diri))?$data_diri['No_Rmh']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RT<code>*</code></label>
                                                            <input type="text" class="form-control" id="RT" name="RT" value="<?=(!empty($data_diri))?$data_diri['RT']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RW<code>(*)</code></label>
                                                            <input type="text" class="form-control" id="RW" name="RW" value="<?=(!empty($data_diri))?$data_diri['RW']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Dusun<code>(*)</code></label>
                                                        <input type="text" class="form-control" id="Dusun" name="Dusun" value="<?=(!empty($data_diri))?$data_diri['Dusun']:''?>"/>
            
                                                        <div class="invalid-feedback">
            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Propinsi <code>*</code></label>
            
                                                    <select name="Prov" id="Prov" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($data_diri['Prov'])){ ?>
                					                	    <option value="<?=$data_diri['Prov'];?>" selected="selected"><?=$data_diri['Prov'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kabupaten <code>*</code></label>
            
                                                    <select name="Kab" id="Kab" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($data_diri['Kab'])){ ?>
                					                	    <option value="<?=$data_diri['Kab'];?>" selected="selected"><?=$data_diri['Kab'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan <code>*</code></label>
            
                                                    <select name="Kec" id="Kec" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($data_diri['Kec'])){ ?>
                					                	    <option value="<?=$data_diri['Kec'];?>" selected="selected"><?=$data_diri['Kec'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
    
                                            <div class="form-group">
                                                <label class="col-form-label">Desa <code>*</code></label>
        
                                                    <select name="Desa" id="Desa" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($data_diri['Desa'])){ ?>
                					                	    <option value="<?=$data_diri['Desa'];?>" selected="selected"><?=$data_diri['Desa'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                                
                                            <div class="form-group">
                                                <label class="col-form-label">Kodepos <code>*</code></label>
                                                    <input type="text" class="form-control" id="Kode_Pos" name="Kode_Pos" value="<?=(!empty($data_diri))?$data_diri['Kode_Pos']:''?>"/>
        
        
                                                    <div class="invalid-feedback"></div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Jns. Domisili <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Jenis_Domisili', 'ref_option', 'opt_val', 'opt_id', ((!empty($data_diri['Jenis_Domisili']))?$data_diri['Jenis_Domisili']:NULL), null, 'id="Jenis_Domisili" onchange="getDomisili()" style="width:100%;"',null,null, ['opt_group'=>'jns_tinggal']);
                                                        ?>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="form-group" id="box_alamat_pondok" hidden>
                                                <label class="col-form-label">Alamat Domisili / Nama Pondok <code>*</code></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="Tempat_Domisili" name="Tempat_Domisili" value="<?=(!empty($data_diri))?$data_diri['Tempat_Domisili']:''?>"/>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="box_no_telp_domisili" hidden>
                                                <label class="col-form-label">No. Telp. Domisili <code>*</code></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="No_Telp_Hp" name="No_Telp_Hp" value="<?=(!empty($data_diri))?$data_diri['No_Telp_Hp']:''?>"/>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Transportasi <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Transportasi', 'ref_option', 'opt_val', 'opt_id', ((!empty($data_diri['Transportasi']))?$data_diri['Transportasi']:NULL), null, 'id="Transportasi" style="width:100%;"',null,null, ['opt_group'=>'alat_transport']);
                                                        ?>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Punya KKS/PIP/PKH/KIP? <code>*</code></label>
                                                    <select name="Penerima_KPS" onchange="getKKS()" id="Penerima_KPS"
                                                        class="form-control select2" style="width:100%;">
                                                        <option></option>
                                                        <option value="1" <?=(!empty($data_diri) && $data_diri['Penerima_KPS'] == '1')?'selected':''?>> Ya </option>
                                                        <option value="0" <?=(!empty($data_diri) && $data_diri['Penerima_KPS'] == '0')?'selected':''?>> Tidak </option>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group" id="box_no_kks" hidden>
                                                <label class="col-form-label">No. KKS/PIP/PKH</label>
                                                    <input type="text" class="form-control" id="No_KPS" name="No_KPS" value="<?=(!empty($data_diri))?$data_diri['No_KPS']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END BIO DATA DIRI -->
                            
                            <!-- START SEKOLAH ASAL -->
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title"><b>RIWAYAT ASAL PENDIDIKAN S1</b></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 pr-2">
                                            <div class="form-group">
                                                <label class="col-form-label">Status Perguruan Tinggi S1<code>*</code></label>
                                                    <select name="Status_Asal_Sekolah" id="Status_Asal_Sekolah" class="form-control select2" style="width:100%;">
                                                        <<option value="">  </option>
            												<option value="Negeri" <?=(!empty($data_diri) && $data_diri['Status_Asal_Sekolah'] == 'Negeri')?'selected':''?>>Negeri</option>
            												<option value="Swasta" <?=(!empty($data_diri) && $data_diri['Status_Asal_Sekolah'] == 'Swasta')?'selected':''?>>Swasta</option>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Perguruan Tinggi S1 <code>*</code></label>
                                                    <input type="text" class="form-control" id="Nama_Lengkap_SLTA_Asal" name="Nama_Lengkap_SLTA_Asal" value="<?=(!empty($data_diri))?$data_diri['Nama_Lengkap_SLTA_Asal']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-2">
                                            <div class="form-group">
                                                <label class="col-form-label">Jurusan / Program Studi <code>*</code></label>
                                                    <input type="text" class="form-control" id="Kejuruan_SLTA" name="Kejuruan_SLTA" value="<?=(!empty($data_diri))?$data_diri['Kejuruan_SLTA']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
            					            <div class="form-group">
                                                <label class="col-form-label">Tahun Lulus <code>*</code></label>
                                                    <input type="text" class="form-control" id="Th_Lulus_SLTA" name="Th_Lulus_SLTA" value="<?=(!empty($data_diri))?$data_diri['Th_Lulus_SLTA']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END SEKOLAH ASAL -->
                            
                            <!-- START DATA ORANG TUA -->
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title"><b>IDENTITAS ORANG TUA</b></h5>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-lg-6 pr-2">
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Ayah <code>*</code></label>
                                                    <input type="text" class="form-control" id="Nama_Ayah" name="Nama_Ayah" value="<?=(!empty($ortu))?$ortu['Nama_Ayah']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">NIK <code>*</code></label>
                                                    <input type="text" class="form-control" id="Nomor_KTP_Ayah" maxlength="16" name="Nomor_KTP_Ayah" value="<?=(!empty($ortu))?$ortu['Nomor_KTP_Ayah']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Tempat Lahir <code>*</code></label>
                                                            <input type="text" class="form-control" id="Tempat_Lhr_Ayah" name="Tempat_Lhr_Ayah" value="<?=(!empty($ortu))?$ortu['Tempat_Lhr_Ayah']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Tgl Lahir <code>*</code></label>
                
                                                            <div class="input-group date" id="reservationdate_ayah"
                                                                data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input"
                                                                    id="Tgl_Lhr_Ayah" data-toggle="datetimepicker" name="Tgl_Lhr_Ayah" data-target="#reservationdate_ayah" placeholder="DD-MM-YYYY" value="<?=(!empty($ortu))?$ortu['Tgl_Lhr_Ayah']:''?>"/>
                                                                <div class="input-group-append" data-target="#reservationdate_ayah" data-toggle="datetimepicker">
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
                                                        <label class="col-form-label">Agama <code>*</code></label>
                                                        <?php
                                                            
                                                            echo cmb_dinamis('Agama_Ayah', 'ref_option', 'opt_val', 'opt_id', ((!empty($ortu['Agama_Ayah']))?$ortu['Agama_Ayah']:NULL), null, 'id="Agama_Ayah" style="width:100%;"',null,null, ['opt_group'=>'agama']);
                                                            ?>
                                                        <div class="invalid-feedback">
                
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Golongan Darah</label>
                                                            <select name="Gol_Darah_Ayah" id="Gol_Darah_Ayah" class="form-control select2" style="width:100%;">
                                                                <<option value="">  </option>
                													<option value="A" <?=(!empty($ortu) && $ortu['Gol_Darah_Ayah'] == 'A')?'selected':''?>> A </option>
                													<option value="B" <?=(!empty($ortu) && $ortu['Gol_Darah_Ayah'] == 'B')?'selected':''?>> B </option>
                													<option value="AB"<?=(!empty($ortu) && $ortu['Gol_Darah_Ayah'] == 'AB')?'selected':''?>> AB </option>
                													<option value="O" <?=(!empty($ortu) && $ortu['Gol_Darah_Ayah'] == 'O')?'selected':''?>> O </option>
                                                            </select>
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="cek_alamat_ayah">
                                                    <label class="form-check-label" for="cek_alamat_ayah">Beri checklis jika alamat ayah sama </label>
                                                </div>
                                                
                                            </div>
                                            -->
                                            <div class="form-group">
                                                <label class="col-form-label">Kewarganegaraan <code>*</code></label>
                                                    <input type="text" class="form-control" id="Kewarganegaraan_Ayah" name="Kewarganegaraan_Ayah" value="<?=(!empty($ortu))?$ortu['Kewarganegaraan_Ayah']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Jalan / Gang</label>
                                                            <input type="text" class="form-control" id="Alamat_Ayah" name="Alamat_Ayah" value="<?=(!empty($ortu))?$ortu['Alamat_Ayah']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                
                                                    <div class="form-group">
                                                        <label class="col-form-label">No. Rumah </label>
                                                            <input type="text" class="form-control" id="No_Rmh_Ayah" name="No_Rmh_Ayah" value="<?=(!empty($ortu))?$ortu['No_Rmh_Ayah']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RT<code>*</code></label>
                                                            <input type="text" class="form-control" id="RT_Ayah" name="RT_Ayah" value="<?=(!empty($ortu))?$ortu['RT_Ayah']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RW<code>*</code></label>
                                                            <input type="text" class="form-control" id="RW_Ayah" name="RW_Ayah" value="<?=(!empty($ortu))?$ortu['RW_Ayah']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Dusun<code>*</code></label>
                                                        <input type="text" class="form-control" id="Dusun_Ayah" name="Dusun_Ayah" value="<?=(!empty($ortu))?$ortu['Dusun_Ayah']:''?>"/>
            
                                                        <div class="invalid-feedback">
            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Propinsi <code>*</code></label>
            
                                                    <select name="Prov_Ayah" id="Prov_Ayah" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($ortu['Prov_Ayah'])){ ?>
                					                	    <option value="<?=$ortu['Prov_Ayah'];?>" selected="selected"><?=$ortu['Prov_Ayah'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kabupaten <code>*</code></label>
            
                                                    <select name="Kab_Ayah" id="Kab_Ayah" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($ortu['Kab_Ayah'])){ ?>
                					                	    <option value="<?=$ortu['Kab_Ayah'];?>" selected="selected"><?=$ortu['Kab_Ayah'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan <code>*</code></label>
            
                                                    <select name="Kec_Ayah" id="Kec_Ayah" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($ortu['Kec_Ayah'])){ ?>
                					                	    <option value="<?=$ortu['Kec_Ayah'];?>" selected="selected"><?=$ortu['Kec_Ayah'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Desa <code>*</code></label>
                
                                                            <select name="Desa_Ayah" id="Desa_Ayah" class="form-control select2" style="width:100%;">
                                                                <?php if(!empty($ortu['Desa_Ayah'])){ ?>
                        					                	    <option value="<?=$ortu['Desa_Ayah'];?>" selected="selected"><?=$ortu['Desa_Ayah'];?></option>
                        					                	<?php } ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                
                                                    <div class="form-group">
                                                        <label class="col-form-label">Kodepos <code>*</code></label>
                                                            <input type="text" class="form-control" id="Kode_Pos_Ayah" name="Kode_Pos_Ayah" value="<?=(!empty($ortu))?$ortu['Kode_Pos_Ayah']:''?>"/>
                
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan Ayah <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pekerjaan_Ayah', 'ref_option', 'opt_val', 'opt_id', ((!empty($ortu['Pekerjaan_Ayah']))?$ortu['Pekerjaan_Ayah']:NULL), null, 'id="Pekerjaan_Ayah" style="width:100%;"',null,null, ['opt_group'=>'pekerjaan']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pendidikan Ayah <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pendidikan_Terakhir_Ayah', 'ref_option', 'opt_val', 'opt_id', ((!empty($ortu['Pendidikan_Terakhir_Ayah']))?$ortu['Pendidikan_Terakhir_Ayah']:NULL), null, 'id="Pendidikan_Terakhir_Ayah" style="width:100%;"',null,null, ['opt_group'=>'jenj_pendidikan']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Penghasilan Ayah <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Penghasilan_Ayah', 'ref_option', 'opt_val', 'opt_id', ((!empty($ortu['Penghasilan_Ayah']))?$ortu['Penghasilan_Ayah']:NULL), null, 'id="Penghasilan_Ayah" style="width:100%;"',null,null, ['opt_group'=>'penghasilan']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No HP Ayah <code>*</code></label>
                                                <input type="text" class="form-control" id="No_HP_ayah" name="No_HP_ayah" value="<?=(!empty($ortu))?$ortu['No_HP_ayah']:''?>"/>
                                                <div class="invalid-feedback">
        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pl-2">
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Ibu <code>*</code></label>
                                                    <input type="text" class="form-control" id="Nama_Ibu" name="Nama_Ibu" value="<?=(!empty($ortu))?$ortu['Nama_Ibu']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">NIK <code>*</code></label>
                                                    <input type="text" class="form-control" id="Nomor_KTP_Ibu" maxlength="16" name="Nomor_KTP_Ibu" value="<?=(!empty($ortu))?$ortu['Nomor_KTP_Ibu']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Tempat Lahir <code>*</code></label>
                                                            <input type="text" class="form-control" id="Tempat_Lhr_Ibu" name="Tempat_Lhr_Ibu" value="<?=(!empty($ortu))?$ortu['Tempat_Lhr_Ibu']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Tgl Lahir <code>*</code></label>
                
                                                            <div class="input-group date" id="reservationdate_ibu"
                                                                data-target-input="nearest">
                                                                <input type="text" class="form-control datetimepicker-input"
                                                                    id="Tgl_Lhr_Ibu" data-toggle="datetimepicker" name="Tgl_Lhr_Ibu" data-target="#reservationdate_ibu" placeholder="DD-MM-YYYY" value="<?=(!empty($ortu))?$ortu['Tgl_Lhr_Ibu']:''?>"/>
                                                                <div class="input-group-append" data-target="#reservationdate_ibu" data-toggle="datetimepicker">
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
                                                        <label class="col-form-label">Agama <code>*</code></label>
                                                        <?php
                                                            
                                                            echo cmb_dinamis('Agama_Ibu', 'ref_option', 'opt_val', 'opt_id', ((!empty($ortu['Agama_Ibu']))?$ortu['Agama_Ibu']:NULL), null, 'id="Agama_Ibu" style="width:100%;"',null,null, ['opt_group'=>'agama']);
                                                            ?>
                                                        <div class="invalid-feedback">
                
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Golongan Darah</label>
                                                            <select name="Gol_Darah_Ibu" id="Gol_Darah_Ibu" class="form-control select2" style="width:100%;">
                                                                <<option value="">  </option>
                													<option value="A" <?=(!empty($ortu) && $ortu['Gol_Darah_Ibu'] == 'A')?'selected':''?>> A </option>
                													<option value="B" <?=(!empty($ortu) && $ortu['Gol_Darah_Ibu'] == 'B')?'selected':''?>> B </option>
                													<option value="AB" <?=(!empty($ortu) && $ortu['Gol_Darah_Ibu'] == 'AB')?'selected':''?>> AB </option>
                													<option value="O" <?=(!empty($ortu) && $ortu['Gol_Darah_Ibu'] == 'O')?'selected':''?>> O </option>
                                                            </select>
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="cek_alamat_ibu">
                                                    <label class="form-check-label" for="cek_alamat_ibu">Beri checklis jika alamat ibu sama</label>
                                                </div>
                                                
                                            </div>
                                            -->
                                            <div class="form-group">
                                                <label class="col-form-label">Kewarganegaraan <code>*</code></label>
                                                    <input type="text" class="form-control" id="Kewarganegaraan_Ibu" name="Kewarganegaraan_Ibu" value="<?=(!empty($ortu))?$ortu['Kewarganegaraan_Ibu']:''?>"/>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Jalan / Gang</label>
                                                            <input type="text" class="form-control" id="Alamat_Ibu" name="Alamat_Ibu" value="<?=(!empty($ortu))?$ortu['Alamat_Ibu']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                
                                                    <div class="form-group">
                                                        <label class="col-form-label">No. Rumah </label>
                                                            <input type="text" class="form-control" id="No_Rmh_Ibu" name="No_Rmh_Ibu" value="<?=(!empty($ortu))?$ortu['No_Rmh_Ibu']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RT<code>*</code></label>
                                                            <input type="text" class="form-control" id="RT_Ibu" name="RT_Ibu"  value="<?=(!empty($ortu))?$ortu['RT_Ibu']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RW<code>*</code></label>
                                                            <input type="text" class="form-control" id="RW_Ibu" name="RW_Ibu" value="<?=(!empty($ortu))?$ortu['RW_Ibu']:''?>"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Dusun<code>*</code></label>
                                                        <input type="text" class="form-control" id="Dusun_Ibu" name="Dusun_Ibu"  value="<?=(!empty($ortu))?$ortu['Dusun_Ibu']:''?>"/>
            
                                                        <div class="invalid-feedback">
            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Propinsi <code>*</code></label>
            
                                                    <select name="Prov_Ibu" id="Prov_Ibu" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($ortu['Prov_Ibu'])){ ?>
                					                	    <option value="<?=$ortu['Prov_Ibu'];?>" selected="selected"><?=$ortu['Prov_Ibu'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kabupaten <code>*</code></label>
            
                                                    <select name="Kab_Ibu" id="Kab_Ibu" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($ortu['Kab_Ibu'])){ ?>
                					                	    <option value="<?=$ortu['Kab_Ibu'];?>" selected="selected"><?=$ortu['Kab_Ibu'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan <code>*</code></label>
            
                                                    <select name="Kec_Ibu" id="Kec_Ibu" class="form-control select2" style="width:100%;">
                                                        <?php if(!empty($ortu['Kec_Ibu'])){ ?>
                					                	    <option value="<?=$ortu['Kec_Ibu'];?>" selected="selected"><?=$ortu['Kec_Ibu'];?></option>
                					                	<?php } ?>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Desa <code>*</code></label>
                
                                                            <select name="Desa_Ibu" id="Desa_Ibu" class="form-control select2" style="width:100%;">
                                                                <?php if(!empty($ortu['Desa_Ibu'])){ ?>
                        					                	    <option value="<?=$ortu['Desa_Ibu'];?>" selected="selected"><?=$ortu['Desa_Ibu'];?></option>
                        					                	<?php } ?>
                                                            </select>
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                
                                                    <div class="form-group">
                                                        <label class="col-form-label">Kodepos <code>*</code></label>
                                                            <input type="text" class="form-control" id="Kode_Pos_Ibu" name="Kode_Pos_Ibu" value="<?=(!empty($ortu))?$ortu['Kode_Pos_Ibu']:''?>"/>
                
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan Ibu <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pekerjaan_Ibu', 'ref_option', 'opt_val', 'opt_id', ((!empty($ortu['Pekerjaan_Ibu']))?$ortu['Pekerjaan_Ibu']:NULL), null, 'id="Pekerjaan_Ibu" style="width:100%;"',null,null, ['opt_group'=>'pekerjaan']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pendidikan Ibu <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pendidikan_Terakhir_Ibu', 'ref_option', 'opt_val', 'opt_id', ((!empty($ortu['Pendidikan_Terakhir_Ibu']))?$ortu['Pendidikan_Terakhir_Ibu']:NULL), null, 'id="Pendidikan_Terakhir_Ibu" style="width:100%;"',null,null, ['opt_group'=>'jenj_pendidikan']);
                                                    ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Penghasilan Ibu <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Penghasilan_Ibu', 'ref_option', 'opt_val', 'opt_id', ((!empty($ortu['Penghasilan_Ibu']))?$ortu['Penghasilan_Ibu']:NULL), null, 'id="Penghasilan_Ibu" style="width:100%;"',null,null, ['opt_group'=>'penghasilan']);
                                                    ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No HP Ibu <code>*</code></label>
                                                <input type="text" class="form-control" id="No_HP_ibu" name="No_HP_ibu" value="<?=(!empty($ortu))?$ortu['No_HP_ibu']:''?>"/>
                                                <div class="invalid-feedback">
        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                </div>
                            </div>
                            <!-- END DATA ORANG TUA -->
                        </form>
                    </div>
                    <div class="card-footer">
                      <button type="button" onclick="simpan()" class="btn btn-block btn-primary">SIMPAN</button>
                    </div>
                </div>
            </section>
            
            <section class="col-lg-4 connectedSortable">
          	    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                          <i class="fas fa-bars mr-1"></i>
                          Foto Profil
                        </h3>
                    
                    </div>
                    <div class="card-body">
                        
                        <div class="card-body box-profile">
                            <div class="text-center">
                              <img class="profile-user-img img-fluid img-circle"
                                   src="<?=(!empty($data_diri['Foto_Diri']))?base_url($data_diri['Foto_Diri']):base_url().'/assets/no-pict.jpg'?>"
                                   alt="User profile picture">
                            </div>
            
                        </div> 
                        
                    </div><!-- /.card-body -->
                    
                    <div class="card-footer">

                        <a class="btn btn-sm btn-success btn-block" role="button" href="javascript:void(0)" data-toggle="modal" data-target="#editFotoModal">Upload Foto</a>
                    </div>
                    
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                          <i class="fas fa-bars mr-1"></i>
                          Data Pendaftaran
                        </h3>
                    
                    </div>
                    <div class="card-body">
                        
                          <div class="row">
                          	<section class="col-sm-12">
                          		<div class="table-responsive table-responsive-sm">
                                <table class="table table-sm">
                                  <tr>
                                    <th style="width:50%">Tgl. Pendaftaran</th>
                                    <td><?=date_indo($pmb['Tgl_Daftar']);?></td>
                                  </tr>
                                  <tr>
                                    <th style="width:50%">Jenjang</th>
                                    <td><?=$pmb['program_sekolah'];?></td>
                                  </tr>
                                  <tr>
                                    <th >Kelas Program</th>
                                    <td><?=$pmb['Kelas_Program_Kuliah'];?></td>
                                  </tr>
                                  <tr>
                                    <th >Prodi</th>
                                    <td><?=$pmb['Prodi_Pilihan_1'];?></td>
                                  </tr>
                                  <tr>
                                    <th >Jns Pendaftaran</th>
                                    <td><?=$pmb['Status_Pendaftaran'];?></td>
                                  </tr>
                                  <?php if($pmb['Status_Pendaftaran'] != 'Mahasiswa Baru'){ ?>
                                  <tr>
                                    <th >NIM Asal</th>
                                    <td><?=$pmb['NIMKO_Asal'];?></td>
                                  </tr>
                                  <tr>
                                    <th >Prodi Asal</th>
                                    <td><?=$pmb['Prodi_Asal'];?></td>
                                  </tr>
                                  <tr>
                                    <th >PT Asal</th>
                                    <td><?=$pmb['PT_Asal'];?></td>
                                  </tr>
                                  <tr>
                                    <th >SMT Asal</th>
                                    <td><?=$pmb['Semester_Asal'];?></td>
                                  </tr>
                                  <tr>
                                    <th >Jml SKS</th>
                                    <td><?=$pmb['Jml_SKS_Asal'];?></td>
                                  </tr>
                                  <tr>
                                    <th >IPK Asal</th>
                                    <td><?=$pmb['IPK_Asal'];?></td>
                                  </tr>
                                  <?php } ?>
                                  
                                  <tr>
                                    <th>No. Pendaftaran</th>
                                    <td><?=(!empty($pmb['No_Pendaftaran']))?$pmb['No_Pendaftaran']:"<span class='badge badge-warning'>Pending</span>";?></td>
                                  </tr>
                                  <tr>
                                    <th>Biaya Pendaftaran</th>
                                    <td><?=(!empty($pmb['Biaya_Pendaftaran']))?"Rp. ".number_format($pmb['Biaya_Pendaftaran'],0,",","."):"";?></td>
                                  </tr>
                                  
                                  <tr>
                                    <th>Username</th>
                                    <td><?=$data_diri['username'];?></td>
                                  </tr>
                                  <tr>
                                    <th>Email</th>
                                    <td><?=getDataUser($data_diri['username'])['email'];?></td>
                                  </tr>
                                  
                                </table>
                              </div>
                          	</section>
                        	</div>    
                        
                    </div><!-- /.card-body -->
                    
                    <div class="card-footer">
                      <?php if(session()->get('akun_level') == 'Admin' || session()->get('akun_level') == 'Panitia PMB'){?>  
                      <button type="button" onclick="konfirmasiPendaftaran('<?=$data_diri['id']?>')" class="btn btn-sm btn-primary">Konfirmasi</button>
                      <?php } ?>
                      <a class="btn btn-sm btn-success" href="javascript:void(0)" onclick="cetak_formulir('<?=$data_diri['id']?>'); return false;">Cetak Formulir</a>
                    </div>
                    
                </div>
                
                <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-bars mr-1"></i>
                  Upload Persyaratan
                </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
              	<form id="form_berkas"  enctype="multipart/form-data">
              		<div class="row">
		              	<section class="col-lg-12 connectedSortable">
		              		
		              		<div class="form-group">
				                <label for="jns_berkas">Nama Berkas</label>
    				            <input type="text" name="nama_berkas" id="nama_berkas" class="form-control" placeholder="Mis. : Kartu Keluarga"/>    
				                <div class="invalid-feedback"></div>
			                </div>
			                <div class="form-group">
                                <label for="file_persyaratan">File Persyaratan</label>
					            <div class="input-group">
	                                <div class="custom-file">
	                                    <input type="file" accept="image/*" class="custom-file-input" id="file_persyaratan" name="file_persyaratan" oninput="preview_berkas.src=window.URL.createObjectURL(this.files[0])" > 
	                                    <label class="custom-file-label" for="file_persyaratan">Pilih file</label>
	                                <div class="invalid-feedback"></div>
	                            </div>
	                        </div>
	                        <div class="col-sm-4 pt-2">
	                            <div class="position-relative">
	                                <img id="preview_berkas" class="img-fluid" />
	                            </div>
	                        </div>
					            </div>
		              	</section>
	            	</div>    
		        </form>
              </div><!-- /.card-body -->
              
              <div class="card-footer">
                  <button type="button" onclick="simpan_berkas()" class="btn btn-block btn-primary">SIMPAN</button>
              </div>
            	
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-bars mr-1"></i>
                  Dokument Persyaratan
                </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
              	
              		<div class="row">
		              	
	              		<?php
		                  $berkas = dataDinamis('tb_persyaratan_pmb', ['username'=> $data_diri['username'], 'deleted_at'=>null]);
		                  if(!empty($berkas)){
		                  	
		                ?>
			                <div class="table-responsive table-responsive-sm">
                                <table class="table table-sm">
                                    <?php foreach ($berkas as $key) { ?>
                                    <tr>
                                    <th style="width:75%"><?=$key->nama_berkas;?></th>
                                    <td>
                                        <a href="javascript:void(0)" role="button" target="popup" onclick="window.open('<?=base_url($key->lokasi);?>','<?=$key->nama_berkas;?>','width=600,height=400')" class="btn btn-xs btn-success" data-placement="top" title="Lihat file"><i class="fa fa-eye"></i></a>
                                        <a onclick="hapus_berkas('<?=$key->id;?>','<?=$key->nama_berkas;?>'); return false;" class="btn btn-xs btn-danger" data-placement="top" title="Hapus file"><i class="fa fa-trash"></i></a>
                                    </td>
                                  </tr>
                                    <?php  }?>
                                  
                                </table>
                            </div>
			              	
				        <?php  }?>
		              	
	            	</div>    
		            
              </div><!-- /.card-body -->
              
              
            	
            </div>
                
            </section>
        </div>
        
    </div>
</section>

<div class="modal fade" id="editFotoModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_edit_foto" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
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
<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>

<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>

<script>

$(function() {
    //changeStatusPendaftaran();
    bsCustomFileInput.init();
	getKKS();
	getDomisili();
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('#reservationdate, #reservationdate_ayah, #reservationdate_ibu, #tgl_masuk_date').datetimepicker({
        format: 'DD-MM-YYYY',
        viewMode: 'years'
    });
    $('#editFotoModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#pic').removeAttr('src');
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

function getKKS() {
    var val = $('#Penerima_KPS option:selected').val();
    if (val == "1") {
        $('#box_no_kks').attr('hidden', false)
    } else {
        $('#box_no_kks').attr('hidden', true)
    }
}

function changeStatusPendaftaran() {
    var val = $('#status_pendaftaran option:selected').val();
    if (val == "Mahasiswa Baru") {
        $('#pindahan').attr('hidden', true)
    } else {
        $('#pindahan').attr('hidden', false)
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

function simpan() {

    var data = $('#form_pendaftaran').serialize();
    $('#form_pendaftaran').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("pendaftaran/updateS2");?>",
                type: "post",
                data: data,
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
                            title: "Update data berhasil",
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        })
                    } else if (data.msg == 'warning'){
                        const myObj = JSON.parse(JSON.stringify(data.validation));
                        let pesan = "";
                        for (const x in myObj) {
                          pesan += myObj[x]+ '<br>' ;
                        }
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            html : pesan ,
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
    })

}

function simpan_foto() {

    var data = new FormData($("#form_edit_foto")[0]);
    data.append('username', "<?=$data_diri['username']?>");
    $('#form_edit_foto').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("pendaftaran/update_foto_mhs");?>",
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
                        const myObj = JSON.parse(JSON.stringify(data.validation));
                        let pesan = "";
                        for (const x in myObj) {
                          pesan += myObj[x]+ '<br>' ;
                        }
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            html : pesan ,
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
    })

}

function simpan_berkas() {

    var data = new FormData($("#form_berkas")[0]);
    data.append('username', "<?=$data_diri['username']?>");
    $('#form_berkas').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("pendaftaran/upload_berkas");?>",
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
                    	
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        })
                    } else if (data.msg == 'warning'){
                        const myObj = JSON.parse(JSON.stringify(data.validation));
                        let pesan = "";
                        for (const x in myObj) {
                          pesan += myObj[x]+ '<br>' ;
                        }
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            html : pesan ,
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
    })

}

function hapus_berkas(id,nama) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: nama+" akan dihapus!",
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
                url: "<?php echo site_url("pendaftaran/hapus_berkas");?>",
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
                            title: 'File berhasil dihapus',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'File gagal dihapus',
                            allowOutsideClick: false,
                        })
                    }
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

function cetak_formulir(id) {
    var link = "<?=site_url("pmb/cetak_formulir?id=")?>"+id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Mencetak formulir?",
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
                url: "<?php echo site_url("pmb/cekData");?>",
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
                    if (data.status) {
                        halaman = window.open(link, "",
                            "width=800,height=600,status=1,scrollbar=yes");
                        return false;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Data tidak ditemukan'
                        })
                    }
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
</script>


<?=$this->endSection();?>