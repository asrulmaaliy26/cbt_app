
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

<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">
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
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:15%" class="text-center align-middle">Aspek</th>
                        <th style="width:15%" class="text-center align-middle">Interval Skor</th>
                        <th style="width:35%" class="text-center align-middle">Penguji 1</th>
                        <th style="width:35%" class="text-center align-middle">Penguji 2</th>
                    </tr>
                  <tr>
                    <th class="align-middle">Penyampaian</th>
                    <td class="text-center align-middle">1 - 10</td>
                    <td>
                        <input type="number"  step="1" min="1" max="10" name="penyampaian1" id="penyampaian1" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','penyampaian','1')" value="<?=(!empty($p1['penyampaian']))?number_format($p1['penyampaian']):''?>"/>
                    </td>
                    <td>
                        <input type="number"  step="1" min="1" max="10" name="penyampaian2" id="penyampaian2" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','penyampaian','2')" value="<?=(!empty($p2['penyampaian']))?number_format($p2['penyampaian']):''?>"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle">Teknik Penulisan</th>
                    <td class="text-center align-middle">1 - 25</td>
                    <td>
                        <input type="number"  step="1" min="1" max="25" name="penulisan1" id="penulisan1" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','penulisan','1')" value="<?=(!empty($p1['penulisan']))?number_format($p1['penulisan']):''?>"/>
                    </td>
                    <td>
                        <input type="number"  step="1" min="1" max="25" name="penulisan2" id="penulisan2" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','penulisan','2')" value="<?=(!empty($p2['penulisan']))?number_format($p2['penulisan']):''?>"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle">Ketepatan Metode</th>
                    <td class="text-center align-middle">1 - 25</td>
                    <td>
                        <input type="number"  step="1" min="1" max="25" name="metode1" id="metode1" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','metode','1')" value="<?=(!empty($p1['metode']))?number_format($p1['metode']):''?>"/>
                    </td>
                    <td>
                        <input type="number"  step="1" min="1" max="25" name="metode2" id="metode2" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','metode','2')" value="<?=(!empty($p2['metode']))?number_format($p2['metode']):''?>"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle">Konten</th>
                    <td class="text-center align-middle">1 - 25</td>
                    <td>
                        <input type="number"  step="1" min="1" max="40" name="konten1" id="konten1" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','konten','1')" value="<?=(!empty($p1['konten']))?number_format($p1['konten']):''?>"/>
                    </td>
                    <td>
                        <input type="number"  step="1" min="1" max="40" name="konten2" id="konten2" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','konten','2')" value="<?=(!empty($p2['konten']))?number_format($p2['konten']):''?>"/>
                    </td>
                  </tr>
                  
                </table>
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
$(function() {
	
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
   
})

function simpan(id_munaqasyah, field, penguji) {

    var val = $("#"+field+penguji).val();
	$.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/$metode");?>",
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


</script>
</body>
</html>