<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
			                        <td><?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'];?></td>
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
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    Persyaratan Pengambilan Ijazah
                </h3>
                <div class="card-tools">
                    <!--
                        <a role="button" class="btn btn-success btn-xs" title="Tambah" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">
                            <i class="fa fa-plus"></i> Tambah MK
                        </a>
                    -->
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                
                                <th class="text-center">No</th>
                                <th class="text-center">Persyaratan</th>
                                <th class="text-center">Petugas</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
            					<td class="text-center">1</td>
            					<td>Melunasi biaya perkuliahan</td>
            					
            					<td class="text-center">BAK</td>
            					<td class="text-center"><?=(!isset($ijazah['biaya_kuliah']) || $ijazah['biaya_kuliah']==0)?"<span class='badge badge-danger'><i class='fa fa-times'></i></span>":"<span class='badge badge-success'><i class='fa fa-check'></i></span>";?></td>
            					
            				</tr>
            				<tr>
            					<td class="text-center">2</td>
            					<td>Melunasi biaya wisuda</td>
            					
            					<td class="text-center">BAK</td>
            					<td class="text-center"><?=(!isset($ijazah['biaya_wisuda']) || $ijazah['biaya_wisuda']==0)?"<span class='badge badge-danger'><i class='fa fa-times'></i></span>":"<span class='badge badge-success'><i class='fa fa-check'></i></span>";?></td>
            					
            				</tr>
            				<tr>
            					<td class="text-center">3</td>
            					<td>Melunasi biaya pengurusan ijazah</td>
            					
            					<td class="text-center">BAK</td>
            					<td class="text-center"><?=(!isset($ijazah['biaya_pengurusan_ijazah']) || $ijazah['biaya_pengurusan_ijazah']==0)?"<span class='badge badge-danger'><i class='fa fa-times'></i></span>":"<span class='badge badge-success'><i class='fa fa-check'></i></span>";?></td>
            					
            				</tr>
            				<tr>
            					<td class="text-center">4</td>
            					<td>Wakaf buku</td>
            					
            					<td class="text-center">BAK</td>
            					<td class="text-center"><?=(!isset($ijazah['waqaf_buku']) || $ijazah['waqaf_buku']==0)?"<span class='badge badge-danger'><i class='fa fa-times'></i></span>":"<span class='badge badge-success'><i class='fa fa-check'></i></span>";?></td>
            					
            				</tr>
            				<tr>
            					<td class="text-center">5</td>
            					<td>Menyerahkan revisi skripsi yang telah disahkan kaprodi (Hardcopy) dan mengirimkan softfile ke E-mail Prodi</td>
            					
            					<td class="text-center">Kaprodi</td>
            					<td class="text-center"><?=(!isset($ijazah['revisi_skripsi']) || $ijazah['revisi_skripsi']==0)?"<span class='badge badge-danger'><i class='fa fa-times'></i></span>":"<span class='badge badge-success'><i class='fa fa-check'></i></span>";?></td>
            					
            				</tr>
            				
            				<tr>
            					<td class="text-center">6</td>
            					<td>Bebas tanggungan perpustakaan</td>
            					
            					<td class="text-center">Perpustakaan</td>
            					<td class="text-center"><?=(!isset($ijazah['peminjaman_buku']) || $ijazah['peminjaman_buku']==0)?"<span class='badge badge-danger'><i class='fa fa-times'></i></span>":"<span class='badge badge-success'><i class='fa fa-check'></i></span>";?></td>
            					
            				</tr>
            				<tr>
            					<td class="text-center">7</td>
            					<td>Submit artikel di jurnal</td>
            					
            					<td class="text-center">LPJI</td>
            					<td class="text-center"><?=(!isset($ijazah['artikel']) || $ijazah['artikel']==0)?"<span class='badge badge-danger'><i class='fa fa-times'></i></span>":"<span class='badge badge-success'><i class='fa fa-check'></i></span>";?></td>
            					
            				</tr>
                        </tbody>
    
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button onclick="window.open('<?=base_url();?>/<?=$controller;?>/cetak?id=<?=$ijazah['id_ijz'];?>', '', 'width=800, height=600, status=1,scrollbar=yes'); return false;" class="btn btn-sm btn-success">
                    Cetak Persyaratan Pengambilan Ijazah
                    </button>
                
            </div>
        </div>
        
    </div>
</section>


<div class="modal fade" id="errorModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_import" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        
                    <div class="card card-primary">
                       
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 id="judulError" hidden>Data Error</h4>
                                    <table id="table1" class="table table-bordered table-hover">
                                        <thead></thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_import" onclick="prosesImport()">Simpan </button>
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


<script>
var table;
$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
})


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
      //table_reload:true,
      //confirmButton:true,
      scrollable:false
    });
    return false;
}




function formulir(id_his_pdk) {
    var link = "<?=base_url("tugasakhir/$controller/formulir?id_his_pdk=")?>"+id_his_pdk;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
   
    $.createModal({
      title:'Formulir Pendaftaran Munaqasyah Skripsi',
      message: iframe,
      closeButton:true,
      table_reload:true,
      scrollable:false
    });
    return false;
}


</script>
<?=$this->endSection();?>