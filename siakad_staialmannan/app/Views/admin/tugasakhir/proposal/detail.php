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
                                <td>: <?=getDataRow('data_dosen', ['Kode'=>$id_dosen])['Nama_Dosen']?></td>
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
              <li class="nav-item"><a class="nav-link" href="#proposal" data-toggle="tab">Proposal</a></li>
              <li class="nav-item"><a class="nav-link" href="#jadwal"  data-toggle="tab">Jadwal</a></li>
              <li class="nav-item"><a class="nav-link" href="#hasil_seminar"  data-toggle="tab">Hasil Seminar</a></li>
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
    		                    <th class="text-center">Keterangan</th>
    		                    <th class="text-center"></th>
    		                </tr>
    	                </thead>
    	                <tbody>
    	                    <tr>
    							<td class="text-center align-middle">1</td>
    							<th class="align-middle">
    								Kwitansi Pembayaran Pendaftaran Seminar Proposal
    							</th>
    							
    							<td class="text-center align-middle">
    								    
    								<a id="btn_v_kwitansi" onclick="lihat('<?=str_replace( 'http://', 'https://',$kwitansi)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
    							
    							</td>
    							<td class="align-middle">
    							   <select onchange="validasi('v_kwitansi')" id="v_kwitansi" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
    									<option value="0" <?php if($v_kwitansi=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
    									<option value="2" <?php if($v_kwitansi=="2") {echo "selected";} ?>>Tidak Diterima</option>
    									<option value="1" <?php if($v_kwitansi=="1") {echo "selected";} ?>>Diterima</option>
    										
    								</select> 
    							</td>
    							<td class="align-middle">
    							    <input type="text" id="catatan_kwitansi" name="catatan_kwitansi" onfocusout="simpan_catatan('catatan_kwitansi','<?=$id;?>')" class="form-control" value="<?=$catatan_kwitansi;?>" />
    							</td>
    							<td class="text-center align-middle">
    								    
    								<a href="<?=base_url("tugasakhir/$controller/uploadUlang?id=").$id."&field=kwitansi"?>" judul_modal="Upload Kwitansi Pembayaran Pendaftaran Seminar Proposal" class="btn btn-xs btn-primary show_modal" data-placement="top" title="Upload Ulang"><i class="fas fa-upload"></i></a>
    							
    							</td>
    						</tr>
    						
    						<tr>
								<td class="text-center align-middle">2</td>
								<th class="align-middle">
									Surat Rekomendasi mengikuti seminar proposal yang <strong>ditandatangani dosen pembimbing</strong>
								</th>
								<td class="text-center align-middle">
									<a id="btn_v_rekom" onclick="lihat('<?=str_replace( 'http://', 'https://',$rekom)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
										
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_rekom')" id="v_rekom" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_rekom=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_rekom=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_rekom=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td class="align-middle">
								    <input type="text" id="catatan_rekom" name="catatan_rekom" onfocusout="simpan_catatan('catatan_rekom','<?=$id;?>')" class="form-control" value="<?=$catatan_rekom;?>" />
								</td>
								<td class="text-center align-middle">
    								    
    								<a href="<?=base_url("tugasakhir/$controller/uploadUlang?id=").$id."&field=rekom"?>" judul_modal="Upload Surat Rekomendasi mengikuti seminar proposal" class="btn btn-xs btn-primary show_modal" data-placement="top" title="Upload Ulang"><i class="fas fa-upload"></i></a>
    							
    							</td>
							</tr>
							
							<tr>
								<td class="text-center align-middle">3</td>
								<th class="align-middle">
									Surat Keterangan Bebas Plagiasi</strong> 
								</th>
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
								<td class="align-middle">
								    <input type="text" id="catatan_plagiasi" name="catatan_plagiasi" onfocusout="simpan_catatan('catatan_plagiasi','<?=$id;?>')" class="form-control" value="<?=$catatan_plagiasi;?>" />
								</td>
								<td class="text-center align-middle">
    								    
    								<a href="<?=base_url("tugasakhir/$controller/uploadUlang?id=").$id."&field=plagiasi"?>" judul_modal="Upload Surat Keterangan Bebas Plagiasi" class="btn btn-xs btn-primary show_modal" data-placement="top" title="Upload Ulang"><i class="fas fa-upload"></i></a>
    							
    							</td>
							</tr>
                                
							<tr>
								<td class="text-center align-middle">4</td>
								<th class="align-middle">File Proposal</th>
								<td class="text-center align-middle">
									<a id="btn_v_proposal" onclick="lihat('<?=str_replace( 'http://', 'https://',$proposal)?>')" class="btn btn-xs" data-placement="top" title="Lihat"><i class="fas fa-lg"></i></a>
								
								</td>
								<td class="align-middle">
								    <select onchange="validasi('v_proposal')" id="v_proposal" class="form-control select2" style="width: 100%;" data-placeholder="Klik Pilihan...">
										<option value="0" <?php if($v_proposal=="0") {echo "selected";} ?>> --- Pilih Opsi --- </option>
										<option value="2" <?php if($v_proposal=="2") {echo "selected";} ?>>Tidak Diterima</option>
										<option value="1" <?php if($v_proposal=="1") {echo "selected";} ?>>Diterima</option>
											
									</select> 
								</td>
								<td class="align-middle">
								    <input type="text" id="catatan_proposal" name="catatan_proposal" onfocusout="simpan_catatan('catatan_proposal','<?=$id;?>')" class="form-control" value="<?=$catatan_proposal;?>" />
								</td>
								<td class="text-center align-middle">
    								    
    								<a href="<?=base_url("tugasakhir/$controller/uploadUlang?id=").$id."&field=proposal"?>" judul_modal="Upload File Proposal" class="btn btn-xs btn-primary show_modal" data-placement="top" title="Upload Ulang"><i class="fas fa-upload"></i></a>
    							
    							</td>
							</tr>
    
    						
    	                </tbody>
                    </table>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="proposal">
                    <div class="row">
                        <div class="col-12">
                            <h4><strong>Judul</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=strip_tags($judul)?>
                              </p>
                              
                              <p>
                                <a onclick="komentar('<?=$id?>','1','judul','Judul')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 1</a>
                                <a onclick="komentar('<?=$id?>','2','judul','Judul')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 2</a>
                                
                              </p>
                              
                              <?php $komen1 = getDataRow('hasil_sempro', ['id_sempro' => $id, 'penguji' => '1']);
                                    $komen2 = getDataRow('hasil_sempro', ['id_sempro' => $id, 'penguji' => '2']);
                                    if(!empty($komen1['judul']) || !empty($komen2['judul'])){
                              ?>
        
                                <div class="col-12" id="komen_judul">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['judul'])){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['judul']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['judul'])){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['judul']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php }else{ ?>
                                <div class="col-12" id="komen_judul">
                                </div>
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Latar Belakang / Konteks Penelitian</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$latar_konteks?>
                              </p>
                              <p>
                                <a onclick="komentar('<?=$id?>','1','latar_konteks','Latar belakang / Konteks penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 1</a>
                                <a onclick="komentar('<?=$id?>','2','latar_konteks','Latar belakang / Konteks penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 2</a>
                                
                              </p>
                              <?php 
                                    if(!empty($komen1['latar_konteks']) || !empty($komen2['latar_konteks'])){
                              ?>
        
                                <div class="col-12" id="komen_latar_konteks">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['latar_konteks'])){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['latar_konteks']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['latar_konteks'])){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['latar_konteks']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php }else{ ?>
                                <div class="col-12" id="komen_latar_konteks">
                                </div>
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Rumusan Masalah / Fokus Penelitian</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$rumusan?>
                              </p>
                              
                              <p>
                                <a onclick="komentar('<?=$id?>','1','rumusan','Rumusan masalah / Fokus penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 1</a>
                                <a onclick="komentar('<?=$id?>','2','rumusan','Rumusan masalah / Fokus penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 2</a>
                                
                              </p>
                              
                              <?php 
                                    if(!empty($komen1['rumusan']) || !empty($komen2['rumusan'])){
                              ?>
        
                                <div class="col-12" id="komen_rumusan">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['rumusan'])){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['rumusan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['rumusan'])){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['rumusan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php }else{ ?>
                                <div class="col-12" id="komen_rumusan">
                                </div>
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Tujuan Penelitian</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$tujuan?>
                              </p>
                              
                              <p>
                                <a onclick="komentar('<?=$id?>','1','tujuan','Tujuan penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 1</a>
                                <a onclick="komentar('<?=$id?>','2','tujuan','Tujuan penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 2</a>
                                
                              </p>
                              <?php 
                                    if(!empty($komen1['tujuan']) || !empty($komen2['tujuan'])){
                              ?>
        
                                <div class="col-12"  id="komen_tujuan">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['tujuan'])){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['tujuan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['tujuan'])){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['tujuan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php }else{ ?>
                                <div class="col-12" id="komen_tujuan">
                                </div>
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Metode Penelitian</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$metode_penelitian?>
                              </p>
                              
                              <p>
                                <a onclick="komentar('<?=$id?>','1','metode_penelitian','Metode penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 1</a>
                                <a onclick="komentar('<?=$id?>','2','metode_penelitian','Metode penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 2</a>
                                
                              </p>
                              <?php 
                                    if(!empty($komen1['metode_penelitian']) || !empty($komen2['metode_penelitian'])){
                              ?>
        
                                <div class="col-12" id="komen_metode_penelitian">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['metode_penelitian'])){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['metode_penelitian']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['metode_penelitian'])){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['metode_penelitian']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php }else{ ?>
                                <div class="col-12" id="komen_metode_penelitian">
                                </div>
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Konsep atau Teori</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$konsep_teori?>
                              </p>
                              
                              <p>
                                <a onclick="komentar('<?=$id?>','1','konsep_teori','Konsep / Teori yang relevan')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 1</a>
                                <a onclick="komentar('<?=$id?>','2','konsep_teori','Konsep / Teori yang relevan')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 2</a>
                                
                              </p>
                              <?php 
                                    if(!empty($komen1['konsep_teori']) || !empty($komen2['konsep_teori'])){
                              ?>
        
                                <div class="col-12" id="komen_konsep_teori">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['konsep_teori'])){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['konsep_teori']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['konsep_teori'])){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['konsep_teori']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php }else{ ?>
                                <div class="col-12" id="komen_konsep_teori">
                                </div>
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Penelitian Terdahulu</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$kajian_terdahulu?>
                              </p>
                              
                              <p>
                                <a onclick="komentar('<?=$id?>','1','kajian_terdahulu','Review penelitian terdahulu')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 1</a>
                                <a onclick="komentar('<?=$id?>','2','kajian_terdahulu','Review penelitian terdahulu')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 2</a>
                                
                              </p>
                              <?php 
                                    if(!empty($komen1['kajian_terdahulu']) || !empty($komen2['kajian_terdahulu'])){
                              ?>
        
                                <div class="col-12" id="komen_kajian_terdahulu">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['kajian_terdahulu'])){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['kajian_terdahulu']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['kajian_terdahulu'])){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['kajian_terdahulu']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php }else{ ?>
                                <div class="col-12" id="komen_kajian_terdahulu">
                                </div>
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Rencana Pembahasan</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$rencana_pembahasan?>
                              </p>
                              <p>
                                <a onclick="komentar('<?=$id?>','1','rencana_pembahasan','Sistematika pembahasan')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 1</a>
                                <a onclick="komentar('<?=$id?>','2','rencana_pembahasan','Sistematika pembahasan')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 2</a>
                                
                              </p>
                              <?php 
                                    if(!empty($komen1['rencana_pembahasan']) || !empty($komen2['rencana_pembahasan'])){
                              ?>
        
                                <div class="col-12" id="komen_rencana_pembahasan">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['rencana_pembahasan'])){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['rencana_pembahasan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['rencana_pembahasan'])){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['rencana_pembahasan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php }else{ ?>
                                <div class="col-12" id="komen_rencana_pembahasan">
                                </div>
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Daftar Pustaka</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$daftar_pustaka?>
                              </p>
                              <p>
                                <a onclick="komentar('<?=$id?>','1','daftar_pustaka','Daftar pustaka')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 1</a>
                                <a onclick="komentar('<?=$id?>','2','daftar_pustaka','Daftar pustaka')" role="button" class="btn btn-sm btn-primary text-sm">Penguji 2</a>
                                
                              </p>
                              <?php 
                                    if(!empty($komen1['daftar_pustaka']) || !empty($komen2['daftar_pustaka'])){
                              ?>
        
                                <div class="col-12" id="komen_daftar_pustaka">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['daftar_pustaka'])){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['daftar_pustaka']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['daftar_pustaka'])){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['daftar_pustaka']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php }else{ ?>
                                <div class="col-12" id="komen_daftar_pustaka">
                                </div>
                              <?php } ?>
                            </div>
                        </div>
                    </div>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane" id="jadwal">
                    <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:25%" class="align-middle">Status</th>
                            <td>
                                <?php
                                    echo cmb_dinamis('status', 'ref_option', 'opt_val', 'opt_id', $status, null, 'id="status"  style="width: 100%;" onchange="simpan_catatan('."'status','".$id."'".')"', null, null, ['opt_group' => 'status_proposal', 'is_aktif !=' => 'N']);
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Catatan</th>
                            <td>
                                <input type="text" id="catatan_verifikator" name="catatan_verifikator" onfocusout="simpan_catatan('catatan_verifikator','<?=$id;?>')" class="form-control" value="<?=$catatan_verifikator;?>" />
                            </td>
                          </tr>
                          
                          <tr>
                            <th class="align-middle">Tgl. Seminar</th>
                            <td>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="tgl_seminar" data-toggle="datetimepicker" name="tgl_seminar"
                                        data-target="#reservationdate" placeholder="YYYY-MM-DD" value="<?=$tgl_seminar;?>" onfocusout="simpan_catatan('tgl_seminar','<?=$id;?>')"/>
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
                                    $penguji1 = (!empty(getDataRow('penguji_sempro', ['id_sempro' => $id, 'tugas' => 1])))?getDataRow('penguji_sempro', ['id_sempro' => $id, 'tugas' => 1])['kd_dosen']:NULL;
                                    echo cmb_dinamis('penguji_1', 'data_dosen', 'Nama_Dosen', 'Kode', $penguji1, null, 'id="penguji_1"  style="width: 100%;" onchange="simpan_penguji('."'1','".$id."'".')"');
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Penguji 2</th>
                            <td>
                                <?php
                                    $penguji2 = (!empty(getDataRow('penguji_sempro', ['id_sempro' => $id, 'tugas' => 2])))?getDataRow('penguji_sempro', ['id_sempro' => $id, 'tugas' => 2])['kd_dosen']:NULL;
                                    echo cmb_dinamis('penguji_2', 'data_dosen', 'Nama_Dosen', 'Kode', $penguji2, null, 'id="penguji_2"  style="width: 100%;" onchange="simpan_penguji('."'2','".$id."'".')"');
                                ?>
                            </td>
                          </tr>
                        </table>
                    </div>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="hasil_seminar">
                    <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:25%" class="align-middle">Rekomendasi</th>
                            <td>
                                <?php
                                    if(!empty($komen1['rekom']) && !empty($komen2['rekom'])){
                                        if($komen1['rekom']==1 || $komen2['rekom']==1){
                                            echo "<span class='badge badge-success'>Ditolak</span>";
                                        }elseif($komen1['rekom']==2 || $komen2['rekom']==2){
                                            echo "<span class='badge badge-success'>Lulus Dengan Revisi</span>";
                                        }elseif($komen1['rekom']==3 || $komen2['rekom']==3){
                                            echo "<span class='badge badge-danger'>Lulus Tanpa Revisi</span>";
                                        }
                                    }
                                    
                                    if(empty($komen1['rekom'])){
                                        echo "<span class='badge badge-danger'>Penguji 1 belum memberikan rekomendasi</span>";
                                    }
                                    if(empty($komen2['rekom'])){
                                        echo "<span class='badge badge-danger'>Penguji 2 belum memberikan rekomendasi</span>";
                                    }
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Nilai</th>
                            <td>
                                <?php
                                    if(!empty($komen1['nilai']) && !empty($komen2['nilai'])){
                                        $nilai = number_format(($komen1['nilai']+$komen2['nilai'])/2,2);
                                		$grade_nilai=  dataDinamis('grade_nilai');
                                		foreach ($grade_nilai as $s)
                                        {
                                            if($nilai >=$s->batas_bawah and $nilai <= $s->batas_atas)
                                            {
                                                $predikat= $s->grade;
                                            }
                                        }
                                        
                                        echo $nilai." (".$predikat.")";
                                    }
                                    
                                    if(empty($komen1['nilai'])){
                                        echo "<span class='badge badge-danger'>Penguji 1 belum memberikan nilai</span>";
                                    }
                                    if(empty($komen2['nilai'])){
                                        echo "<span class='badge badge-danger'>Penguji 2 belum memberikan nilai</span>";
                                    }
                                ?>
                            </td>
                          </tr>
                          
                          <tr>
                            <th class="align-middle"></th>
                            <td>
                                <?php if(!empty($komen1['rekom']) && !empty($komen2['rekom']) && !empty($komen1['nilai']) && !empty($komen2['nilai'])){?>
                                <button onclick="window.open('<?=base_url();?>/tugasakhir/<?=$controller;?>/cetak_hasil_seminar?id=<?=$id;?>', '', 'width=800, height=600, status=1,scrollbar=yes'); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-print"></i>
            						Download Hasil Seminar
            					</button>        
                                <?php    }else{ ?>
                                 <button onclick="input_nilai('<?=$id?>')" class="btn btn-sm btn-primary">
            						<i class="fa fa-edit"></i>
            						Input Nilai
            					</button>  
            					<?php } ?>
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
                            <th style="width:25%" class="align-middle">Revisi Proposal</th>
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
        var id = "<?=$id;?>";
        var status = "<?=$status;?>";
        var link_revisi = "<?=$revisi;?>";
        var link_pengesahan = "<?=$pengesahan_revisi;?>";
		getValidasi('v_kwitansi', id);
		getValidasi('v_rekom', id);
		getValidasi('v_proposal', id);
		getValidasi('v_plagiasi', id);
		
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
	var id="<?=$id;?>";
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
                /*
                if(data.nilai==0 || data.nilai==''){
                    $("#btn_"+data.field).attr('class',"btn btn-xs btn-warning");
                    $("#btn_"+data.field).find("i").attr('class',"fas fa-check fa-lg text-green");
                }else if(data.nilai==2){
                    $("#btn_"+data.field).attr('class',"btn btn-xs btn-danger");
                    $("#btn_"+data.field).find("i").attr('class',"fas fa-times fa-lg");
                }else{
                    $("#btn_"+data.field).attr('class',"btn btn-xs btn-success");
                    $("#btn_"+data.field).find("i").attr('class',"fas fa-check fa-lg");
                };
                */
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
function simpan_penguji(tugas,id_sempro) {
	
	var dosen_penguji=$("#penguji_"+tugas).val();
	$.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/simpan_penguji");?>",
		data:"id_sempro="+id_sempro+"&kd_dosen="+dosen_penguji+"&tugas="+tugas,
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
    var link = "<?=base_url()?>"+"/tugasakhir/proposal/komentar?id="+id+"&tugas="+tugas+"&field="+field+"&konten="+konten;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
   
    $.buatModal({
      title:'Komentar '+konten,
      message: iframe,
      closeButton:true,
      reload:true,
      id_sempro:id,
      penguji:tugas,
      kolom:field,
      //confirmButton:true,
      scrollable:false
    });
    return false;
}

function input_nilai(id){
    var link = "<?=base_url()?>"+"/tugasakhir/proposal/input_nilai?id="+id;
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

function getKomen(id_sempro, penguji, field){
    $.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/getKomen");?>",
		data:{id_sempro:id_sempro, penguji:penguji, field:field},
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


(function(a){
    a.buatModal=function(b){
      defaults={
        title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false
      };
      var b=a.extend({},defaults,b);
      var c=(b.scrollable===true)?'style=" overflow-y: auto;"':"";
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
            getKomen(b.id_sempro,b.penguji,b.kolom);
        }
        
        if(b.reload_page===true){
            location.reload();
        }
        
        
      })}})(jQuery);
        
$(function(){    
  $('.show_modal').on('click',function(){
    var link = $(this).attr('href');      
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:50vh;">No Support</object>';
    //var tabel = $(this).attr('tabel');
    var titel =  $(this).attr('judul_modal');
    $.buatModal({
      title:titel,
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_transaksi,
      //status_transaksi: status_transaksi,
      closeButton:false,
      reload_page:true,
      //tabel:tabel,
      scrollable:false
    });
    return false;        
  });    
  
});

</script>
<?=$this->endSection();?>