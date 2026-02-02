
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
  	<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/toastr/toastr.min.css">
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 class="m-0"><?=$templateJudul?> </h4>
            
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form class="form-horizontal" id="form_edit_data_diri" enctype="multipart/form-data">

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title">BIODATA DIRI</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-12 col-sm-6 pr-4">
                                <div class="form-group">
                                    <label class="col-form-label">Nama Lengkap <code>(*)</code></label>
                                        <input type="text" class="form-control"  id="id_data_diri" name="id_data_diri" value="<?=(isset($diri['id']))?$diri['id']:"";?>" hidden/>
                                        <input type="text" class="form-control" id="Nama_Lengkap" name="Nama_Lengkap" value="<?=(isset($diri['Nama_Lengkap']))?$diri['Nama_Lengkap']:"";?>" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">NISN <small><em>(Jika
                                                ada)</em></small></label>
                                        <input type="text" class="form-control" id="NISN" name="NISN" value="<?=(isset($diri['NISN']))?$diri['NISN']:"";?>"/>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">NIK <code>(*)</code></label>
                                                <input type="text" class="form-control" id="No_KTP" maxlength="16" name="No_KTP" value="<?=(isset($diri['No_KTP']))?$diri['No_KTP']:"";?>" />
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">No. KK <code>(*)</code></label>
                                                <input type="text" class="form-control" id="No_KK" maxlength="16" value="<?=(isset($diri['No_KK']))?$diri['No_KK']:"";?>"
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
                                                <input type="text" class="form-control" id="Kota_Lhr" name="Kota_Lhr" value="<?=(isset($diri['Kota_Lhr']))?$diri['Kota_Lhr']:"";?>" />
    
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
                                                        data-target="#reservationdate" placeholder="YYYY-MM-DD" value="<?=(isset($diri['Tgl_Lhr']))?$diri['Tgl_Lhr']:"";?>" />
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
                                                    <option value="L" <?=(isset($diri['Jenis_Kelamin']) && $diri['Jenis_Kelamin'] == 'L')?"selected":""?>> Laki-laki </option>
                                                    <option value="P" <?=(isset($diri['Jenis_Kelamin']) && $diri['Jenis_Kelamin'] == 'P')?"selected":""?>> Perempuan </option>
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
    													<option value="A" <?=(isset($diri['Gol_Darah']) && $diri['Gol_Darah'] == 'A')?"selected":""?>> A </option>
    													<option value="B" <?=(isset($diri['Gol_Darah']) && $diri['Gol_Darah'] == 'B')?"selected":""?>> B </option>
    													<option value="AB" <?=(isset($diri['Gol_Darah']) && $diri['Gol_Darah'] == 'AB')?"selected":""?>> AB </option>
    													<option value="O" <?=(isset($diri['Gol_Darah']) && $diri['Gol_Darah'] == 'O')?"selected":""?>> O </option>
                                                </select>
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Agama <code>(*)</code></label>
                                        <?php
                                             
                                            echo cmb_dinamis('Agama', 'ref_option', 'opt_val', 'opt_id', ((isset($diri['Agama']))?$diri['Agama']:NULL), null, 'id="Agama"',null,null, ['opt_group'=>'agama']);
                                            ?>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-form-label">Kewarganegaraan <code>*</code></label>
                                        <input type="text" class="form-control" id="Kewarganegaraan" name="Kewarganegaraan" value="<?=(isset($diri['Kewarganegaraan']))?$diri['Kewarganegaraan']:"";?>" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Jalan / Gang<code>(jika ada)</code></label>
                                                <input type="text" class="form-control" id="Alamat" name="Alamat" value="<?=(isset($diri['Alamat']))?$diri['Alamat']:"";?>" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                    
                                        <div class="form-group">
                                            <label class="col-form-label">No. Rumah <code>( jika ada)</code></label>
                                                <input type="text" class="form-control" id="No_Rmh" name="No_Rmh" value="<?=(isset($diri['No_Rmh']))?$diri['No_Rmh']:"";?>" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="col-form-label">RT<code>(*)</code></label>
                                                <input type="text" class="form-control" id="RT" name="RT" value="<?=(isset($diri['RT']))?$diri['RT']:"";?>" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="col-form-label">RW<code>(*)</code></label>
                                                <input type="text" class="form-control" id="RW" name="RW" value="<?=(isset($diri['RW']))?$diri['RW']:"";?>" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Dusun<code>(*)</code></label>
                                            <input type="text" class="form-control" id="Dusun" name="Dusun" value="<?=(isset($diri['Dusun']))?$diri['Dusun']:"";?>" />

                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-form-label">Propinsi <code>(*)</code></label>

                                        <select name="Prov" id="Prov" class="form-control select2">
                                            <?php if(isset($diri['Prov'])){ ?>
    					                	    <option value="<?=$diri['Prov'];?>" selected="selected"><?=$diri['Prov'];?></option>
    					                	<?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Kabupaten <code>(*)</code></label>

                                        <select name="Kab" id="Kab" class="form-control select2">
                                            <?php if(isset($diri['Kab'])){ ?>
    					                	    <option value="<?=$diri['Kab'];?>" selected="selected"><?=$diri['Kab'];?></option>
    					                	<?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Kecamatan <code>(*)</code></label>

                                        <select name="Kec" id="Kec" class="form-control select2">
                                            <?php if(isset($diri['Kec'])){ ?>
    					                	    <option value="<?=$diri['Kec'];?>" selected="selected"><?=$diri['Kec'];?></option>
    					                	<?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Desa <code>(*)</code></label>
    
                                                <select name="Desa" id="Desa" class="form-control select2">
                                                    <?php if(isset($diri['Desa'])){ ?>
            					                	    <option value="<?=$diri['Desa'];?>" selected="selected"><?=$diri['Desa'];?></option>
            					                	<?php } ?>
                                                </select>
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
    
                                        <div class="form-group">
                                            <label class="col-form-label">Kodepos <code>(*)</code></label>
                                                <input type="text" class="form-control" id="Kode_Pos" name="Kode_Pos" value="<?=(isset($diri['Kode_Pos']))?$diri['Kode_Pos']:"";?>" />
    
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-form-label">Email <code>(*)</code></label>
                                        <input type="text" class="form-control" id="Email"
                                            name="Email" value="<?=(isset($diri['Email']))?$diri['Email']:"";?>" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">No HP <code>(*)</code></label>
                                                <input type="text" class="form-control" id="No_HP" value="<?=(isset($diri['No_HP']))?$diri['No_HP']:"";?>"
                                                    name="No_HP" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">No WA <code>(*)</code></label>
                                                <input type="text" class="form-control" id="no_wa" value="<?=(isset($diri['no_wa']))?$diri['no_wa']:"";?>"
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
                                                <input type="number" class="form-control" id="Anak_Ke" value="<?=(isset($diri['Anak_Ke']))?$diri['Anak_Ke']:"";?>"
                                                    name="Anak_Ke" />
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Jml. Saudara <code>(*)</code></label>
                                                <input type="number" class="form-control" id="Jml_Saudara" value="<?=(isset($diri['Jml_Saudara']))?$diri['Jml_Saudara']:"";?>"
                                                    name="Jml_Saudara" />
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Pekerjaan <code>(*)</code></label>
                                        <?php
                                            
                                            echo cmb_dinamis('Pekerjaan', 'ref_option', 'opt_val', 'opt_id', ((isset($diri['Pekerjaan']))?$diri['Pekerjaan']:NULL), null, 'id="Pekerjaan"',null,null, ['opt_group'=>'pekerjaan']);
                                            ?>

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-form-label">Status Perkawinan <code>(*)</code></label>
                                        <select name="Status_Perkawinan" id="Status_Perkawinan" class="form-control select2">
                                            <<option value="">  </option>
												<option value="Menikah" <?=(isset($diri['Status_Perkawinan']) && $diri['Status_Perkawinan'] == 'Menikah')?"selected":""?>>Menikah</option>
												<option value="Belum Menikah" <?=(isset($diri['Status_Perkawinan']) && $diri['Status_Perkawinan'] == 'Belum Menikah')?"selected":""?>>Belum Menikah</option>
												<option value="Duda" <?=(isset($diri['Status_Perkawinan']) && $diri['Status_Perkawinan'] == 'Duda')?"selected":""?>>Duda</option>
												<option value="Janda" <?=(isset($diri['Status_Perkawinan']) && $diri['Status_Perkawinan'] == 'Janda')?"selected":""?>>Janda</option>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-form-label">Biaya Ditanggung Oleh? <code>(*)</code></label>
                                        <select name="Biaya_ditanggung" id="Biaya_ditanggung" class="form-control select2">
                                            <<option value="">  </option>
												<option value="Orang Tua" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Orang Tua')?"selected":""?>>Orang Tua</option>
												<option value="Wali" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Wali')?"selected":""?>>Wali</option>
												<option value="Mandiri" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Mandiri')?"selected":""?>>Mandiri</option>
												<option value="Beasiswa Tahfidz" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Beasiswa Tahfidz')?"selected":""?>>Beasiswa Tahfidz</option>
												<option value="Beasiswa IPNU-IPPNU" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Beasiswa IPNU-IPPNU')?"selected":""?>>Beasiswa IPNU-IPPNU</option>
												<option value="Beasiswa Tidak Mampu IAIBAFA" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Beasiswa Tidak Mampu IAIBAFA')?"selected":""?>>Beasiswa Tidak Mampu IAIBAFA</option>
												<option value="Beasiswa Tidak Mampu Pemerintah" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Beasiswa Tidak Mampu Pemerintah')?"selected":""?>>Beasiswa Tidak Mampu Pemerintah</option>
												<option value="Beasiswa Berprestasi IAIBAFA" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Beasiswa Berprestasi IAIBAFA')?"selected":""?>>Beasiswa Berprestasi IAIBAFA</option>
												<option value="Beasiswa Berprestasi Pemerintah" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Beasiswa Berprestasi Pemerintah')?"selected":""?>>Beasiswa Berprestasi Pemerintah</option>
												<option value="Beasiswa Guru Madin Pemprof Jatim" <?=(isset($diri['Biaya_ditanggung']) && $diri['Biaya_ditanggung'] == 'Beasiswa Guru Madin Pemprof Jatim')?"selected":""?>>Beasiswa Guru Madin Pemprof Jatim</option>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-form-label">Jns. Domisili <code>(*)</code></label>
                                        <?php
                                            
                                            echo cmb_dinamis('Jenis_Domisili', 'ref_option', 'opt_val', 'opt_id', ((isset($diri['Jenis_Domisili']))?$diri['Jenis_Domisili']:NULL), null, 'id="Jenis_Domisili" onchange="getDomisili()"',null,null, ['opt_group'=>'jns_tinggal']);
                                            ?>

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="form-group" id="box_alamat_pondok" hidden>
                                    <label class="col-form-label">Alamat Domisili / Nama Pondok <code>(*)</code></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="Tempat_Domisili" value="<?=(isset($diri['Tempat_Domisili']))?$diri['Tempat_Domisili']:"";?>"
                                            name="Tempat_Domisili" />
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="box_no_telp_domisili" hidden>
                                    <label class="col-form-label">No. Telp. Domisili <code>(*)</code></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="No_Telp_Hp" value="<?=(isset($diri['No_Telp_Hp']))?$diri['No_Telp_Hp']:"";?>"
                                            name="No_Telp_Hp" />
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Transportasi <code>(*)</code></label>
                                        <?php
                                            
                                            echo cmb_dinamis('Transportasi', 'ref_option', 'opt_val', 'opt_id', ((isset($diri['Transportasi']))?$diri['Transportasi']:NULL), null, 'id="Transportasi"',null,null, ['opt_group'=>'alat_transport']);
                                            ?>

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Punya KKS/PIP/PKH/KIP? <code>(*)</code></label>
                                        <select name="Penerima_KPS" onchange="getKKS()" id="Penerima_KPS"
                                            class="form-control select2">
                                            <option></option>
                                            <option value="1" <?=(!empty($diri['No_KPS']) )?"selected":""?>> Ya </option>
                                            <option value="0" <?=(empty($diri['No_KPS']) )?"selected":""?>> Tidak </option>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group" id="box_no_kks" hidden>
                                    <label class="col-form-label">No. KKS/PIP/PKH</label>
                                        <input type="text" class="form-control" id="No_KPS"
                                            name="No_KPS" value="<?=(isset($diri['No_KPS']))?$diri['No_KPS']:"";?>"/>

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Status Asal Sekolah<code>(*)</code></label>
                                        <select name="Status_Asal_Sekolah" id="Status_Asal_Sekolah" class="form-control select2">
                                            <<option value="">  </option>
												<option value="Negeri" <?=(isset($diri['Status_Asal_Sekolah']) && $diri['Status_Asal_Sekolah'] == 'Negeri')?"selected":""?>>Negeri</option>
												<option value="Swasta" <?=(isset($diri['Status_Asal_Sekolah']) && $diri['Status_Asal_Sekolah'] == 'Swasta')?"selected":""?>>Swasta</option>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Jenis Asal Sekolah<code>(*)</code></label>
                                        <select name="Jenis_SLTA" id="Jenis_SLTA" class="form-control select2">
                                            <<option value="">  </option>
												<option value="MA" <?=(isset($diri['Jenis_SLTA']) && $diri['Jenis_SLTA'] == 'MA')?"selected":""?>> MA </option>
												<option value="SMA" <?=(isset($diri['Jenis_SLTA']) && $diri['Jenis_SLTA'] == 'SMA')?"selected":""?>> SMA </option>
												<option value="SMK" <?=(isset($diri['Jenis_SLTA']) && $diri['Jenis_SLTA'] == 'SMK')?"selected":""?>> SMK </option>
												<option value="Paket C" <?=(isset($diri['Jenis_SLTA']) && $diri['Jenis_SLTA'] == 'Paket C')?"selected":""?>> Paket C </option>
												<option value="Madrasah Diniyyah Kesetaraan" <?=(isset($diri['Jenis_SLTA']) && $diri['Jenis_SLTA'] == 'Madrasah Diniyyah Kesetaraan')?"selected":""?>> Madrasah Diniyyah Kesetaraan </option>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Jurusan <code>(*)</code></label>
                                        <input type="text" class="form-control" id="Kejuruan_SLTA" value="<?=(isset($diri['Kejuruan_SLTA']))?$diri['Kejuruan_SLTA']:"";?>"
                                            name="Kejuruan_SLTA" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Nama Asal Sekolah <code>(*)</code></label>
                                        <input type="text" class="form-control" id="Nama_Lengkap_SLTA_Asal" value="<?=(isset($diri['Nama_Lengkap_SLTA_Asal']))?$diri['Nama_Lengkap_SLTA_Asal']:"";?>"
                                            name="Nama_Lengkap_SLTA_Asal" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="form-group">
					                <label for="asal_sekolah">Alamat Lengkap Sekolah Asal</label>
					                <input type="text" class="form-control" id="Alamat_Lengkap_Sekolah_Asal" name="Alamat_Lengkap_Sekolah_Asal" value="<?=(isset($diri['Alamat_Lengkap_Sekolah_Asal']))?$diri['Alamat_Lengkap_Sekolah_Asal']:"";?>" /> 
					                <div class="invalid-feedback"></div>
					            </div>
					            <div class="form-group">
                                    <label class="col-form-label">Tahun Lulus SLTA <code>(*)</code></label>
                                        <input type="text" class="form-control" id="Th_Lulus_SLTA" value="<?=(isset($diri['Th_Lulus_SLTA']))?$diri['Th_Lulus_SLTA']:"";?>"
                                            name="Th_Lulus_SLTA" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">No. Seri Ijazah SLTA</label>
                                        <input type="text" class="form-control" id="No_Seri_Ijazah_SLTA" value="<?=(isset($diri['No_Seri_Ijazah_SLTA']))?$diri['No_Seri_Ijazah_SLTA']:"";?>"
                                            name="No_Seri_Ijazah_SLTA" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>

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
                                        <input type="text" class="form-control" id="Nama_Ayah" name="Nama_Ayah" value="<?=(isset($ortu['Nama_Ayah']))?$ortu['Nama_Ayah']:"";?>" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">NIK <code>(*)</code></label>
                                        <input type="text" class="form-control" id="Nomor_KTP_Ayah" maxlength="16" value="<?=(isset($ortu['Nomor_KTP_Ayah']))?$ortu['Nomor_KTP_Ayah']:"";?>"
                                            name="Nomor_KTP_Ayah" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Tempat Lahir <code>(*)</code></label>
                                                <input type="text" class="form-control" id="Tempat_Lhr_Ayah" name="Tempat_Lhr_Ayah" value="<?=(isset($ortu['Tempat_Lhr_Ayah']))?$ortu['Tempat_Lhr_Ayah']:"";?>" />
    
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
                                                        id="Tgl_Lhr_Ayah" data-toggle="datetimepicker" name="Tgl_Lhr_Ayah" value="<?=(isset($ortu['Tgl_Lhr_Ayah']))?$ortu['Tgl_Lhr_Ayah']:"";?>"
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
                                            
                                            echo cmb_dinamis('Agama_Ayah', 'ref_option', 'opt_val', 'opt_id', ((isset($ortu['Agama_Ayah']))?$ortu['Agama_Ayah']:NULL), null, 'id="Agama_Ayah"',null,null, ['opt_group'=>'agama']);
                                            ?>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Golongan Darah</label>
                                                <select name="Gol_Darah_Ayah" id="Gol_Darah_Ayah" class="form-control select2">
                                                    <<option value="">  </option>
    													<option value="A" <?=(isset($ortu['Gol_Darah_Ayah']) && $ortu['Gol_Darah_Ayah'] == 'A')?"selected":""?>> A </option>
    													<option value="B" <?=(isset($ortu['Gol_Darah_Ayah']) && $ortu['Gol_Darah_Ayah'] == 'B')?"selected":""?>> B </option>
    													<option value="AB" <?=(isset($ortu['Gol_Darah_Ayah']) && $ortu['Gol_Darah_Ayah'] == 'AB')?"selected":""?>> AB </option>
    													<option value="O" <?=(isset($ortu['Gol_Darah_Ayah']) && $ortu['Gol_Darah_Ayah'] == 'O')?"selected":""?>> O </option>
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
                                        <input type="text" class="form-control" id="Kewarganegaraan_Ayah" name="Kewarganegaraan_Ayah" value="<?=(isset($ortu['Kewarganegaraan_Ayah']))?$ortu['Kewarganegaraan_Ayah']:"";?>" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Jalan / Gang<code>(jika ada)</code></label>
                                                <input type="text" class="form-control" id="Alamat_Ayah" name="Alamat_Ayah" value="<?=(isset($ortu['Alamat_Ayah']))?$ortu['Alamat_Ayah']:"";?>"/>
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                    
                                        <div class="form-group">
                                            <label class="col-form-label">No. Rumah <code>( jika ada)</code></label>
                                                <input type="text" class="form-control" id="No_Rmh_Ayah" name="No_Rmh_Ayah" value="<?=(isset($ortu['No_Rmh_Ayah']))?$ortu['No_Rmh_Ayah']:"";?>"/>
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="col-form-label">RT<code>(*)</code></label>
                                                <input type="text" class="form-control" id="RT_Ayah" name="RT_Ayah" value="<?=(isset($ortu['RT_Ayah']))?$ortu['RT_Ayah']:"";?>"/>
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="col-form-label">RW<code>(*)</code></label>
                                                <input type="text" class="form-control" id="RW_Ayah" name="RW_Ayah" value="<?=(isset($ortu['RW_Ayah']))?$ortu['RW_Ayah']:"";?>"/>
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Dusun<code>(*)</code></label>
                                            <input type="text" class="form-control" id="Dusun_Ayah" name="Dusun_Ayah" value="<?=(isset($ortu['Dusun_Ayah']))?$ortu['Dusun_Ayah']:"";?>"/>

                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-form-label">Propinsi <code>(*)</code></label>

                                        <select name="Prov_Ayah" id="Prov_Ayah" class="form-control select2">
                                            <?php if(isset($ortu['Prov_Ayah'])){ ?>
    					                	    <option value="<?=$ortu['Prov_Ayah'];?>" selected="selected"><?=$ortu['Prov_Ayah'];?></option>
    					                	<?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Kabupaten <code>(*)</code></label>

                                        <select name="Kab_Ayah" id="Kab_Ayah" class="form-control select2">
                                            <?php if(isset($ortu['Kab_Ayah'])){ ?>
    					                	    <option value="<?=$ortu['Kab_Ayah'];?>" selected="selected"><?=$ortu['Kab_Ayah'];?></option>
    					                	<?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Kecamatan <code>(*)</code></label>

                                        <select name="Kec_Ayah" id="Kec_Ayah" class="form-control select2">
                                            <?php if(isset($ortu['Kec_Ayah'])){ ?>
    					                	    <option value="<?=$ortu['Kec_Ayah'];?>" selected="selected"><?=$ortu['Kec_Ayah'];?></option>
    					                	<?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Desa <code>(*)</code></label>
    
                                                <select name="Desa_Ayah" id="Desa_Ayah" class="form-control select2">
                                                    <?php if(isset($ortu['Desa_Ayah'])){ ?>
            					                	    <option value="<?=$ortu['Desa_Ayah'];?>" selected="selected"><?=$ortu['Desa_Ayah'];?></option>
            					                	<?php } ?>
                                                </select>
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
    
                                        <div class="form-group">
                                            <label class="col-form-label">Kodepos <code>(*)</code></label>
                                                <input type="text" class="form-control" id="Kode_Pos_Ayah" name="Kode_Pos_Ayah" value="<?=(isset($ortu['Kode_Pos_Ayah']))?$ortu['Kode_Pos_Ayah']:"";?>"/>
    
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-form-label">Pekerjaan Ayah <code>(*)</code></label>
                                        <?php
                                            
                                            echo cmb_dinamis('Pekerjaan_Ayah', 'ref_option', 'opt_val', 'opt_id', ((isset($ortu['Pekerjaan_Ayah']))?$ortu['Pekerjaan_Ayah']:NULL), null, 'id="Pekerjaan_Ayah"',null,null, ['opt_group'=>'pekerjaan']);
                                            ?>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Pendidikan Ayah <code>(*)</code></label>
                                        <?php
                                            
                                            echo cmb_dinamis('Pendidikan_Terakhir_Ayah', 'ref_option', 'opt_val', 'opt_id', ((isset($ortu['Pendidikan_Terakhir_Ayah']))?$ortu['Pendidikan_Terakhir_Ayah']:NULL), null, 'id="Pendidikan_Terakhir_Ayah"',null,null, ['opt_group'=>'jenj_pendidikan']);
                                            ?>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Penghasilan Ayah <code>(*)</code></label>
                                        <?php
                                            
                                            echo cmb_dinamis('Penghasilan_Ayah', 'ref_option', 'opt_val', 'opt_id', ((isset($ortu['Penghasilan_Ayah']))?$ortu['Penghasilan_Ayah']:NULL), null, 'id="Penghasilan_Ayah"',null,null, ['opt_group'=>'penghasilan']);
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
                                        <input type="text" class="form-control" id="Nama_Ibu" name="Nama_Ibu" value="<?=(isset($ortu['Nama_Ibu']))?$ortu['Nama_Ibu']:"";?>"/>

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">NIK <code>(*)</code></label>
                                        <input type="text" class="form-control" id="Nomor_KTP_Ibu" maxlength="16" value="<?=(isset($ortu['Nomor_KTP_Ibu']))?$ortu['Nomor_KTP_Ibu']:"";?>"
                                            name="Nomor_KTP_Ibu" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Tempat Lahir <code>(*)</code></label>
                                                <input type="text" class="form-control" id="Tempat_Lhr_Ibu" name="Tempat_Lhr_Ibu" value="<?=(isset($ortu['Tempat_Lhr_Ibu']))?$ortu['Tempat_Lhr_Ibu']:"";?>"/>
    
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
                                                        id="Tgl_Lhr_Ibu" data-toggle="datetimepicker" name="Tgl_Lhr_Ibu" value="<?=(isset($ortu['Tgl_Lhr_Ibu']))?$ortu['Tgl_Lhr_Ibu']:"";?>"
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
                                            
                                            echo cmb_dinamis('Agama_Ibu', 'ref_option', 'opt_val', 'opt_id', ((isset($ortu['Agama_Ibu']))?$ortu['Agama_Ibu']:NULL), null, 'id="Agama_Ibu"',null,null, ['opt_group'=>'agama']);
                                            ?>
                                        <div class="invalid-feedback">

                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Golongan Darah</label>
                                                <select name="Gol_Darah_Ibu" id="Gol_Darah_Ibu" class="form-control select2">
                                                    <<option value="">  </option>
    													<option value="A" <?=(isset($ortu['Gol_Darah_Ibu']) && $ortu['Gol_Darah_Ibu'] == 'A')?"selected":""?>> A </option>
    													<option value="B" <?=(isset($ortu['Gol_Darah_Ibu']) && $ortu['Gol_Darah_Ibu'] == 'B')?"selected":""?>> B </option>
    													<option value="AB" <?=(isset($ortu['Gol_Darah_Ibu']) && $ortu['Gol_Darah_Ibu'] == 'AB')?"selected":""?>> AB </option>
    													<option value="O" <?=(isset($ortu['Gol_Darah_Ibu']) && $ortu['Gol_Darah_Ibu'] == 'O')?"selected":""?>> O </option>
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
                                        <input type="text" class="form-control" id="Kewarganegaraan_Ibu" name="Kewarganegaraan_Ibu" value="<?=(isset($ortu['Kewarganegaraan_Ibu']))?$ortu['Kewarganegaraan_Ibu']:"";?>" />

                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Jalan / Gang<code>(jika ada)</code></label>
                                                <input type="text" class="form-control" id="Alamat_Ibu" name="Alamat_Ibu" value="<?=(isset($ortu['Alamat_Ibu']))?$ortu['Alamat_Ibu']:"";?>" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                    
                                        <div class="form-group">
                                            <label class="col-form-label">No. Rumah <code>( jika ada)</code></label>
                                                <input type="text" class="form-control" id="No_Rmh_Ibu" name="No_Rmh_Ibu" value="<?=(isset($ortu['No_Rmh_Ibu']))?$ortu['No_Rmh_Ibu']:"";?>" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="col-form-label">RT<code>(*)</code></label>
                                                <input type="text" class="form-control" id="RT_Ibu" name="RT_Ibu" value="<?=(isset($ortu['RT_Ibu']))?$ortu['RT_Ibu']:"";?>" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="col-form-label">RW<code>(*)</code></label>
                                                <input type="text" class="form-control" id="RW_Ibu" name="RW_Ibu" value="<?=(isset($ortu['RW_Ibu']))?$ortu['RW_Ibu']:"";?>" />
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Dusun<code>(*)</code></label>
                                            <input type="text" class="form-control" id="Dusun_Ibu" name="Dusun_Ibu" value="<?=(isset($ortu['Dusun_Ibu']))?$ortu['Dusun_Ibu']:"";?>"  />

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
                                            <?php if(isset($ortu['Kab_Ibu'])){ ?>
    					                	    <option value="<?=$ortu['Kab_Ibu'];?>" selected="selected"><?=$ortu['Kab_Ibu'];?></option>
    					                	<?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Kecamatan <code>(*)</code></label>

                                        <select name="Kec_Ibu" id="Kec_Ibu" class="form-control select2">
                                            <?php if(isset($ortu['Kec_Ibu'])){ ?>
    					                	    <option value="<?=$ortu['Kec_Ibu'];?>" selected="selected"><?=$ortu['Kec_Ibu'];?></option>
    					                	<?php } ?>
                                        </select>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Desa <code>(*)</code></label>
    
                                                <select name="Desa_Ibu" id="Desa_Ibu" class="form-control select2">
                                                    <?php if(isset($ortu['Desa_Ibu'])){ ?>
            					                	    <option value="<?=$ortu['Desa_Ibu'];?>" selected="selected"><?=$ortu['Desa_Ibu'];?></option>
            					                	<?php } ?>
                                                </select>
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
    
                                        <div class="form-group">
                                            <label class="col-form-label">Kodepos <code>(*)</code></label>
                                                <input type="text" class="form-control" id="Kode_Pos_Ibu" name="Kode_Pos_Ibu" value="<?=(isset($ortu['Kode_Pos_Ibu']))?$ortu['Kode_Pos_Ibu']:"";?>" />
    
    
                                                <div class="invalid-feedback">
    
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-form-label">Pekerjaan Ibu <code>(*)</code></label>
                                        <?php
                                            
                                            echo cmb_dinamis('Pekerjaan_Ibu', 'ref_option', 'opt_val', 'opt_id', ((isset($ortu['Pekerjaan_Ibu']))?$ortu['Pekerjaan_Ibu']:NULL), null, 'id="Pekerjaan_Ibu"',null,null, ['opt_group'=>'pekerjaan']);
                                            ?>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Pendidikan Ibu <code>(*)</code></label>
                                        <?php
                                            
                                            echo cmb_dinamis('Pendidikan_Terakhir_Ibu', 'ref_option', 'opt_val', 'opt_id', ((isset($ortu['Pendidikan_Terakhir_Ibu']))?$ortu['Pendidikan_Terakhir_Ibu']:NULL), null, 'id="Pendidikan_Terakhir_Ibu"',null,null, ['opt_group'=>'jenj_pendidikan']);
                                            ?>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Penghasilan Ibu <code>(*)</code></label>
                                        <?php
                                            
                                            echo cmb_dinamis('Penghasilan_Ibu', 'ref_option', 'opt_val', 'opt_id', ((isset($ortu['Penghasilan_Ibu']))?$ortu['Penghasilan_Ibu']:NULL), null, 'id="Penghasilan_Ibu"',null,null, ['opt_group'=>'penghasilan']);
                                            ?>
                                        <div class="invalid-feedback">

                                        </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
                    
            </form>
        </div>
    </section>
    <!-- /.content -->
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
<!-- DataTables  & Plugins -->
<script src="<?=base_url('assets');?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- Select2 -->
<script src="<?=base_url('assets');?>/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('assets');?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url('assets');?>/plugins/toastr/toastr.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url('assets');?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.js"></script>
<script>
var table_mk;
$(function() {
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

function getDomisili() {
    var val = $('#Jenis_Domisili option:selected').val();
    if (val == 4 || val == 5 || val == 3 || val == 2 || val == 99) {
        $('#box_no_telp_domisili, #box_alamat_pondok').attr('hidden', false)
    } else {
        $('#box_no_telp_domisili, #box_alamat_pondok').attr('hidden', true)
    }
}


</script>
</body>
</html>