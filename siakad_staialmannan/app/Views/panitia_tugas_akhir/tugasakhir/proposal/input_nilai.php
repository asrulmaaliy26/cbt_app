
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
                    <th style="width:30%" class="align-middle"></th>
                    <th style="width:35%">Penguji 1</th>
                    <th style="width:35%">Penguji 2</th>
                  </tr>
                  <tr>
                    <th class="align-middle">Rekomendasi</th>
                    <td>
                        <select name="rekom1" id="rekom1" onchange="simpan('<?=$id?>','rekom','1')" class="form-control select2">
                            <<option value="">  </option>
								<option value="1" <?=(isset($p1) && $p1['rekom']=='1')?'selected':''?> >Ditolak</option>
								<option value="2" <?=(isset($p1) && $p1['rekom']=='2')?'selected':''?> >Lulus Dengan Revisi</option>
								<option value="3" <?=(isset($p1) && $p1['rekom']=='3')?'selected':''?> >Lulus Tanpa Revisi</option>
                        </select>
                    </td>
                    <td>
                        <select name="rekom2" id="rekom2" onchange="simpan('<?=$id?>','rekom','2')" class="form-control select2">
                            <<option value="">  </option>
								<option value="1" <?=(isset($p2) && $p2['rekom']=='1')?'selected':''?> >Ditolak</option>
								<option value="2" <?=(isset($p2) && $p2['rekom']=='2')?'selected':''?> >Lulus Dengan Revisi</option>
								<option value="3" <?=(isset($p2) && $p2['rekom']=='3')?'selected':''?> >Lulus Tanpa Revisi</option>
                        </select>
                    </td>
                  </tr>
                  <tr>
                    <th class="align-middle">Nilai</th>
                    <td>
                        <input type="number"  step=".01" min="3.10" max="4.00" name="nilai1" id="nilai1" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','nilai','1')" value="<?=(isset($p1))?number_format($p1['nilai'],2):''?>"/>
                    </td>
                    <td>
                        <input type="number"  step=".01" min="3.10" max="4.00" name="nilai2" id="nilai2" class="form-control form-control-sm" onfocusout="simpan('<?=$id?>','nilai','2')" value="<?=(isset($p2))?number_format($p2['nilai'],2):''?>"/>
                    </td>
                  </tr>
                  <tr>
                      <th class="align-middle">Referensi Nilai</th>
                      <td colspan="2">
                            <div class="table-responsive">
                                <table class="table">
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

function simpan(id_sempro, field, penguji) {

    var val = $("#"+field+penguji).val();
	$.ajax({
		url:"<?php echo site_url("tugasakhir/$controller/$metode");?>",
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