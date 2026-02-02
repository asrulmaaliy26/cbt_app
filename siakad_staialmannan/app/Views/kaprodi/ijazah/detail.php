
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
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 class="m-0"><?=$templateJudul?> <?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id'=>$id_data_diri])['Nama_Lengkap'])?></h4>
            
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                
                <div class="card-body">
                	<form class="form-horizontal" id="form_update" enctype="multipart/form-data">
                	        <input type="text" hidden class="form-control" id="id_ijz" name="id_ijz" value="<?php echo (isset($id_ijz))?$id_ijz:""?>" />
	                        <div class="table-responsive table-responsive-sm">
			                    <table class="table table-sm">
			                    	<tr>
				                        <th style="width:25%">Nama</th>
				                        <td><?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);?></td>
									</tr>
									<tr>
										<th >NIM</th>
										<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['NIM'];?></td>
									</tr>
									<tr>
										<th>Prodi</th>
										<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Prodi'];?></td>
									</tr>
									<tr>
										<th>Status</th>
										<td>
										    <?php
                                                echo cmb_dinamis('status', 'ref_option', 'opt_val', 'opt_id', ((isset($status))?$status:NULL), 'form-control-sm', 'id="status"  style="width: 100%;"', null, null, ['opt_group' => 'status_ijazah', 'is_aktif !=' => 'N'], 'opt_val', ['Permohonan Baru', 'Reservasi PIN', 'Ditunda']);     
                                               
                                            ?>
										</td>
									</tr>
									<tr>
										<th>Persyaratan</th>
										<td>
										    <table class="table table-sm">
										        <tr>
										            <th style="width:60%">Lunas Biaya Perkuliahan (BAK)</th>
										            <td>
										                <?=(!empty($biaya_kuliah) && $biaya_kuliah == 1)?'<button type="button" class="btn btn-xs btn-success"><i class="fas fa-check"></i></button>':'<button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>'?>
										            </td>
										        </tr>
										        <tr>
										            <th >Lunas Biaya Wisuda (BAK)</th>
										            <td>
										                <?=(!empty($biaya_wisuda) && $biaya_wisuda == 1)?'<button type="button" class="btn btn-xs btn-success"><i class="fas fa-check"></i></button>':'<button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>'?>
										            </td>
										        </tr>
										        <tr>
										            <th >Lunas Biaya Pengurusan Ijazah (BAK)</th>
										            <td>
										                <?=(!empty($biaya_pengurusan_ijazah) && $biaya_pengurusan_ijazah == 1)?'<button type="button" class="btn btn-xs btn-success"><i class="fas fa-check"></i></button>':'<button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>'?>
										            </td>
										        </tr>
										        <tr>
										            <th >Wakaf Buku (BAK)</th>
										            <td>
										                <?=(!empty($waqaf_buku) && $waqaf_buku == 1)?'<button type="button" class="btn btn-xs btn-success"><i class="fas fa-check"></i></button>':'<button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>'?>
										            </td>
										        </tr>
										        <tr>
										            <th >Menyerahkan revisi skripsi (Kaprodi)</th>
										            <td>
										                <?=(!empty($revisi_skripsi) && $revisi_skripsi == 1)?'<button type="button" class="btn btn-xs btn-success"><i class="fas fa-check"></i></button>':'<button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>'?>
										            </td>
										        </tr>
										        <tr>
										            <th >Bebas tanggungan perpustakaan (Perpustakaan)</th>
										            <td>
										                <?=(!empty($peminjaman_buku) && $peminjaman_buku == 1)?'<button type="button" class="btn btn-xs btn-success"><i class="fas fa-check"></i></button>':'<button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>'?>
										            </td>
										        </tr>
										        <tr>
										            <th >Submit artikel ke jurnal (LPJI)</th>
										            <td>
										                <?=(!empty($artikel) && $artikel == 1)?'<button type="button" class="btn btn-xs btn-success"><i class="fas fa-check"></i></button>':'<button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>'?>
										            </td>
										        </tr>
										    </table>
										</td>
									</tr>
									<tr>
    								<th>Catatan</th>
    								<td>
    								    
                                        <div class="form-group">
                                            <textarea class="form-control summernote" rows="10" id="ket" name="ket">
                                                <?= (isset($ket))?$ket:""?>
                                            </textarea>
                                        </div>
                                        
    								</td>
    							</tr>
			                      
			                    </table>
			                </div>
	                </form>     
                </div>
                
                <div class="card-footer">
                    <button type="button" onclick="simpan()" class="btn btn-info float-right">Simpan</button>
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

<!-- Summernote -->
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-file.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-ext-rtl.js"></script>
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
    
    $('.summernote').summernote({
        tabsize: 2,
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['ltr', 'rtl', 'link', 'picture', 'video', 'file']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ]
    });
    
})

function simpan() {

    var data = new FormData($("#form_update")[0]);
    Swal.fire({
        title: 'Anda yakin akan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/$metode");?>",
                type: "post",
                data: data,
                processData: false,
                contentType: false,
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
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        })
        				
                    } else if (data.msg == 'warning') {
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                        $.each(data.validation, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });

                    } else {
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
                    //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })

}


</script>
</body>
</html>