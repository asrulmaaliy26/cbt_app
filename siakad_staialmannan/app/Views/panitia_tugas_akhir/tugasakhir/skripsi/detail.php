<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>

<script>

    
</script>

<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                    
                <div class="row">
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <table class="table table-sm">
                              <tr>
                                <th style="width:25%">Nama</th>
                                <td>: <?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'])?></td>
                              </tr>
                              <tr>
                                <th >NIM</th>
                                <td>: <?=getDataRow('histori_pddk', ['id_his_pdk'=>$id_his_pdk])['NIM']?></td>
                              </tr>
                              
                              <tr>
                                <th>Pembimbing</th>
                                <td>: <?=getDataRow('data_dosen', ['Kode'=>$dosen_pembimbing])['Nama_Dosen']?></td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <table class="table table-sm">
                              <tr>
                                <th style="width:45%">Tahun Angkatan</th>
                                <td>: <?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['th_angkatan']?></td>
                              </tr>
                              <tr>
                                <th >Fakultas</th>
                                <td>: <?=strtoupper(getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk'=>$id_his_pdk])['Prodi']])['fakultas'])?></td>
                              </tr>
                              
                              <tr>
                                <th>Prodi</th>
                                <td>: <?=strtoupper(getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk'=>$id_his_pdk])['Prodi']])['nm_prodi'])?>
                                </td>
                              </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#persyaratan" data-toggle="tab">Persyaratan</a></li>
              <li class="nav-item"><a class="nav-link" href="#judul_abs" data-toggle="tab">Judul, Abstrak & Kesimpulan</a></li>
              <li class="nav-item"><a class="nav-link" href="#skripsi"  data-toggle="tab">Skripsi</a></li>
              <li class="nav-item"><a class="nav-link" href="#review"  data-toggle="tab">Review Verifikator</a></li>
              <li class="nav-item"><a class="nav-link" href="#hasil"  data-toggle="tab">Hasil Munaqasyah</a></li>
              <li class="nav-item"><a class="nav-link" href="#outcome" data-toggle="tab">Outcome</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="persyaratan">
                
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-hover table-sm">
    	                <thead>
    		                <tr>
    		                    <th class="text-center">No</th>
    		                    <th class="text-center">Nama Dokumen</th>
    		                    <th class="text-center">File</th>
    		                    <th class="text-center">Validasi</th>
    		                </tr>
    	                </thead>
    	                <tbody>
    	                    <tr>
    							<td class="text-center align-middle">1</td>
    							<th class="align-middle">
    								Kwitansi Pembayaran Pendaftaran Munaqasyah Skripsi
    							</th>
    							
    							<td class="text-center align-middle">
    								    
    								<a id="btn_v_kwitansi" onclick="lihat('<?=str_replace( 'http://', 'https://',$kwitansi_pendaftaran)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							
    							</td>
    							<td class="align-middle">
    							   <select onchange="validasi('v_kwitansi')" id="v_kwitansi" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
    									<option value="0" <?php if($v_kwitansi=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
    									<option value="2" <?php if($v_kwitansi=="2") {echo "selected";} ?>>Tidak Diterima</option>
    									<option value="1" <?php if($v_kwitansi=="1") {echo "selected";} ?>>Diterima</option>
    										
    								</select> 
    							</td>
    						</tr>
    						
    						<tr>
								<td class="text-center align-middle">2</td>
								<th class="align-middle">
									Surat keterangan bebas tanggungan BAK
								</th>
								<td class="text-center align-middle">
									<a id="btn_v_bebas_bak" onclick="lihat('<?=str_replace( 'http://', 'https://',$bebas_bak)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
										
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_bebas_bak')" id="v_bebas_bak" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_bebas_bak=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_bebas_bak=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_bebas_bak=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							
							<tr>
								<td class="text-center align-middle">3</td>
								<th class="align-middle">
									Kartu Tanda Mahasiswa (KTM)
								</th>
								<td class="text-center align-middle">
									<a id="btn_v_ktm" onclick="lihat('<?=str_replace( 'http://', 'https://',$ktm)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_ktm')" id="v_ktm" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_ktm=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_ktm=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_ktm=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
                                
							<tr>
								<td class="text-center align-middle">4</td>
								<th class="align-middle">KHS Semester 1 s.d 7 dengan nilai Lulus</th>
								<td class="text-center align-middle">
									<a id="btn_v_khs" onclick="lihat('<?=str_replace( 'http://', 'https://',$khs)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_khs')" id="v_khs" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_khs=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_khs=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_khs=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text-center align-middle">5</td>
								<th class="align-middle">Kartu Bimbingan dengan Tanda Tangan Pembimbing sebanyak 8 kali</th>
								<td class="text-center align-middle">
									<a id="btn_v_kartu_bimbingan" onclick="lihat('<?=str_replace( 'http://', 'https://',$kartu_bimbingan)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_kartu_bimbingan')" id="v_kartu_bimbingan" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_kartu_bimbingan=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_kartu_bimbingan=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_kartu_bimbingan=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text-center align-middle">6</td>
								<th class="align-middle">Lembar Persetujuan Munaqasyah dengan Tanda Tangan Pembimbing</th>
								<td class="text-center align-middle">
									<a id="btn_v_persetujuan_munaqasyah" onclick="lihat('<?=str_replace( 'http://', 'https://',$persetujuan_munaqasyah)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_persetujuan_munaqasyah')" id="v_persetujuan_munaqasyah" style="width: 100%;" class="form-control select2" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_persetujuan_munaqasyah=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_persetujuan_munaqasyah=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_persetujuan_munaqasyah=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text-center align-middle">7</td>
								<th class="align-middle">Sertifikat PBAK</th>
								<td class="text-center align-middle">
									<a id="btn_v_posmaru" onclick="lihat('<?=str_replace( 'http://', 'https://',$posmaru)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_posmaru')" id="v_posmaru" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_posmaru=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_posmaru=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_posmaru=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text-center align-middle">8</td>
								<th class="align-middle">Sertifikat KKN</th>
								<td class="text-center align-middle">
									<a id="btn_v_sertifikat_kkn" onclick="lihat('<?=str_replace( 'http://', 'https://',$sertifikat_kkn)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_sertifikat_kkn')" id="v_sertifikat_kkn" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_sertifikat_kkn=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_sertifikat_kkn=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_sertifikat_kkn=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							
							<tr>
								<td class="text-center align-middle">9</td>
								<th class="align-middle">Sertifikat PPL (Prodi HKI PPL KUA dan PPL PA dijadikan 1 File)</th>
								<td class="text-center align-middle">
									<a id="btn_v_ppl" onclick="lihat('<?=str_replace( 'http://', 'https://',$ppl)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_ppl')" id="v_ppl" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_ppl=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_ppl=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_ppl=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text-center align-middle">10</td>
								<th class="align-middle">Sertifikat Seminar 3 jenis kegiatan (dijadikan 1 file)</th>
								<td class="text-center align-middle">
									<a id="btn_v_sertifikat_seminar" onclick="lihat('<?=str_replace( 'http://', 'https://',$sertifikat_seminar)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_sertifikat_seminar')" id="v_sertifikat_seminar" style="width: 100%;" class="form-control select2" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_sertifikat_seminar=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_sertifikat_seminar=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_sertifikat_seminar=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							
							<tr>
								<td class="text-center align-middle">11</td>
								<th class="align-middle">Surat Keterangan Bebas Plagiasi (LPJI)</th>
								<td class="text-center align-middle">
									<a id="btn_v_plagiasi" onclick="lihat('<?=str_replace( 'http://', 'https://',$plagiasi)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_plagiasi')" id="v_plagiasi" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_plagiasi=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_plagiasi=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_plagiasi=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text-center align-middle">12</td>
								<th class="align-middle">Sertifikat TOEFL / TOAFL</th>
								<td class="text-center align-middle">
									<a id="btn_v_toefl_toafl" onclick="lihat('<?=str_replace( 'http://', 'https://',$toefl_toafl)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_toefl_toafl')" id="v_toefl_toafl" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_toefl_toafl=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_toefl_toafl=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_toefl_toafl=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text-center align-middle">13</td>
								<th class="align-middle">Angket kuesioner monitoring bimbingan tugas akhir</th>
								<td class="text-center align-middle">
									<a id="btn_v_kuesioner" onclick="lihat('<?=str_replace( 'http://', 'https://',$kuesioner)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_kuesioner')" id="v_kuesioner" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_kuesioner=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_kuesioner=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_kuesioner=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text-center align-middle">14</td>
								<th class="align-middle">File Powerpoint Presentasi</th>
								<td class="text-center align-middle">
									<a id="btn_v_powerpoint" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$powerpoint?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_powerpoint')" id="v_powerpoint" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_powerpoint=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_powerpoint=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_powerpoint=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
							<tr>
								<td class="text-center align-middle">15</td>
								<th class="align-middle">File Skripsi Hasil Cek Plagiasi LPJI</th>
								<td class="text-center align-middle">
									<a id="btn_v_skripsi" onclick="lihat('<?=str_replace( 'http://', 'https://',$skripsi)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_skripsi')" id="v_skripsi" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_skripsi=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_skripsi=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_skripsi=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
							</tr>
    
    						
    	                </tbody>
                    </table>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="judul_abs">
                    <div class="row">
                        <div class="col-12">
                            <h4><strong>Judul Skripsi</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=strip_tags($judul_skripsi)?>
                              </p>
                              
                              
                            </div>
                            
                            <h4><strong>Abstrak</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$abstrak?>
                              </p>
                              
                              
                            </div>
                            
                            
                            <h4><strong>Kesimpulan</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$kesimpulan?>
                              </p>
                              
                            </div>
                            
                            
                        </div>
                    </div>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane" id="skripsi">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
    	                <thead>
    		                <tr>
    		                    <th class="text-center align-middle">Nama Dokumen</th>
    		                    <th class="text-center align-middle">File</th>
    		                    <th class="text-center align-middle">Validasi</th>
    		                    <th class="text-center align-middle">Catatan Penguji</th>
    		                    <th class="text-center align-middle">Input Catatan</th>
    		                </tr>
    	                </thead>
    	                <tbody>
    	                        <?php 
    							        $komen1 = getDataRow('hasil_skripsi', ['id_munaqasyah' => $id_munaqasyah, 'penguji' => '1']);
                                        $komen2 = getDataRow('hasil_skripsi', ['id_munaqasyah' => $id_munaqasyah, 'penguji' => '2']);
                                        $komen3 = getDataRow('hasil_skripsi', ['id_munaqasyah' => $id_munaqasyah, 'penguji' => '3']);
                                ?>
    	                    <tr>
    							
    							<th >
    								Cover, Pengesahan, Motto, Daftar Isi, Persembahan
    							</th>
    							
    							<td class="text-center ">
    								<?php if(!empty($bag_depan)){ ?>    
    								<a id="btn_v_bag_depan" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$bag_depan?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							    <?php } ?>
    							</td>
    							<td >
    							   <select onchange="validasi('v_bag_depan')" id="v_bag_depan" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
    									<option value="0" <?php if($v_bag_depan=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
    									<option value="2" <?php if($v_bag_depan=="2") {echo "selected";} ?>>Tidak Diterima</option>
    									<option value="1" <?php if($v_bag_depan=="1") {echo "selected";} ?>>Diterima</option>
    										
    								</select> 
    							</td>
    							<td>
    							    <?=(!empty($komen1))?$komen1['bag_depan']:''?>
    							    <?php if(!empty($komen1['bag_depan']) || !empty($komen2['bag_depan']) || !empty($komen3['bag_depan'])){ ?>
                
                                        <div class="col-12" id="komen_bag_depan">
                                          
                                              <?php if(!empty($komen1['bag_depan'])){?>
                                              <b class="d-block">Penguji 1</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen1['bag_depan']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen2['bag_depan'])){?>
                                              <b class="d-block">Penguji 2</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen2['bag_depan']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen3['bag_depan'])){?>
                                              <b class="d-block">Sekretaris</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen3['bag_depan']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                            
                                        </div>
                                      
                                    <?php }else{ ?>
                                        <div class="col-12" id="komen_bag_depan"></div>
                                    <?php } ?>
    							</td>
    							<td>
    							    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm">Input Catatan</button>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a onclick="komentar('<?=$id_munaqasyah?>','1','bag_depan','Halaman Depan (Cover, Motto, Daftar isi, dll.)')"  class="dropdown-item text-sm">Penguji 1</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','2','bag_depan','Halaman Depan (Cover, Motto, Daftar isi, dll.)')"  class="dropdown-item text-sm">Penguji 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','3','bag_depan','Halaman Depan (Cover, Motto, Daftar isi, dll.)')" class="dropdown-item text-sm">Sekretaris</a>
                                        </div>
                                    </div>
    							</td>
    						</tr>
    						
    						<tr>
								<th >
									BAB I
								</th>
								<td class="text-center ">
									<?php if(!empty($bab1)){ ?>    
    								<a id="btn_v_bab1" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$bab1?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							    <?php } ?>
								</td>
								<td >
								    <select onchange="validasi('v_bab1')" id="v_bab1" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_bab1=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_bab1=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_bab1=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td>
								    
								    <?php if(!empty($komen1['bab1']) || !empty($komen2['bab1']) || !empty($komen3['bab1'])){ ?>
                
                                        <div class="col-12" id="komen_bab1">
                                          
                                              <?php if(!empty($komen1['bab1'])){?>
                                              <b class="d-block">Penguji 1</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen1['bab1']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen2['bab1'])){?>
                                              <b class="d-block">Penguji 2</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen2['bab1']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen3['bab1'])){?>
                                              <b class="d-block">Sekretaris</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen3['bab1']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                            
                                        </div>
                                      
                                    <?php }else{ ?>
                                        <div class="col-12" id="komen_bab1"></div>
                                    <?php } ?>
							    </td>
    							<td>
    							    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm">Input Catatan</button>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a onclick="komentar('<?=$id_munaqasyah?>','1','bab1','BAB I')"  class="dropdown-item text-sm">Penguji 1</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','2','bab1','BAB I')"  class="dropdown-item text-sm">Penguji 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','3','bab1','BAB I')" class="dropdown-item text-sm">Sekretaris</a>
                                        </div>
                                    </div>
    							</td>
							</tr>
							
							<tr>
							    <th >
									BAB II
								</th>
								<td class="text-center ">
									<?php if(!empty($bab2)){ ?>    
    								<a id="btn_v_bab2" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$bab2?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							    <?php } ?>
								</td>
								<td >
								    <select onchange="validasi('v_bab2')" id="v_bab2" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_bab2=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_bab2=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_bab2=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td>
								    <?php if(!empty($komen1['bab2']) || !empty($komen2['bab2']) || !empty($komen3['bab2'])){ ?>
                
                                        <div class="col-12" id="komen_bab2">
                                          
                                              <?php if(!empty($komen1['bab2'])){?>
                                              <b class="d-block">Penguji 1</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen1['bab2']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen2['bab2'])){?>
                                              <b class="d-block">Penguji 2</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen2['bab2']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen3['bab2'])){?>
                                              <b class="d-block">Sekretaris</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen3['bab2']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                            
                                        </div>
                                      
                                    <?php }else{ ?>
                                        <div class="col-12" id="komen_bab2"></div>
                                    <?php } ?>
								</td>
    							<td>
    							    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm">Input Catatan</button>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a onclick="komentar('<?=$id_munaqasyah?>','1','bab2','BAB II')"  class="dropdown-item text-sm">Penguji 1</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','2','bab2','BAB II')"  class="dropdown-item text-sm">Penguji 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','3','bab2','BAB II')" class="dropdown-item text-sm">Sekretaris</a>
                                        </div>
                                    </div>
    							</td>
							</tr>
                                
							<tr>
								<th >BAB III</th>
								<td class="text-center ">
									<?php if(!empty($bab3)){ ?>    
    								<a id="btn_v_bab3" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$bab3?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							    <?php } ?>
								</td>
								<td >
								    <select onchange="validasi('v_bab3')" id="v_bab3" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_bab3=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_bab3=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_bab3=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td>
								    <?php if(!empty($komen1['bab3']) || !empty($komen2['bab3']) || !empty($komen3['bab3'])){ ?>
                
                                        <div class="col-12" id="komen_bab3">
                                          
                                              <?php if(!empty($komen1['bab3'])){?>
                                              <b class="d-block">Penguji 1</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen1['bab3']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen2['bab3'])){?>
                                              <b class="d-block">Penguji 2</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen2['bab3']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen3['bab3'])){?>
                                              <b class="d-block">Sekretaris</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen3['bab3']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                            
                                        </div>
                                      
                                    <?php }else{ ?>
                                        <div class="col-12" id="komen_bab3"></div>
                                    <?php } ?>
								</td>
    							<td>
    							    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm">Input Catatan</button>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a onclick="komentar('<?=$id_munaqasyah?>','1','bab3','BAB III')"  class="dropdown-item text-sm">Penguji 1</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','2','bab3','BAB III')"  class="dropdown-item text-sm">Penguji 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','3','bab3','BAB III')" class="dropdown-item text-sm">Sekretaris</a>
                                        </div>
                                    </div>
    							</td>
							</tr>
							<tr>
								<th >BAB IV</th>
								<td class="text-center ">
									<?php if(!empty($bab4)){ ?>    
    								<a id="btn_v_bab4" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$bab4?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							    <?php } ?>
								</td>
								<td >
								    <select onchange="validasi('v_bab4')" id="v_bab4" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_bab4=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_bab4=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_bab4=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td>
								    <?php if(!empty($komen1['bab4']) || !empty($komen2['bab4']) || !empty($komen3['bab4'])){ ?>
                
                                        <div class="col-12" id="komen_bab4">
                                          
                                              <?php if(!empty($komen1['bab4'])){?>
                                              <b class="d-block">Penguji 1</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen1['bab4']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen2['bab4'])){?>
                                              <b class="d-block">Penguji 2</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen2['bab4']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen3['bab4'])){?>
                                              <b class="d-block">Sekretaris</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen3['bab4']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                            
                                        </div>
                                      
                                    <?php }else{ ?>
                                        <div class="col-12" id="komen_bab4"></div>
                                    <?php } ?>
								</td>
    							<td>
    							    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm">Input Catatan</button>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a onclick="komentar('<?=$id_munaqasyah?>','1','bab4','BAB IV')"  class="dropdown-item text-sm">Penguji 1</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','2','bab4','BAB IV')"  class="dropdown-item text-sm">Penguji 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','3','bab4','BAB IV')" class="dropdown-item text-sm">Sekretaris</a>
                                        </div>
                                    </div>
    							</td>
							</tr>
							<tr>
								<th >BAB V</th>
								<td class="text-center">
									<?php if(!empty($bab5)){ ?>    
    								<a id="btn_v_bab5" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$bab5?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							    <?php } ?>
								</td>
								<td >
								    <select onchange="validasi('v_bab5')" id="v_bab5" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_bab5=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_bab5=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_bab5=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td>
								    <?php if(!empty($komen1['bab5']) || !empty($komen2['bab5']) || !empty($komen3['bab5'])){ ?>
                
                                        <div class="col-12" id="komen_bab5">
                                          
                                              <?php if(!empty($komen1['bab5'])){?>
                                              <b class="d-block">Penguji 1</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen1['bab5']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen2['bab5'])){?>
                                              <b class="d-block">Penguji 2</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen2['bab5']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen3['bab5'])){?>
                                              <b class="d-block">Sekretaris</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen3['bab5']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                            
                                        </div>
                                      
                                    <?php }else{ ?>
                                        <div class="col-12" id="komen_bab5"></div>
                                    <?php } ?>
								</td>
    							<td>
    							    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm">Input Catatan</button>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a onclick="komentar('<?=$id_munaqasyah?>','1','bab5','BAB V')"  class="dropdown-item text-sm">Penguji 1</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','2','bab5','BAB V')"  class="dropdown-item text-sm">Penguji 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','3','bab5','BAB V')" class="dropdown-item text-sm">Sekretaris</a>
                                        </div>
                                    </div>
    							</td>
							</tr>
							<?php if(!empty($bab6)){ ?>
							<tr>
								<th >BAB VI (Jika Ada)</th>
								<td class="text-center ">
									<?php if(!empty($bab6)){ ?>    
    								<a id="btn_v_bab6" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$bab6?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							    <?php } ?>
								</td>
								<td >
								    <select onchange="validasi('v_bab6')" id="v_bab6" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_bab6=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_bab6=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_bab6=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td>
								    <?php if(!empty($komen1['bab6']) || !empty($komen2['bab6']) || !empty($komen3['bab6'])){ ?>
                
                                        <div class="col-12" id="komen_bab6">
                                          
                                              <?php if(!empty($komen1['bab6'])){?>
                                              <b class="d-block">Penguji 1</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen1['bab6']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen2['bab6'])){?>
                                              <b class="d-block">Penguji 2</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen2['bab6']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen3['bab6'])){?>
                                              <b class="d-block">Sekretaris</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen3['bab6']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                            
                                        </div>
                                      
                                    <?php }else{ ?>
                                        <div class="col-12" id="komen_bab6"></div>
                                    <?php } ?>
								</td>
    							<td>
    							    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm">Input Catatan</button>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a onclick="komentar('<?=$id_munaqasyah?>','1','bab6','BAB VI')"  class="dropdown-item text-sm">Penguji 1</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','2','bab6','BAB VI')"  class="dropdown-item text-sm">Penguji 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','3','bab6','BAB VI')" class="dropdown-item text-sm">Sekretaris</a>
                                        </div>
                                    </div>
    							</td>
							</tr>
							<?php } ?>
							<tr>
								<th >Daftar Pustaka</th>
								<td class="text-center ">
									<?php if(!empty($pustaka)){ ?>    
    								<a id="btn_v_pustaka" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$pustaka?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							    <?php } ?>
								</td>
								<td >
								    <select onchange="validasi('v_pustaka')" id="v_pustaka" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_pustaka=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_pustaka=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_pustaka=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td>
								    <?php if(!empty($komen1['pustaka']) || !empty($komen2['pustaka']) || !empty($komen3['pustaka'])){ ?>
                
                                        <div class="col-12" id="komen_pustaka">
                                          
                                              <?php if(!empty($komen1['pustaka'])){?>
                                              <b class="d-block">Penguji 1</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen1['pustaka']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen2['pustaka'])){?>
                                              <b class="d-block">Penguji 2</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen2['pustaka']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen3['pustaka'])){?>
                                              <b class="d-block">Sekretaris</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen3['pustaka']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                            
                                        </div>
                                      
                                    <?php }else{ ?>
                                        <div class="col-12" id="komen_pustaka"></div>
                                    <?php } ?>
								</td>
    							<td>
    							    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm">Input Catatan</button>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a onclick="komentar('<?=$id_munaqasyah?>','1','pustaka','Daftar Pustaka')"  class="dropdown-item text-sm">Penguji 1</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','2','pustaka','Daftar Pustaka')"  class="dropdown-item text-sm">Penguji 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','3','pustaka','Daftar Pustaka')" class="dropdown-item text-sm">Sekretaris</a>
                                        </div>
                                    </div>
                                </td>
							</tr>
							<?php if(!empty($lampiran)){ ?>
							<tr>
								<th >Lampiran-lampiran (Jika Ada)</th>
								<td class="text-center ">
									<?php if(!empty($lampiran)){ ?>    
    								<a id="btn_v_lampiran" onclick="lihat('https://view.officeapps.live.com/op/embed.aspx?src=<?=$lampiran?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							    <?php } ?>
								</td>
								<td >
								    <select onchange="validasi('v_lampiran')" id="v_lampiran" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_lampiran=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_lampiran=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_lampiran=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td>
								    <?php if(!empty($komen1['lampiran']) || !empty($komen2['lampiran']) || !empty($komen3['lampiran'])){ ?>
                
                                        <div class="col-12" id="komen_lampiran">
                                          
                                              <?php if(!empty($komen1['lampiran'])){?>
                                              <b class="d-block">Penguji 1</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen1['lampiran']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen2['lampiran'])){?>
                                              <b class="d-block">Penguji 2</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen2['lampiran']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                              
                                              <?php if(!empty($komen3['lampiran'])){?>
                                              <b class="d-block">Sekretaris</b>
                                              <div class="post clearfix">
                                                  
                                                    <?=$komen3['lampiran']?>
                                                  
                                              </div>    
                                              <?php } ?>
                                            
                                        </div>
                                      
                                    <?php }else{ ?>
                                        <div class="col-12" id="komen_lampiran"></div>
                                    <?php } ?>
								</td>
    							<td>
    							    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm">Input Catatan</button>
                                        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a onclick="komentar('<?=$id_munaqasyah?>','1','lampiran','Lampiran-lampiran')"  class="dropdown-item text-sm">Penguji 1</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','2','lampiran','Lampiran-lampiran')"  class="dropdown-item text-sm">Penguji 2</a>
                                            <div class="dropdown-divider"></div>
                                            <a onclick="komentar('<?=$id_munaqasyah?>','3','lampiran','Lampiran-lampiran')" class="dropdown-item text-sm">Sekretaris</a>
                                        </div>
                                    </div>
    							</td>
							</tr>
							<?php } ?>
    	                </tbody>
                    </table>
                    </div>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane" id="review">
                    <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:25%" class="align-middle">Status</th>
                            <td>
                                <?php
                                    echo cmb_dinamis('status', 'ref_option', 'opt_val', 'opt_id', $status, null, 'id="status"  style="width: 100%;" onchange="simpan_catatan('."'status','".$id_munaqasyah."'".')"', null, null, ['opt_group' => 'status_proposal', 'is_aktif !=' => 'N']);
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Catatan</th>
                            <td>
                                <input type="text" id="catatan_verifikator" name="catatan_verifikator" onfocusout="simpan_catatan('catatan_verifikator','<?=$id_munaqasyah;?>')" class="form-control" value="<?=$catatan_verifikator;?>" />
                            </td>
                          </tr>
                          
                          <tr>
                            <th class="align-middle">Tgl. Munaqasyah</th>
                            <td>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="tgl_sidang" data-toggle="datetimepicker" name="tgl_sidang"
                                        data-target="#reservationdate" placeholder="YYYY-MM-DD" value="<?=$tgl_sidang;?>" onfocusout="simpan_catatan('tgl_sidang','<?=$id_munaqasyah;?>')"/>
                                    <div class="input-group-append" data-target="#reservationdate"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback">

                                    </div>
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Penguji 1</th>
                            <td>
                                <?php
                                    $penguji1 = (!empty(getDataRow('penguji_skripsi', ['id_munaqasyah' => $id_munaqasyah, 'tugas' => 1])))?getDataRow('penguji_skripsi', ['id_munaqasyah' => $id_munaqasyah, 'tugas' => 1])['kd_dosen']:NULL;
                                    echo cmb_dinamis('penguji_1', 'data_dosen', 'Nama_Dosen', 'Kode', $penguji1, null, 'id="penguji_1"  style="width: 100%;" onchange="simpan_penguji('."'1','".$id_munaqasyah."'".')"');
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Penguji 2</th>
                            <td>
                                <?php
                                    $penguji2 = (!empty(getDataRow('penguji_skripsi', ['id_munaqasyah' => $id_munaqasyah, 'tugas' => 2])))?getDataRow('penguji_skripsi', ['id_munaqasyah' => $id_munaqasyah, 'tugas' => 2])['kd_dosen']:NULL;
                                    echo cmb_dinamis('penguji_2', 'data_dosen', 'Nama_Dosen', 'Kode', $penguji2, null, 'id="penguji_2"  style="width: 100%;" onchange="simpan_penguji('."'2','".$id_munaqasyah."'".')"');
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Ketua dan Sekretaris</th>
                            <td>
                                <?php
                                    $penguji3 = (!empty(getDataRow('penguji_skripsi', ['id_munaqasyah' => $id_munaqasyah, 'tugas' => 3])))?getDataRow('penguji_skripsi', ['id_munaqasyah' => $id_munaqasyah, 'tugas' => 3])['kd_dosen']:NULL;
                                    echo cmb_dinamis('penguji_3', 'data_dosen', 'Nama_Dosen', 'Kode', $penguji3, null, 'id="penguji_3"  style="width: 100%;" onchange="simpan_penguji('."'3','".$id_munaqasyah."'".')"');
                                ?>
                            </td>
                          </tr>
                        </table>
                    </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="hasil">
                    <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th class="align-middle">Nilai Angka</th>
                            <td>
                                <?php
                                    
                                    if(!empty($komen1['penyampaian']) && !empty($komen1['penulisan']) && !empty($komen1['metode']) && !empty($komen1['konten']) && !empty($komen2['penyampaian']) && !empty($komen2['penulisan']) && !empty($komen2['metode']) && !empty($komen2['konten'])){
                                        $nilai = ($komen1['penyampaian']+$komen1['penulisan']+$komen1['metode']+$komen1['konten']+$komen2['penyampaian']+$komen2['penulisan']+$komen2['metode']+$komen2['konten'])/2;
                                        echo number_format($nilai,2);
                                    }
                                    
                                    if(empty($komen1['penyampaian']) || empty($komen1['penulisan']) || empty($komen1['metode']) || empty($komen1['konten'])){
                                        echo "<span class='badge badge-danger'>Penilaian Penguji 1 belum lengkap</span>";
                                    }
                                    if(empty($komen2['penyampaian']) || empty($komen2['penulisan']) || empty($komen2['metode']) || empty($komen2['konten'])){
                                        echo "<span class='badge badge-danger'>Penilaian Penguji 2 belum lengkap</span>";
                                    }
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Nilai Index</th>
                            <td>
                                <?php
                                    
                                    if(!empty($komen1['penyampaian']) && !empty($komen1['penulisan']) && !empty($komen1['metode']) && !empty($komen1['konten']) && !empty($komen2['penyampaian']) && !empty($komen2['penulisan']) && !empty($komen2['metode']) && !empty($komen2['konten'])){
                                        $nilai = ($komen1['penyampaian']+$komen1['penulisan']+$komen1['metode']+$komen1['konten']+$komen2['penyampaian']+$komen2['penulisan']+$komen2['metode']+$komen2['konten'])/2;
                                		$grade_nilai=  dataDinamis('grade_nilai');
                                		foreach ($grade_nilai as $s)
                                        {
                                            if($nilai >=$s->batas_bawah_puluhan and $nilai <= $s->batas_atas_puluhan)
                                            {
                                                $predikat= $s->grade;
                                                $nilai_desimal = $s->batas_atas;
                                            }
                                        }
                                        
                                        echo $nilai_desimal." (".$predikat.")";
                                    }
                                    
                                    if(empty($komen1['penyampaian']) || empty($komen1['penulisan']) || empty($komen1['metode']) || empty($komen1['konten'])){
                                        echo "<span class='badge badge-danger'>Penilaian Penguji 1 belum lengkap</span>";
                                    }
                                    if(empty($komen2['penyampaian']) || empty($komen2['penulisan']) || empty($komen2['metode']) || empty($komen2['konten'])){
                                        echo "<span class='badge badge-danger'>Penilaian Penguji 2 belum lengkap</span>";
                                    }
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Rincian Nilai</th>
                            <td>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;" width="5%">No.</th>
                                            <th style="text-align:center;" width="25%">Unsur Penilaian</th>
                                            <th style="text-align:center;" width="15%">Interval Skor</th>
                                            <th style="text-align:center;">Penguji 1</th>
                                            <th style="text-align:center;">Penguji 2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                			<td style="text-align:center;">1</td>
                                			<td >Penyampaian</td>
                                			<td style="text-align:center;">1 - 10</td>
                                			<td style="text-align:center;"><?=(!empty($komen1))?$komen1['penyampaian']:''?></td>
                                			<td style="text-align:center;"><?=(!empty($komen2))?$komen2['penyampaian']:''?></span></td>
                                		</tr>
                                		<tr>
                                			<td style="text-align:center;">2</td>
                                			<td >Teknik Penulisan</td>
                                			<td style="text-align:center;">1 - 25</td>
                                			<td style="text-align:center;"><?=(!empty($komen1))?$komen1['penulisan']:''?></td>
                                			<td style="text-align:center;"><?=(!empty($komen2))?$komen2['penulisan']:''?></td>
                                		</tr>
                                		<tr>
                                			<td style="text-align:center;">3</td>
                                			<td >Ketepatan Metode</td>
                                			<td style="text-align:center;">1 - 25</td>
                                			<td style="text-align:center;"><?=(!empty($komen1))?$komen1['metode']:''?></td>
                                			<td style="text-align:center;"><?=(!empty($komen2))?$komen2['metode']:''?></td>
                                		</tr>
                                		<tr>
                                			<td style="text-align:center;">4</td>
                                			<td >Konten</td>
                                			<td style="text-align:center;">1 - 40</td>
                                			<td style="text-align:center;"><?=(!empty($komen1))?$komen1['konten']:''?></td>
                                			<td style="text-align:center;"><?=(!empty($komen2))?$komen2['konten']:''?></td>
                                		</tr>
                                    </tbody>
                                </table>
                            </td>
                          </tr>
                          
                          <tr>
                            <th class="align-middle"></th>
                            <td>
                                <?php if(!empty($komen1['penyampaian']) && !empty($komen1['penulisan']) && !empty($komen1['metode']) && !empty($komen1['konten']) && !empty($komen2['penyampaian']) && !empty($komen2['penulisan']) && !empty($komen2['metode']) && !empty($komen2['konten'])){?>
                                <button onclick="window.open('<?=base_url();?>/tugasakhir/<?=$controller;?>/cetak_hasil_skripsi?id=<?=$id_munaqasyah;?>', '', 'width=800, height=600, status=1,scrollbar=yes'); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-print"></i>
            						Download Hasil Seminar
            					</button>        
                                <?php    } ?>
                                <button onclick="input_nilai('<?=$id_munaqasyah?>')" class="btn btn-sm btn-primary">
            						<i class="fa fa-edit"></i>
            						Input Nilai
            					</button>  
                            </td>
                          </tr>
                          
                        </table>
                    </div>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane" id="outcome">
                    <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:25%" class="align-middle">Revisi Skripsi</th>
                            <td>
                                <?php if(!empty($revisi) ){?>
                                <button onclick="window.open('<?=$revisi?>', '', 'width=800, height=600, status=1,scrollbar=yes'); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-print"></i>
            						Download Revisi
            					</button>        
                                <?php    } ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Pengesahan Revisi</th>
                            <td>
                                <?php if(!empty($pengesahan_revisi) ){?>
                                <button onclick="window.open('<?=$pengesahan_revisi?>', '', 'width=800, height=600, status=1,scrollbar=yes'); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-print"></i>
            						Download Pengesahan Revisi
            					</button>        
                                <?php    } ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Link Jurnal</th>
                            <td>
                                <?php if(!empty($link_jurnal) ){?>
                                <button onclick="window.open('<?=$link_jurnal?>', '', 'width=800, height=600, status=1,scrollbar=yes'); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-globe"></i>
            						Buka Jurnal
            					</button>        
                                <?php    } ?>
                            </td>
                          </tr>
                          
                        </table>
                    </div>
              </div>
              <!-- /.tab-pane -->
              
              
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>

    </div>
</section>


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
    bsCustomFileInput.init();
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD',
        viewMode: 'years',
        widgetPositioning: {
            vertical: 'bottom', // always opens to buttom direction
        },
    });
    $('[data-mask]').inputmask();
    $(document).ready(function(){
        var id = "<?=$id_munaqasyah;?>";
        var status = "<?=$status;?>";
        var link_revisi = "<?=$revisi;?>";
        var link_pengesahan = "<?=$pengesahan_revisi;?>";
		getValidasi('v_kwitansi', id);
		getValidasi('v_bebas_bak', id);
		getValidasi('v_ktm', id);
		getValidasi('v_khs', id);
		getValidasi('v_kartu_bimbingan', id);
		getValidasi('v_persetujuan_munaqasyah', id);
		getValidasi('v_posmaru', id);
		getValidasi('v_sertifikat_kkn', id);
		getValidasi('v_ppl', id);
		getValidasi('v_sertifikat_seminar', id);
		getValidasi('v_skripsi', id);
		getValidasi('v_kuesioner', id);
		getValidasi('v_powerpoint', id);
		getValidasi('v_plagiasi', id);
		getValidasi('v_toefl_toafl', id);
		getValidasi('v_bag_depan', id);
		getValidasi('v_bab1', id);
		getValidasi('v_bab2', id);
		getValidasi('v_bab3', id);
		getValidasi('v_bab4', id);
		getValidasi('v_bab5', id);
		getValidasi('v_bab6', id);
		getValidasi('v_pustaka', id);
		getValidasi('v_lampiran', id);
	});
})

function getValidasi(field, id){
    $.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/getValidasi");?>",
		data:"id="+id+"&field="+field,
		dataType: 'json',
		success: function(data)
		{
            if(data.nilai==0){
                $("#btn_"+data.field).attr('class',"btn btn-xs btn-warning");
                $("#btn_"+data.field).find("i").attr('class',"fas fa-check fa-lg text-green");
            }else if(data.nilai==2){
                $("#btn_"+data.field).attr('class',"btn btn-xs btn-danger");
                $("#btn_"+data.field).find("i").attr('class',"fas fa-times fa-lg");
            }else{
                $("#btn_"+data.field).attr('class',"btn btn-xs btn-success");
                $("#btn_"+data.field).find("i").attr('class',"fas fa-check fa-lg");
            };
	            
		}
	});
    return true;
}
function validasi(field) {
	//var program=$("#program").val();
	var id="<?=$id_munaqasyah;?>";
	var nilai=$("#"+field).val();
	$.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/validasi");?>",
		data:"id="+id+"&nilai="+nilai+"&field="+field,
		type: "post",
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
		success: function(data)
		{
		    Swal.close();
		    if (data.msg == "success") {
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
                getValidasi(data.field, id);
                
		    }else{
		        Swal.fire({
                    icon: data.msg,
                    title: data.pesan,
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
            //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
    return true;
}
function simpan_penguji(tugas,id_munaqasyah) {
	
	var dosen_penguji=$("#penguji_"+tugas).val();
	$.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/simpan_penguji");?>",
		data:"id_munaqasyah="+id_munaqasyah+"&kd_dosen="+dosen_penguji+"&tugas="+tugas,
		type: "post",
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
		success: function(data)
		{
            Swal.close();
		    if (data.msg == "success") {
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
		        Swal.fire({
                    icon: data.msg,
                    title: data.pesan,
                    allowOutsideClick: false,
                })
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
	});
    return true;
}

function simpan_catatan(field,id) {
	var catatan = $("#"+field).val();
	$.ajax({
		url: "<?php echo site_url("tugasakhir/$controller/simpan_catatan")?>",
        data: "id="+id+"&catatan="+catatan+"&field="+field,
        type: "post",
        dataType: "JSON",
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
        success: function(data)
		{
		    Swal.close();
		    if (data.msg == "success") {
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
		        Swal.fire({
                    icon: data.msg,
                    title: data.pesan,
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
            //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	})

}



function reload_table(){
    table.ajax.reload(null, false);
}

function lihat(link){
    //var link = link;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Persyaratan',
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

function komentar(id,tugas,field,konten){
    var link = "<?=base_url()?>"+"/tugasakhir/skripsi/komentar?id="+id+"&tugas="+tugas+"&field="+field+"&konten="+konten;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
   
    $.buatModal({
      title:'Komentar '+konten,
      message: iframe,
      closeButton:true,
      reload:true,
      id_munaqasyah:id,
      penguji:tugas,
      kolom:field,
      //confirmButton:true,
      scrollable:false
    });
    return false;
}

function getKomen(id_munaqasyah, penguji, field){
    $.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/getKomen");?>",
		data:{id_munaqasyah:id_munaqasyah, penguji:penguji, field:field},
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
		success: function(html)
		{
	            
	            Swal.close();
	            $("#komen_"+field).html(html);
		}
	});
}

function input_nilai(id){
    var link = "<?=base_url()?>"+"/tugasakhir/skripsi/input_nilai?id="+id;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
   
    $.buatModal({
      title:'Input Nilai ',
      message: iframe,
      closeButton:true,
      reload_page:true,
      //confirmButton:true,
      scrollable:false
    });
    return false;
}


(function(a){
    a.buatModal=function(b){
      defaults={
        title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false
      };
      var b=a.extend({},defaults,b);
      var c=(b.scrollable===true)?'style=" overflow-y: auto;"':"";
      html='<div class="modal fade" id="myModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
      html+='<div class="modal-dialog" style="max-width: 90%;" role="document">';
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
      if(b.status_transaksi && b.status_transaksi!=='Sukses'){
        html+='<a role="button" href="javascript:void(0)" onclick="confirmBayar('+b.id_transaksi+')" class="btn btn-sm btn-success" rel="noopener">Konfirmasi</a>'
      }
      if(b.status_transaksi && b.status_transaksi==='Sukses'){
        html+='<a role="button" href="'+b.link_cetak+'" class="btn btn-sm btn-primary" rel="noopener" target="_blank"><i class="fas fa-print"></i> Print</a>'
      }
      if(b.closeButton===true){
        html+='<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>'
      }
      
      html+="</div>";
      html+="</div>";
      html+="</div>";
      html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){
        a(this).remove();
        if(b.reload===true){
            getKomen(b.id_munaqasyah,b.penguji,b.kolom);
        }
        
        if(b.reload_page===true){
            location.reload();
        }
        
      })}})(jQuery);
        
$(function(){    
  $('.show_modal').on('click',function(){
    var link = $(this).attr('href');      
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    var tabel = $(this).attr('tabel');
    var titel =  $(this).attr('judul_modal');
    $.buatModal({
      title:titel,
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_transaksi,
      //status_transaksi: status_transaksi,
      closeButton:false,
      reload_table:true,
      tabel:tabel,
      scrollable:false
    });
    return false;        
  });    
});

</script>
<?=$this->endSection();?>