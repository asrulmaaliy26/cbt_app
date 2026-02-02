
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
            
                    <div class="card card-primary card-outline">
                        <form  id="form_dokumen" enctype="multipart/form-data">
                            <div class="card-body">
                                
                                <div class="form-group" hidden>
                                    <label>Nama Dokumen</label>
                                    <input type="text" class="form-control " id="id_munaqasyah" placeholder="Nama dokumen" name="id_munaqasyah" value="<?=(!empty($id_munaqasyah))?$id_munaqasyah:''?>">
                                    <input type="text" class="form-control " id="field" placeholder="Nama dokumen" name="field" value="<?=(!empty($field))?$field:''?>">
                                    <div class="invalid-feedback"></div>
                                </div>
                                
                                <div class="form-group">
						            <label for="berkas">File</label>
						            <div class="input-group">
			                            <div class="custom-file">
			                                <input type="file" class="custom-file-input"
			                                    id="berkas" name="berkas"> 
			                                <label class="custom-file-label" for="berkas">Pilih file</label>
			                                <div class="invalid-feedback"></div>
			                            </div>
		                        	</div>
			                        
						        </div>
                            </div>
                        </form>    
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

<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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

    var data = new FormData($("#form_dokumen")[0]);
    
    $('#form_dokumen').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("tugasakhir/$controller/$metode");?>",
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
                        const myObj = JSON.parse(JSON.stringify(data.validation));
                        let pesan = "";
                        for (const x in myObj) {
                          pesan += myObj[x] ;
                        }
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            html : pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })

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
        }
    })

}

</script>
</body>
</html>