
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
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body"> 
                    <form class="form-horizontal" id="form_tambah" enctype="multipart/form-data">
                        
                        <div class="form-group row " hidden>
                            <label class="col-sm-3 col-form-label">Kode</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Kode" name="Kode" value="<?=(isset($Kode))?$Kode:''?>" />
                                <input type="text" class="form-control" id="id_pengabdian" name="id_pengabdian" value="<?=(isset($id_pengabdian))?$id_pengabdian:''?>" />
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Judul Pengabdian</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="judul_pengabdian" name="judul_pengabdian" value="<?=(isset($judul_pengabdian))?$judul_pengabdian:''?>" />
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Tahun Pengabdian</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tahun_pengabdian" name="tahun_pengabdian" value="<?=(isset($tahun_pengabdian))?$tahun_pengabdian:''?>" />
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Sumber Dana</label>
                            <div class="col-sm-9">
                                <select name="dana_pengabdian" id="dana_pengabdian" class="form-control select2">
                                    <<option value="">  </option>
										<option value="Mandiri" <?=(isset($dana_pengabdian) && $dana_pengabdian == 'Mandiri')?'selected':''?>>Mandiri</option>
										<option value="Dana Lembaga" <?=(isset($dana_pengabdian) && $dana_pengabdian == 'Dana Lembaga')?'selected':''?>>Dana Lembaga</option>
										<option value="Hibah Nasional" <?=(isset($dana_pengabdian) && $dana_pengabdian == 'Hibah Nasional')?'selected':''?>>Hibah Nasional</option>
										<option value="Hibah Internasional" <?=(isset($dana_pengabdian) && $dana_pengabdian == 'Hibah Internasional')?'selected':''?>>Hibah Internasional</option>
                                </select>
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Tingkat Pengabdian</label>
                            <div class="col-sm-9">
                                <select name="tingkat_pengabdian" id="tingkat_pengabdian" class="form-control select2">
                                    <<option value="">  </option>
										<option value="Lokal" <?=(isset($tingkat_pengabdian) && $tingkat_pengabdian == 'Lokal')?'selected':''?>>Lokal</option>
										<option value="Nasional" <?=(isset($tingkat_pengabdian) && $tingkat_pengabdian == 'Nasional')?'selected':''?>>Nasional</option>
										<option value="Internasional" <?=(isset($tingkat_pengabdian) && $tingkat_pengabdian == 'Internasional')?'selected':''?>>Internasional</option>
                                </select>
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Upload Laporan</label>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="upload_file" name="upload_file">
                                    
                                    <label class="custom-file-label" for="upload_file">Choose file</label>
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="form-group row ">
                            
                            <div class="col-sm-9 offset-sm-3">
                                <?php if(!empty($lokasi_file) ){?>
                                <button onclick="window.open('<?=$lokasi_file?>', '', 'width=800, height=600, status=1,scrollbar=yes'); return false;" class="btn btn-sm btn-success">
            						<i class="fa fa-link"></i>
            						Preview File
            					</button>        
                                <?php    } ?>
                            </div>
                        </div>
                        
                        
                    </form>
                    
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
<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url('assets');?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.js"></script>
<script>
$(function() {
	bsCustomFileInput.init();
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
   
})

function simpan() {

    var data = new FormData($("#form_tambah")[0]);
    Swal.fire({
        title: 'Anda yakin akan menyimpan data pengabdian ??',
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
                        $.each(data.validation, function(key, value) {
                            
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parents('.form-group').find('.invalid-feedback').text(value);
                            
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
                    //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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