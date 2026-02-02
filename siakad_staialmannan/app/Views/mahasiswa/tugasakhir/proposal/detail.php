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
    							<td class="text-center align-middle">
    							   
    								<?=($v_kwitansi == 0)?"<span class='badge badge-info'>Belum Dikoreksi</span>":(($v_kwitansi == 2) ? "<span class='badge badge-danger'>Tidak Ditermia</span>":"<span class='badge badge-success'>Diterima</span>")?>
    							</td>
    							<td class="align-middle">
    							    <?=$catatan_kwitansi?>
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
								<td class="text-center align-middle">
								    <?=($v_rekom == 0)?"<span class='badge badge-info'>Belum Dikoreksi</span>":(($v_rekom == 2) ? "<span class='badge badge-danger'>Tidak Ditermia</span>":"<span class='badge badge-success'>Diterima</span>")?>
    							</td>
								</td>
								<td class="align-middle">
								    <?=$catatan_rekom;?>
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
								<td class="text-center align-middle">
								    <?=($v_plagiasi == 0)?"<span class='badge badge-info'>Belum Dikoreksi</span>":(($v_plagiasi == 2) ? "<span class='badge badge-danger'>Tidak Ditermia</span>":"<span class='badge badge-success'>Diterima</span>")?>
    							</td>
								</td>
								<td class="align-middle">
								    <?=$catatan_plagiasi;?>
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
								<td class="text-center align-middle">
								    <?=($v_proposal == 0)?"<span class='badge badge-info'>Belum Dikoreksi</span>":(($v_proposal == 2) ? "<span class='badge badge-danger'>Tidak Ditermia</span>":"<span class='badge badge-success'>Diterima</span>")?>
								</td>
								<td class="align-middle">
								    <?=$catatan_proposal;?>
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
                              
                              <?php $komen1 = getDataRow('hasil_sempro', ['id_sempro' => $id, 'penguji' => '1']);
                                    $komen2 = getDataRow('hasil_sempro', ['id_sempro' => $id, 'penguji' => '2']);
                                    if(!empty($komen1['judul']) || !empty($komen2['judul'])){
                              ?>
        
                                <div class="col-12">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['judul'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['judul']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['judul'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['judul']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Latar Belakang / Konteks Penelitian</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$latar_konteks?>
                              </p>
                              
                              <?php 
                                    if(!empty($komen1['latar_konteks']) || !empty($komen2['latar_konteks'])){
                              ?>
        
                                <div class="col-12">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['latar_konteks'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['latar_konteks']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['latar_konteks'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['latar_konteks']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Rumusan Masalah / Fokus Penelitian</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$rumusan?>
                              </p>
                              <?php 
                                    if(!empty($komen1['rumusan']) || !empty($komen2['rumusan'])){
                              ?>
        
                                <div class="col-12">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['rumusan'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['rumusan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['rumusan'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['rumusan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Tujuan Penelitian</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$tujuan?>
                              </p>
                              <?php 
                                    if(!empty($komen1['tujuan']) || !empty($komen2['tujuan'])){
                              ?>
        
                                <div class="col-12">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['tujuan'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['tujuan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['tujuan'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['tujuan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Metode Penelitian</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$metode_penelitian?>
                              </p>
                              <?php 
                                    if(!empty($komen1['metode_penelitian']) || !empty($komen2['metode_penelitian'])){
                              ?>
        
                                <div class="col-12">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['metode_penelitian'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['metode_penelitian']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['metode_penelitian'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['metode_penelitian']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Konsep atau Teori</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$konsep_teori?>
                              </p>
                              <?php 
                                    if(!empty($komen1['konsep_teori']) || !empty($komen2['konsep_teori'])){
                              ?>
        
                                <div class="col-12">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['konsep_teori'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['konsep_teori']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['konsep_teori'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['konsep_teori']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Penelitian Terdahulu</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$kajian_terdahulu?>
                              </p>
                              <?php 
                                    if(!empty($komen1['kajian_terdahulu']) || !empty($komen2['kajian_terdahulu'])){
                              ?>
        
                                <div class="col-12">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['kajian_terdahulu'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['kajian_terdahulu']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['kajian_terdahulu'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['kajian_terdahulu']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Rencana Pembahasan</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$rencana_pembahasan?>
                              </p>
                              <?php 
                                    if(!empty($komen1['rencana_pembahasan']) || !empty($komen2['rencana_pembahasan'])){
                              ?>
        
                                <div class="col-12">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['rencana_pembahasan'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['rencana_pembahasan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['rencana_pembahasan'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['rencana_pembahasan']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
                                </div>
                              
                              <?php } ?>
                            </div>
                            
                            <h4><strong>Daftar Pustaka</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=$daftar_pustaka?>
                              </p>
                              <?php 
                                    if(!empty($komen1['daftar_pustaka']) || !empty($komen2['daftar_pustaka'])){
                              ?>
        
                                <div class="col-12">
                                  <div class="info-box bg-light">
                                    <div class="info-box-content">
                                      <?php if(!empty($komen1['daftar_pustaka'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 1</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen1['daftar_pustaka']?>
                                          
                                      </div>    
                                      <?php } ?>
                                      
                                      <?php if(!empty($komen2['daftar_pustaka'])  && $status > 4){?>
                                      <b class="d-block">Komentar Penguji 2</b>
                                      <div class="post clearfix">
                                          
                                            <?=$komen2['daftar_pustaka']?>
                                          
                                      </div>    
                                      <?php } ?>
                                    </div>
                                  </div>
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
                                
                                <?=getDataRow('ref_option', ['opt_group' => 'status_proposal', 'opt_id' => $status])['opt_val']?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Catatan</th>
                            <td>
                                <?=$catatan_verifikator;?>
                            </td>
                          </tr>
                          
                          <tr>
                            <th class="align-middle">Tgl. Seminar</th>
                            <td>
                                <?=(!empty($tgl_seminar))?short_tgl_indonesia_date($tgl_seminar):'';?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Penguji 1</th>
                            <td>
                                <?=
                                    (!empty(getDataRow('penguji_sempro', ['id_sempro' => $id, 'tugas' => 1])['kd_dosen']))?getDataRow('data_dosen', ['Kode' => getDataRow('penguji_sempro', ['id_sempro' => $id, 'tugas' => 1])['kd_dosen']])['Nama_Dosen']:'';
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Penguji 2</th>
                            <td>
                                <?=
                                    (!empty(getDataRow('penguji_sempro', ['id_sempro' => $id, 'tugas' => 2])['kd_dosen']))?getDataRow('data_dosen', ['Kode' => getDataRow('penguji_sempro', ['id_sempro' => $id, 'tugas' => 2])['kd_dosen']])['Nama_Dosen']:'';
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
                                <?php    } ?>
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
                                <a href="javascript:void(0)" onclick="unggah('revisi','<?=$id?>','Revisi Proposal'); return false;" class="btn btn-sm btn-primary"><b>Upload</b></a>
                            </td>
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
                                <a href="javascript:void(0)" onclick="unggah('pengesahan_revisi','<?=$id?>','Pengesahan Revisi Proposal'); return false;" class="btn btn-sm btn-primary"><b>Upload</b></a>
                            </td>
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
                            <input type="text" class="form-control"  id="id_sempro" name="id_sempro" />
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
    $('#uploadModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.invalid-feedback').text('');
        $(this).find('li').remove();
        $(this).find('#card_validasi_berkas').attr('hidden', true);
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

function unggah(field, id_sempro, nm_berkas) {
    //let berkas = field.replace("_", " ").toUpperCase();
    $('#uploadModal').on('show.bs.modal', function () {
        var modal = $(this)
        $(this).find('#uploadModalLabel').text("Upload "+nm_berkas);
        $(this).find('#jenis_berkas').val(field);
        $(this).find('#id_sempro').val(id_sempro);
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
                url: "<?php echo site_url("tugasakhir/$controller/");?>"+"/upload_berkas_revisi",
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
                            location.reload();
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