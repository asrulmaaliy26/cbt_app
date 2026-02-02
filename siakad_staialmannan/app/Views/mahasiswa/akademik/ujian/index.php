<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

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
									<td><?=$his_pdk['NIM'];?></td>
								</tr>
								<tr>
									<th>Prodi</th>
									<td><?=$his_pdk['Prodi'];?></td>
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
									<td><?=($his_pdk['Kelas'] == "PA") ? "Putera" : (($his_pdk['Kelas'] == "PI") ? "Puteri" : $his_pdk['Kelas']);?></td>
								</tr>
								<tr>
									<th>Program</th>
									<td><?=$his_pdk['Program'];?></td>
								</tr>
								
		                      
		                    </table>
		                </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
    
            <div class="card-body">
            	<table id="data" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="col-1 text-center align-middle">No.</th>
                            <th class="col-3 text-center align-middle">Jenis Ujian</th>
                            <th class="col-1 text-center align-middle">Tahun Akademik</th>
                            <th class="col-1 text-center align-middle">Semester</th>
                            <th class="col-1 text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            foreach ($record as $value) {
                                
                        ?>
                        <tr>
                            <td class="text-center align-middle"><?=$nomor++;?></td>
                            <td class="text-center">
                            	<?=($value['jenis_ujian'] == 'UTS') ? 'Ujian Tengah Semester (UTS)' : (($value['jenis_ujian'] == 'UAS')?'Ujian Akhir Semester (UAS)':$value['jenis_ujian'])?>
                            </td>
                            <td class="text-center"><?=$value['tahun'];?></td>
                            <td class="text-center"><?=$value['semester']== 1?'Gasal':'Genap';?></td>
                            <td class="text-center">
                                
                                <!--<a href="<?=site_url()?>/akademik/ujian/detail?id=<?=$value['id_ujian']?>" role="button" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>-->
                                
                                <a href="javascript:void(0)" role="button" class="btn btn-xs btn-primary" data-placement="top" title="Detail" onclick="cekData('<?=$value['id_ujian']?>','<?=$his_pdk['id_his_pdk'];?>')"><i class="fa fa-eye"></i> Lihat Data</a>
                                
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
                    echo $pager->links('dt','datatable');
                ?>
            </div>
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


<script>

$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
})

function cekData(id_ujian, id_his_pdk){
    $.ajax({
        type: "post",
        url: "<?php echo site_url("akademik/$controller/cekData");?>",
        data: "id_ujian=" + id_ujian+"&id_his_pdk="+id_his_pdk,
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
        success: function(response) {
            Swal.close();
            if (response.msg == "success") {
                window.location.href = response.link;
                
            } else {
                Swal.fire({
                    icon: response.msg,
                    title: response.title_pesan,
                    html: response.text_pesan,
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                });
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
    })
}    
    


</script>
<?=$this->endSection();?>