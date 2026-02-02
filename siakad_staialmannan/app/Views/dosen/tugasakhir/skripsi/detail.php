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
              
              <li class="nav-item"><a class="nav-link active" href="#judul_abs" data-toggle="tab">Judul, Abstrak & Kesimpulan</a></li>
              <li class="nav-item"><a class="nav-link" href="#skripsi"  data-toggle="tab">Review Skripsi</a></li>
              <li class="nav-item"><a class="nav-link" href="#hasil"  data-toggle="tab">Penilaian</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              
              <div class="active tab-pane" id="judul_abs">
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
    		                    <th class="text-center align-middle">Review Penguji</th>
    		                    <th class="text-center align-middle">Aksi</th>
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
    							
    							
    							<td>
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
    							    <a onclick="komentar('<?=$id_munaqasyah?>','<?=$penguji?>','bag_depan','Halaman Depan (Cover, Motto, Daftar isi, dll.)')" role="button" class="btn btn-info btn-sm">Review</a>
    							</td>
    						</tr>
    						
    						<tr>
								<th >
									BAB I
								</th>
								
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
    							    <a onclick="komentar('<?=$id_munaqasyah?>','<?=$penguji?>','bab1','BAB I')" role="button" class="btn btn-info btn-sm">Review</a>
    							</td>
							</tr>
							
							<tr>
							    <th >
									BAB II
								</th>
								
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
    							    <a onclick="komentar('<?=$id_munaqasyah?>','<?=$penguji?>','bab2','BAB II')" role="button" class="btn btn-info btn-sm">Review</a>
    							</td>
							</tr>
                                
							<tr>
								<th >BAB III</th>
								
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
    							    <a onclick="komentar('<?=$id_munaqasyah?>','<?=$penguji?>','bab3','BAB III')" role="button" class="btn btn-info btn-sm">Review</a>
    							</td>
							</tr>
							<tr>
								<th >BAB IV</th>
								
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
    							    <a onclick="komentar('<?=$id_munaqasyah?>','<?=$penguji?>','bab4','BAB IV')" role="button" class="btn btn-info btn-sm">Review</a>
    							</td>
							</tr>
							<tr>
								<th >BAB V</th>
								
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
    							    <a onclick="komentar('<?=$id_munaqasyah?>','<?=$penguji?>','bab5','BAB V')" role="button" class="btn btn-info btn-sm">Review</a>
    							</td>
							</tr>
							<?php if(!empty($bab6)){ ?>
							<tr>
								<th >BAB VI (Jika Ada)</th>
								
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
    							    <a onclick="komentar('<?=$id_munaqasyah?>','<?=$penguji?>','bab6','BAB VI')" role="button" class="btn btn-info btn-sm">Review</a>
    							</td>
							</tr>
							<?php } ?>
							<tr>
								<th >Daftar Pustaka</th>
								
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
    							    <a onclick="komentar('<?=$id_munaqasyah?>','<?=$penguji?>','pustaka','Daftar Pustaka')" role="button" class="btn btn-info btn-sm">Review</a>
    							</td>
							</tr>
							<?php if(!empty($lampiran)){ ?>
							<tr>
								<th >Lampiran-lampiran (Jika Ada)</th>
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
    							    <a onclick="komentar('<?=$id_munaqasyah?>','<?=$penguji?>','lampiran','Lampiran-lampiran')" role="button" class="btn btn-info btn-sm">Review</a>
    							</td>
							</tr>
							<?php } ?>
    	                </tbody>
                    </table>
                    </div>
              </div>
              <!-- /.tab-pane -->
              
              <div class="tab-pane" id="hasil">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="text-align:center;" width="5%">No.</th>
                                    <th style="text-align:center;" width="25%">Unsur Penilaian</th>
                                    <th style="text-align:center;" width="15%">Interval Skor</th>
                                    <th style="text-align:center;">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                        			<td style="text-align:center;">1</td>
                        			<td >Penyampaian</td>
                        			<td style="text-align:center;">1 - 10</td>
                        			<td style="text-align:center;">
                        			    <input type="number" <?=$penguji==3?'disabled':'';?> step="1" min="1" max="10" name="penyampaian" id="penyampaian" class="form-control form-control-sm" onfocusout="simpan('<?=$id_munaqasyah?>','penyampaian','<?=$penguji?>')" value="<?=(isset($hasil))?number_format($hasil['penyampaian']):''?>"/>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td style="text-align:center;">2</td>
                        			<td >Teknik Penulisan</td>
                        			<td style="text-align:center;">1 - 25</td>
                        			<td style="text-align:center;">
                        			    <input type="number" <?=$penguji==3?'disabled':'';?> step="1" min="1" max="25" name="penulisan" id="penulisan" class="form-control form-control-sm" onfocusout="simpan('<?=$id_munaqasyah?>','penulisan','<?=$penguji?>')" value="<?=(isset($hasil))?number_format($hasil['penulisan']):''?>"/>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td style="text-align:center;">3</td>
                        			<td >Ketepatan Metode</td>
                        			<td style="text-align:center;">1 - 25</td>
                        			<td style="text-align:center;">
                        			    <input type="number" <?=$penguji==3?'disabled':'';?> step="1" min="1" max="25" name="metode" id="metode" class="form-control form-control-sm" onfocusout="simpan('<?=$id_munaqasyah?>','metode','<?=$penguji?>')" value="<?=(isset($hasil))?number_format($hasil['metode']):''?>"/>
                        			</td>
                        		</tr>
                        		<tr>
                        			<td style="text-align:center;">4</td>
                        			<td >Konten</td>
                        			<td style="text-align:center;">1 - 40</td>
                        			<td style="text-align:center;">
                        			    <input type="number" <?=$penguji==3?'disabled':'';?> step="1" min="1" max="40" name="konten" id="konten" class="form-control form-control-sm" onfocusout="simpan('<?=$id_munaqasyah?>','konten','<?=$penguji?>')" value="<?=(isset($hasil))?number_format($hasil['konten']):''?>"/>
                        			</td>
                        		</tr>
                            </tbody>
                            <tfoot>
                                <th colspan="3" class="text-center"> TOTAL</th>
                                <th><span id=nilai_total></span></th>
                            </tfoot>
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
    total();
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
    
})


function reload_table(){
    table.ajax.reload(null, false);
}

function simpan(id_munaqasyah, field, penguji) {

    var val = $("#"+field).val();
	$.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/input_nilai");?>",
		data:"id_munaqasyah="+id_munaqasyah+"&penguji="+penguji+"&field="+field+"&val="+val,
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
		        total();
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
                
		    }else if (data.msg == 'warning'){
                Swal.fire({
                    icon: data.msg,
                    title: data.pesan,
                    html: 'Gagal menyimpan nilai: <pre><code>' +
								          JSON.stringify(data.validation)+
								        '</code></pre>',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
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
            //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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
    return true;
}

function total(){
    var penyampaian = $('#penyampaian').val();
    var penulisan = $('#penulisan').val();
    var metode = $('#metode').val();
    var konten = $('#konten').val();
    var result = parseFloat(penyampaian) + parseFloat(penulisan) + parseFloat(metode) + parseFloat(konten);
    
    if (!isNaN(result)) {
        $.ajax({
           
            url:"<?php echo site_url("admin/globalController/grade_nilai");?>",
			data:"nilai="+result,
			type: "post",
			dataType: 'json',
			success: function(data)
			{
		            $('#nilai_total').text(result+" ("+data.predikat+")");
			}
		});
        return true;
        
    }
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