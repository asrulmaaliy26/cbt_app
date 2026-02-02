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
              <li class="nav-item"><a class="nav-link active" href="#proposal" data-toggle="tab">Review Proposal</a></li>
              <li class="nav-item"><a class="nav-link" href="#full_proposal"  data-toggle="tab">Proposal (PDF)</a></li>
              <li class="nav-item"><a class="nav-link" href="#hasil_seminar"  data-toggle="tab">Penilaian & Rekomendasi</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              
              <div class="active tab-pane" id="proposal">
                    <div class="row">
                        <div class="col-12">
                            <h4><strong>Judul</strong></h4>
                            <div class="post clearfix">
                              
                              <p>
                                <?=strip_tags($judul)?>
                              </p>
                              
                              <p>
                                <a onclick="komentar('<?=$id?>','<?=$penguji?>','judul','Judul')" role="button" class="btn btn-sm btn-primary text-sm">Input Komentar</a>
                                
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
                                <a onclick="komentar('<?=$id?>','<?=$penguji?>','latar_konteks','Latar belakang / Konteks penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Input Komentar</a>
                                
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
                                <a onclick="komentar('<?=$id?>','<?=$penguji?>','rumusan','Rumusan masalah / Fokus penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Input Komentar</a>
                                
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
                                <a onclick="komentar('<?=$id?>','<?=$penguji?>','tujuan','Tujuan penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Input Komentar</a>
                                
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
                                <a onclick="komentar('<?=$id?>','<?=$penguji?>','metode_penelitian','Metode penelitian')" role="button" class="btn btn-sm btn-primary text-sm">Input Komentar</a>
                                
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
                                <a onclick="komentar('<?=$id?>','<?=$penguji?>','konsep_teori','Konsep / Teori yang relevan')" role="button" class="btn btn-sm btn-primary text-sm">Input Komentar</a>
                                
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
                                <a onclick="komentar('<?=$id?>','<?=$penguji?>','kajian_terdahulu','Review penelitian terdahulu')" role="button" class="btn btn-sm btn-primary text-sm">Input Komentar</a>
                                
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
                                <a onclick="komentar('<?=$id?>','<?=$penguji?>','rencana_pembahasan','Sistematika pembahasan')" role="button" class="btn btn-sm btn-primary text-sm">Input Komentar</a>
                                
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
                                <a onclick="komentar('<?=$id?>','<?=$penguji?>','daftar_pustaka','Daftar pustaka')" role="button" class="btn btn-sm btn-primary text-sm">Input Komentar</a>
                                
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
              
              <div class="tab-pane" id="full_proposal">
                    <iframe src="<?=str_replace( 'http://', 'https://',$proposal);?>" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;" style="width: 100%; height: 1000px;" frameborder="0">
                        
                    </iframe>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="hasil_seminar">
                    <div class="table-responsive">
                        <table class="table">
                          <tr>
                            <th style="width:25%" class="align-middle">Rekomendasi</th>
                            <td>
                                <select name="rekom" id="rekom" onchange="simpan('<?=$id?>','rekom','<?=$penguji?>')" class="form-control select2">
                                    <option value="">  </option>
        							<option value="1" <?=(isset($hasil) && $hasil['rekom']=='1')?'selected':''?> >Ditolak</option>
    								<option value="2" <?=(isset($hasil) && $hasil['rekom']=='2')?'selected':''?> >Lulus Dengan Revisi</option>
    								<option value="3" <?=(isset($hasil) && $hasil['rekom']=='3')?'selected':''?> >Lulus Tanpa Revisi</option>	
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <th class="align-middle">Nilai</th>
                            <td>
                                <input type="number"  step=".01" min="3.10" max="4.00" name="nilai" id="nilai" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','nilai','<?=$penguji?>')" value="<?=(isset($hasil))?number_format($hasil['nilai'],2):''?>"/>
                            </td>
                          </tr>
                          
                          <tr>
                              <th >Referensi Nilai</th>
                              <td >
                                    <div class="table-responsive-sm">
                                        <table class="table table-sm">
                                          <tr>
                                            
                                            <th style="width:35%">Nilai Angka</th>
                                            <th style="width:35%">Nilai Huruf</th>
                                          </tr>
                                          <?php $ref_nilai = dataDinamis('grade_nilai', null, 'batas_bawah DESC');
                                                foreach ($ref_nilai as $r){
                                          ?>
                                          <tr>
                                              <td><?=$r->batas_bawah?> s/d <?=$r->batas_atas?></td>
                                              <td><?=$r->grade?></td>
                                          </tr>
                                          <?php } ?>
                                        </table>
                                    </div>
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
    
})


function simpan(id_sempro, field, penguji) {

    let val = $("#"+field).val();
	$.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/input_nilai");?>",
		data:"id_sempro="+id_sempro+"&penguji="+penguji+"&field="+field+"&val="+val,
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
        error: function(xhr, ajaxOptions, thrownError)
        {
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