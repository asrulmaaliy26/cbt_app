<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="id">
<head>
  
  <title>Pendaftaran Mahasiswa S2 IAI Bani Fattah Jombang</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Website resmi pendaftaran mahasiswa baru IAI Bani Fattah Jombang">
    <meta name="keyword" content="IAIBAFA, SIAKAD, Siakad IAIBAFA, Akademik, Akademik IAIBAFA, e-akademik, PMB, PMB IAIBAFA, IAI Bani Fattah, Bani Fattah, Pendaftaran IAIBAFA">
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="PMB IAI Bani Fattah (IAIBAFA) Jombang" />
    <meta property="og:title" content="PMB IAI Bani Fattah Jombang" />
    <meta property="og:description" content="Website resmi pendaftaran mahasiswa baru IAI Bani Fattah (IAIBAFA) Jombang" />
    <meta property="og:url" content="<?=base_url('pendaftaran')?>" />
    <meta property="og:image" content="<?=base_url('assets/logo_iaibafa.png');?>" />
    
    <meta itemprop="name" content="PMB IAI Bani Fattah (IAIBAFA) Jombang">
    <meta itemprop="description" content="Website resmi pendaftaran mahasiswa baru IAI Bani Fattah Jombang">
    <meta itemprop="image" content="<?=base_url('assets/logo_iaibafa.png');?>">
  <link rel="shortcut icon" href="<?=base_url('assets/logo.ico');?>" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?=base_url('assets')?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="<?=base_url('assets')?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.css">
<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/toastr/toastr.min.css">
  <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/owlcarousel/assets/owl.theme.default.min.css">
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">


</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="#" class="navbar-brand">
        <img src="<?=base_url('assets');?>/logo_iaibafa.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Pendaftaran Mahasiswa IAIBAFA</span>
      </a>
    <!--
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">

        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index3.html" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Dropdown</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="#" class="dropdown-item">Some action </a></li>
              <li><a href="#" class="dropdown-item">Some other action</a></li>

              <li class="dropdown-divider"></li>


              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                  </li>


                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                    </ul>
                  </li>


                  <li><a href="#" class="dropdown-item">level 2</a></li>
                  <li><a href="#" class="dropdown-item">level 2</a></li>
                </ul>
              </li>

            </ul>
          </li>
        </ul>

      </div>
    -->
      
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> <?=$templateJudul?></h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <form class="form-horizontal" id="form_pendaftaran" enctype="multipart/form-data">
                        <input type="text" class="form-control"  id="kode_referral" name="kode_referral" value="<?=(isset($kode_referral))?$kode_referral:"";?>" hidden/>
                    <div class="card">
                            
                        <div class="card-body">
                            <!-- START DATA AKADEMIK -->
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title"><b>DATA AKADEMIK</b></h5>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-sm-6 pr-2">
                                            <!--
                                            <div class="form-group">
												<label class="col-form-label"> Kelas Program <code>*</code> </label>
												
												<select id="kelas_program" name="kelas_program" class="form-control select2" data-placeholder="Klik Pilihan..." style="width:100%;">
													<option >  </option>
													<option value="Reguler">Reguler</option>
													
													<option value="Kelas Pegawai">Kelas Pegawai</option>
													<option value="Kelas VI MMA">Kelas VI MMA</option>
												</select>
												<div class="invalid-feedback"></div>
											</div>
											-->
											<div class="form-group">
												<label class="col-form-label"> Pilihan Prodi <code>*</code></label>
												<select  id="prodi1" name="prodi1" class="form-control select2" data-placeholder="Klik Pilihan..." style="width:100%;">
														<option >  </option>
														
														<option value="PBA">Pendidikan Bahasa Arab (PBA)</option>
														<option value="SI" disabled>Studi Islam (SI)</option>
												</select>
												<div class="invalid-feedback"></div>
											</div>
											
                                        </div>
                                        <div class="col-sm-6 pl-2">
                                            <div class="form-group">
												<label class="col-form-label"> Status Pendaftaran <code>*</code></label>
												<select  id="status_pendaftaran" name="status_pendaftaran" class="form-control select2" data-placeholder="Klik Pilihan..." style="width:100%;" onchange="changeStatusPendaftaran()">
														<option>  </option>
														<option value="Mahasiswa Baru"> Mahasiswa Baru </option>
														<option value="Pindahan PT Lain"> Pindahan PT Lain </option>
														<option value="Pindah Prodi Internal"> Pindah Prodi Internal </option>
												</select>
                                                <div class="invalid-feedback"></div>
												
											</div>
											
											
                                        </div>
                                    </div>
                                    
                                    <div class="row" id="pindahan" hidden>
                                        <div class="col-sm-6 pr-2">
                                                <div class="form-group">
													<label class="col-form-label" >NIM Asal</label>

													<input type="text" id="nimko_asal" name="nimko_asal" class="form-control" />
													<div class="invalid-feedback"></div>	
												</div>

												<div class="form-group">
													<label class="col-form-label" >Prodi Asal</label>

													<input type="text" id="prodi_asal" name="prodi_asal" class="form-control" />
													<div class="invalid-feedback"></div>	
												</div>
												
												
												<div class="form-group">
													<label class="col-form-label" >Perguruan Tinggi Asal</label>

													<input type="text" id="pt_asal" name="pt_asal" class="form-control" />
													<div class="invalid-feedback"></div>		
												</div>
                                        </div>
                                        <div class="col-sm-6 pl-2" >
												<div class="form-group">
													<label class="col-form-label" >Semester Asal</label>

													<select id="smt_asal" name="smt_asal" class="select2 form-control" data-placeholder="Klik Pilihan..." style="width:100%;">
														<option value="">  </option>
														<option value="1">Satu</option>
														<option value="2">Dua</option>
														<option value="3">Tiga</option>
														<option value="4">Empat</option>
														<option value="5">Lima</option>
														<option value="6">Enam</option>
														<option value="7">Tujuh</option>
														<option value="8">Delapan</option>
													</select>
													<div class="invalid-feedback"></div>
												</div>

												
												<div class="form-group">
													<label class="col-form-label" >SKS Asal</label>

													<input type="text" id="sks_asal" name="sks_asal" class="form-control" />
													<div class="invalid-feedback"></div>
												</div>

												<div class="form-group">
													<label class="col-form-label" >IPK Asal</label>

													<input type="text" id="ipk_asal" name="ipk_asal" class="form-control" />
													<div class="invalid-feedback"></div>	
												</div>

											</div>
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- END DATA AKADEMIK -->
                            
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
                                                    
                                                    <input type="text" class="form-control" id="Nama_Lengkap" name="Nama_Lengkap" />
            
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
                                                            <input type="text" class="form-control" id="No_KK" maxlength="16" name="No_KK" />
                
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
                                                                    data-target="#reservationdate" placeholder="DD-MM-YYYY" />
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
                                                            <select name="Gol_Darah" id="Gol_Darah" class="form-control select2" style="width:100%;">
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
                                                <label class="col-form-label">Agama <code>*</code></label>
                                                    <?php
                                                         
                                                        echo cmb_dinamis('Agama', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Agama" style="width:100%;"',null,null, ['opt_group'=>'agama']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Anak Ke- <code>*</code></label>
                                                            <input type="number" class="form-control" id="Anak_Ke" name="Anak_Ke" />
                                                            <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Jml. Saudara <code>*</code></label>
                                                            <input type="number" class="form-control" id="Jml_Saudara" name="Jml_Saudara" />
                                                            <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pekerjaan', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Pekerjaan" style="width:100%;"',null,null, ['opt_group'=>'pekerjaan']);
                                                        ?>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Status Perkawinan <code>*</code></label>
                                                    <select name="Status_Perkawinan" id="Status_Perkawinan" class="form-control select2" style="width:100%;">
                                                        <<option value="">  </option>
            												<option value="Menikah" >Menikah</option>
            												<option value="Belum Menikah" >Belum Menikah</option>
            												<option value="Duda" >Duda</option>
            												<option value="Janda" >Janda</option>
                                                    </select>
                                                    <div class="invalid-feedback"></div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Biaya Ditanggung Oleh? <code>*</code></label>
                                                    <select name="Biaya_ditanggung" id="Biaya_ditanggung" class="form-control select2" style="width:100%;">
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
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">No HP <code>*</code></label>
                                                            <input type="text" class="form-control" id="No_HP" name="No_HP" />
                
                                                            <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">No WA <code>*</code></label>
                                                            <input type="text" class="form-control" id="no_wa" name="no_wa" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                        </div>
                                        <div class="col-sm-6 pl-2">
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Kewarganegaraan <code>*</code></label>
                                                    <input type="text" class="form-control" id="Kewarganegaraan" name="Kewarganegaraan" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Jalan / Gang</label>
                                                            <input type="text" class="form-control" id="Alamat" name="Alamat" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                
                                                    <div class="form-group">
                                                        <label class="col-form-label">No. Rumah </label>
                                                            <input type="text" class="form-control" id="No_Rmh" name="No_Rmh" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RT<code>*</code></label>
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
                                                <label class="col-form-label">Propinsi <code>*</code></label>
            
                                                    <select name="Prov" id="Prov" class="form-control select2" style="width:100%;">
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kabupaten <code>*</code></label>
            
                                                    <select name="Kab" id="Kab" class="form-control select2" style="width:100%;">
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan <code>*</code></label>
            
                                                    <select name="Kec" id="Kec" class="form-control select2" style="width:100%;">
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Desa <code>*</code></label>
        
                                                    <select name="Desa" id="Desa" class="form-control select2" style="width:100%;">
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">
        
                                                    </div>
                                            </div>
                                                
                                            <div class="form-group">
                                                <label class="col-form-label">Kodepos <code>*</code></label>
                                                    <input type="text" class="form-control" id="Kode_Pos" name="Kode_Pos" />
        
        
                                                    <div class="invalid-feedback"></div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Jns. Domisili <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Jenis_Domisili', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Jenis_Domisili" style="width:100%;" onchange="getDomisili()"',null,null, ['opt_group'=>'jns_tinggal']);
                                                        ?>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="form-group" id="box_alamat_pondok" hidden>
                                                <label class="col-form-label">Alamat Domisili / Nama Pondok <code>*</code></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="Tempat_Domisili" name="Tempat_Domisili" />
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group" id="box_no_telp_domisili" hidden>
                                                <label class="col-form-label">No. Telp. Domisili <code>*</code></label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="No_Telp_Hp" name="No_Telp_Hp" />
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Transportasi <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Transportasi', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Transportasi" style="width:100%;"',null,null, ['opt_group'=>'alat_transport']);
                                                        ?>
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Punya KKS/PIP/PKH/KIP? <code>*</code></label>
                                                    <select name="Penerima_KPS" onchange="getKKS()" id="Penerima_KPS"
                                                        class="form-control select2" style="width:100%;">
                                                        <option></option>
                                                        <option value="1" > Ya </option>
                                                        <option value="0" > Tidak </option>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group" id="box_no_kks" hidden>
                                                <label class="col-form-label">No. KKS/PIP/PKH</label>
                                                    <input type="text" class="form-control" id="No_KPS" name="No_KPS" />
            
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
            												<option value="Negeri" >Negeri</option>
            												<option value="Swasta" >Swasta</option>
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Perguruan Tinggi S1 <code>*</code></label>
                                                    <input type="text" class="form-control" id="Nama_Lengkap_SLTA_Asal" name="Nama_Lengkap_SLTA_Asal" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 pl-2">
                                            <div class="form-group">
                                                <label class="col-form-label">Jurusan / Program Studi <code>*</code></label>
                                                    <input type="text" class="form-control" id="Kejuruan_SLTA" name="Kejuruan_SLTA" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
            					            <div class="form-group">
                                                <label class="col-form-label">Tahun Lulus <code>*</code></label>
                                                    <input type="text" class="form-control" id="Th_Lulus_SLTA" name="Th_Lulus_SLTA" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <!--
                                            <div class="form-group">
                                                <label class="col-form-label">No. Seri Ijazah SLTA</label>
                                                    <input type="text" class="form-control" id="No_Seri_Ijazah_SLTA" name="No_Seri_Ijazah_SLTA" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            -->
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
                                                    <input type="text" class="form-control" id="Nama_Ayah" name="Nama_Ayah" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">NIK <code>*</code></label>
                                                    <input type="text" class="form-control" id="Nomor_KTP_Ayah" maxlength="16" name="Nomor_KTP_Ayah" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Tempat Lahir <code>*</code></label>
                                                            <input type="text" class="form-control" id="Tempat_Lhr_Ayah" name="Tempat_Lhr_Ayah" />
                
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
                                                                    id="Tgl_Lhr_Ayah" data-toggle="datetimepicker" name="Tgl_Lhr_Ayah" data-target="#reservationdate_ayah" placeholder="DD-MM-YYYY" />
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
                                                            
                                                            echo cmb_dinamis('Agama_Ayah', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Agama_Ayah" style="width:100%;"',null,null, ['opt_group'=>'agama']);
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
                													<option value="A" > A </option>
                													<option value="B" > B </option>
                													<option value="AB"> AB </option>
                													<option value="O" > O </option>
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
                                                    <input type="text" class="form-control" id="Kewarganegaraan_Ayah" name="Kewarganegaraan_Ayah" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Jalan / Gang</label>
                                                            <input type="text" class="form-control" id="Alamat_Ayah" name="Alamat_Ayah" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                
                                                    <div class="form-group">
                                                        <label class="col-form-label">No. Rumah </label>
                                                            <input type="text" class="form-control" id="No_Rmh_Ayah" name="No_Rmh_Ayah" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RT<code>*</code></label>
                                                            <input type="text" class="form-control" id="RT_Ayah" name="RT_Ayah" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RW<code>*</code></label>
                                                            <input type="text" class="form-control" id="RW_Ayah" name="RW_Ayah" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Dusun<code>*</code></label>
                                                        <input type="text" class="form-control" id="Dusun_Ayah" name="Dusun_Ayah" />
            
                                                        <div class="invalid-feedback">
            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Propinsi <code>*</code></label>
            
                                                    <select name="Prov_Ayah" id="Prov_Ayah" class="form-control select2" style="width:100%;">
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kabupaten <code>*</code></label>
            
                                                    <select name="Kab_Ayah" id="Kab_Ayah" class="form-control select2" style="width:100%;">
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan <code>*</code></label>
            
                                                    <select name="Kec_Ayah" id="Kec_Ayah" class="form-control select2" style="width:100%;">
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Desa <code>*</code></label>
                
                                                            <select name="Desa_Ayah" id="Desa_Ayah" class="form-control select2" style="width:100%;">
                                                                
                                                            </select>
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                
                                                    <div class="form-group">
                                                        <label class="col-form-label">Kodepos <code>*</code></label>
                                                            <input type="text" class="form-control" id="Kode_Pos_Ayah" name="Kode_Pos_Ayah" />
                
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan Ayah <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pekerjaan_Ayah', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Pekerjaan_Ayah" style="width:100%;"',null,null, ['opt_group'=>'pekerjaan']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pendidikan Ayah <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pendidikan_Terakhir_Ayah', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Pendidikan_Terakhir_Ayah" style="width:100%;"',null,null, ['opt_group'=>'jenj_pendidikan']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Penghasilan Ayah <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Penghasilan_Ayah', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Penghasilan_Ayah" style="width:100%;"',null,null, ['opt_group'=>'penghasilan']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No HP Ayah <code>*</code></label>
                                                <input type="text" class="form-control" id="No_HP_ayah" name="No_HP_ayah" />
                                                <div class="invalid-feedback">
        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pl-2">
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Ibu <code>*</code></label>
                                                    <input type="text" class="form-control" id="Nama_Ibu" name="Nama_Ibu" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">NIK <code>*</code></label>
                                                    <input type="text" class="form-control" id="Nomor_KTP_Ibu" maxlength="16" name="Nomor_KTP_Ibu" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Tempat Lahir <code>*</code></label>
                                                            <input type="text" class="form-control" id="Tempat_Lhr_Ibu" name="Tempat_Lhr_Ibu" />
                
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
                                                                    id="Tgl_Lhr_Ibu" data-toggle="datetimepicker" name="Tgl_Lhr_Ibu" data-target="#reservationdate_ibu" placeholder="DD-MM-YYYY" />
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
                                                            
                                                            echo cmb_dinamis('Agama_Ibu', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Agama_Ibu" style="width:100%;"',null,null, ['opt_group'=>'agama']);
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
                                                    <input type="text" class="form-control" id="Kewarganegaraan_Ibu" name="Kewarganegaraan_Ibu" />
            
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Jalan / Gang</label>
                                                            <input type="text" class="form-control" id="Alamat_Ibu" name="Alamat_Ibu" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                
                                                    <div class="form-group">
                                                        <label class="col-form-label">No. Rumah </label>
                                                            <input type="text" class="form-control" id="No_Rmh_Ibu" name="No_Rmh_Ibu" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RT<code>*</code></label>
                                                            <input type="text" class="form-control" id="RT_Ibu" name="RT_Ibu" />
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label">RW<code>*</code></label>
                                                            <input type="text" class="form-control" id="RW_Ibu" name="RW_Ibu"/>
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Dusun<code>*</code></label>
                                                        <input type="text" class="form-control" id="Dusun_Ibu" name="Dusun_Ibu" />
            
                                                        <div class="invalid-feedback">
            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Propinsi <code>*</code></label>
            
                                                    <select name="Prov_Ibu" id="Prov_Ibu" class="form-control select2" style="width:100%;">
            
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kabupaten <code>*</code></label>
            
                                                    <select name="Kab_Ibu" id="Kab_Ibu" class="form-control select2" style="width:100%;">
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan <code>*</code></label>
            
                                                    <select name="Kec_Ibu" id="Kec_Ibu" class="form-control select2" style="width:100%;">
                                                        
                                                    </select>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Desa <code>*</code></label>
                
                                                            <select name="Desa_Ibu" id="Desa_Ibu" class="form-control select2" style="width:100%;">
                                                                
                                                            </select>
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                
                                                    <div class="form-group">
                                                        <label class="col-form-label">Kodepos <code>*</code></label>
                                                            <input type="text" class="form-control" id="Kode_Pos_Ibu" name="Kode_Pos_Ibu" />
                
                
                                                            <div class="invalid-feedback">
                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan Ibu <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pekerjaan_Ibu', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Pekerjaan_Ibu" style="width:100%;"',null,null, ['opt_group'=>'pekerjaan']);
                                                        ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pendidikan Ibu <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Pendidikan_Terakhir_Ibu', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Pendidikan_Terakhir_Ibu" style="width:100%;"',null,null, ['opt_group'=>'jenj_pendidikan']);
                                                    ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Penghasilan Ibu <code>*</code></label>
                                                    <?php
                                                        
                                                        echo cmb_dinamis('Penghasilan_Ibu', 'ref_option', 'opt_val', 'opt_id', NULL, null, 'id="Penghasilan_Ibu" style="width:100%;"',null,null, ['opt_group'=>'penghasilan']);
                                                    ?>
                                                    <div class="invalid-feedback">
            
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No HP Ibu <code>*</code></label>
                                                <input type="text" class="form-control" id="No_HP_ibu" name="No_HP_ibu" />
                                                <div class="invalid-feedback">
        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                </div>
                            </div>
                            <!-- END DATA ORANG TUA -->
                            
                            <!-- START LOGIN -->
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title"><b>DATA USER LOGIN (Digunakan Untuk Login Aplikasi)</b></h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="col-form-label">Email <code>*</code></label>
                                            <input type="text" class="form-control" id="Email" name="Email" />
    
                                            <div class="invalid-feedback">
    
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Username <code>*</code></label>
                                            <input type="text" class="form-control" id="username" name="username" />
    
                                            <div class="invalid-feedback">
    
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Password <code>*</code></label>
                                            <input type="password" class="form-control" id="password" name="password" />
    
                                            <div class="invalid-feedback">
    
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Konfirmasi Password <code>*</code></label>
                                            <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" />
    
                                            <div class="invalid-feedback">
    
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END LOGIN -->
                        </div>
                        
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" onclick="simpan()">Simpan </button>
                        </div>
                        
                    </div>
                    <!-- /.card -->
                    
                        
                </form>
            </div>
            <!-- /.col-lg-8 -->
            
            <div class="col-lg-4">
                <?php if(!empty(getDataRow('setting_gelombang', ['jenjang' => 'S2', 'Aktif' => '1'])['info_pendaftaran'])){ ?>
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Informasi Pendaftaran</h3>
    
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?=getDataRow('setting_gelombang', ['jenjang' => 'S2', 'Aktif' => '1'])['info_pendaftaran']?>
                  </div>
                  <!-- /.card-body -->
                </div>
                <?php } ?>
                <?php if(!empty(getDataRow('setting_gelombang', ['jenjang' => 'S2', 'Aktif' => '1'])['info_biaya_kuliah'])){ ?>
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Biaya Kuliah</h3>
    
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?=getDataRow('setting_gelombang', ['jenjang' => 'S2', 'Aktif' => '1'])['info_biaya_kuliah']?>
                  </div>
                  <!-- /.card-body -->
                </div>
                <?php } ?>
                <?php if(!empty(getDataRow('setting_gelombang', ['jenjang' => 'S2', 'Aktif' => '1'])['persyaratan'])){ ?>
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Persyaratan</h3>
    
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <?=getDataRow('setting_gelombang', ['jenjang' => 'S2', 'Aktif' => '1'])['persyaratan']?>
                  </div>
                  <!-- /.card-body -->
                </div>
                <?php } ?>
                <?php $dataInfografis = dataDinamis('infografis', ['is_aktif' => 'Y', 'deleted_at' => NULL]);
                        if(!empty($dataInfografis)){
                       
                ?>
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Infografis</h3>
    
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                      <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                        <div class="owl-carousel owl-theme">
                            <?php foreach($dataInfografis as $row){ ?>
                            <div class="item" >
                              <img src="<?=base_url("$row->slider_img");?>" class="img-fluid" alt="<?=$row->slider_title?>">
                            </div>
                            <?php } ?>
                        </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <?php } ?>
            </div>
            <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?=base_url('assets');?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url('assets');?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- daterangepicker -->
<script src="<?=base_url('assets');?>/plugins/moment/moment.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/owlcarousel/owl.carousel.js"></script>
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
    //changeStatusPendaftaran();
    
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
	
	$('.owl-carousel').owlCarousel({
        items: 1,
        margin: 10,
        autoHeight: true,
        loop: true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true
      });

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
                url: "<?php echo site_url("$controller/$metode");?>",
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
                            title: "Pendaftaran berhasil",
                            showDenyButton: true,
                            confirmButtonText: 'Login SIAKAD',
                            denyButtonText: "Kembali",
                            denyButtonColor: '#3085d6',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?=base_url()?>";
                            } else if (result.isDenied) {
                                window.location.href = "<?=base_url("$controller")?>";
                            } 
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
</script>

</body>
</html>
