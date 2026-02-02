
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
            <h4 class="m-0"><?=$templateJudul?> <?php $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['id_data_diri']; echo getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'];?></h4>
            
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                
                <div class="card-body">
                	<div class="row">
	                    <div class="col-6">
	                        <p class="lead">Matakuliah yang akan ditransfer</p>
	                        <div class="table-responsive">
			                    <table class="table ">
			                        
			                    	<tr>
				                        <th style="width:40%">Matakuliah</th>
				                        <td><?=getDataRow('master_matakuliah', ['kode_mk' => $kode_mk_feeder])['nama_mk'];?></td>
									</tr>
									<tr>
				                        <th style="width:40%">Semester</th>
				                        <td><?=getDataRow('tahun_akademik', ['kode' => getDataRow('mata_kuliah', ['id' => $id_mk])['Kd_Tahun']])['tahunAkademik'];?> <?=getDataRow('tahun_akademik', ['kode' => getDataRow('mata_kuliah', ['id' => $id_mk])['Kd_Tahun']])['semester'] == '1'?'Gasal':'Genap';?></td>
									</tr>
									<tr>
										<th >Prodi</th>
										<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Prodi'];?> - <?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Program'];?></td>
									</tr>
									<tr>
										<th>SKS</th>
										<td><?=$sks;?></td>
									</tr>
									<tr>
										<th>Nilai UTS</th>
										<td><?=number_format($Nilai_UTS,2);?></td>
									</tr>
									<tr>
										<th>Nilai TGS</th>
										<td><?=number_format($Nilai_TGS,2);?></td>
									</tr>
									<tr>
										<th>Nilai UAS</th>
										<td><?=number_format($Nilai_UAS,2);?></td>
									</tr>
									<tr>
										<th>Nilai Perf.</th>
										<td><?=number_format($Nilai_Performance,2);?></td>
									</tr>
			                      
			                    </table>
			                </div>
	                    </div>
	                    <div class="col-6">
	                    	<div class="table-responsive">
	                    	    <p class="lead">Diakui sebagai matakuliah</p>
	                    	    <form id="form_transfer">
			                    <table class="table ">
			                    	<tr>
			                    	    <input type="text" value="<?=$id_ljk?>" name="id_ljk_lama" id="id_ljk_lama" hidden/>
				                        <th style="width:40%">Prodi</th>
				                        <td>
				                            
				                            <select name="prodi" id="prodi" class="form-control select2" style="width:100%">
        						                <?php $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['id_data_diri'];
        						                        $histori_pddk = dataDinamis('histori_pddk', ['id_data_diri' => $id_data_diri], null, null, null, 'id_his_pdk', [$id_his_pdk]);
        						                        foreach($histori_pddk as $r) {
        						                ?>
        						                <option value="<?=$r->id_his_pdk?>" prodi="<?=$r->Prodi?>" prog="<?=$r->Program?>" kelas="<?=$r->Kelas?>"><?=$r->Prodi?> - <?=$r->Program?></option>
        						                <?php } ?>
        						            </select>
				                        </td>
									</tr>
									<tr>
										<th >Semester</th>
										<td>
										    <select name="semester" id="semester" class="form-control select2" style="width: 100%;">
                                                <option></option>
                                                
                                                <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                                    
                                                    foreach ($tahunAkademik as $key ) {
                                                ?>
                                                <option value="<?=$key->kode?>" <?=(getDataRow('mata_kuliah', ['id' => $id_mk])['Kd_Tahun'] == $key->kode)?'selected':''?> ><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                                <?php    }    ?>
                                            </select>
										</td>
									</tr>
									<tr>
										<th>Matakuliah</th>
										<td>
										    <select name="m" id="m" class="form-control select2" style="width: 100%;">
                                                
                                            </select>
										</td>
									</tr>
									
			                      
			                    </table>
			                    </form>
			                </div>
	                    </div>
	                </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" onclick="simpan()">Simpan </button>
                </div>
            </div>
            
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
	
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('#m').select2({
        placeholder: '--- Cari Matakuliah ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getMatakuliahAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    tabel: 'mata_kuliah',
                    field: 'Mata_Kuliah',
                    kd_tahun: $('#semester option:selected').val(),
                    prodi: $('#prodi option:selected').attr('prodi'),
                    kelas: $('#prodi option:selected').attr('kelas'),
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
    
    
})

function simpan() {
    var data = $('#form_transfer').serialize();
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
                            title: 'Data berhasil disimpan',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    }  else if (data.msg == 'invalid') {

                        $.each(data.validation, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data gagal disimpan',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })
}
</script>
</body>
</html>