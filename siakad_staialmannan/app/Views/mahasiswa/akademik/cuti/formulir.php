
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
            <h4 class="m-0"><?=$templateJudul?> <?="Tahun Akademik ".$ta['tahunAkademik']." ".($ta['semester'] == '1' ? 'Gasal':'Genap')?></h4>
            
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                
                <div class="card-body">
                    <form class="form-horizontal" id="form_cuti" enctype="multipart/form-data">
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Th. Akademik</label>
                            <div class="col-sm-9">
                                <select name="periode" id="periode" class="form-control select2"  style="width: 100%;">
                                    <option></option>
                                    
                                    <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                        foreach ($tahunAkademik as $key ) {
                                    ?>
                                    <option value="<?=$key->kode?>" <?=(!empty($ta['kode']) && $ta['kode'] == $key->kode)?'selected':''?> ><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                    <?php    }    ?>
                                </select>
                                
                                <div class="invalid-feedback">
    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <label class="col-sm-12 col-form-label"><?=getDataRow('db_data_diri_mahasiswa', ['id'=>$m['id_data_diri']])['Nama_Lengkap']?></label>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">NIM</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="m" name="m" value="<?=$m['id_his_pdk']?>" hidden/>
                                <input type="text" class="form-control" id="id_krs" name="id_krs" hidden/>
                                <label class="col-sm-12 col-form-label"><?=$m['NIM']?></label>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Prodi</label>
                            <div class="col-sm-9">
                                <label class="col-sm-12 col-form-label"><?=$m['Prodi']?></label>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Program</label>
                            <div class="col-sm-9">
                                <label class="col-sm-12 col-form-label"><?=$m['Program']?></span></label>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Th. Angkatan</label>
                            <div class="col-sm-9">
                                <label class="col-sm-12 col-form-label"><?=getDataRow('db_data_diri_mahasiswa', ['id'=>$m['id_data_diri']])['th_angkatan']?></label>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">No. HP</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="no_hp" name="no_hp" />
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Alasan Cuti</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="alasan" name="alasan" />
                                <div class="invalid-feedback"></div>
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
	getidKrs("<?=$m['id_his_pdk']?>");
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
})

function getidKrs(id_his_pdk)
{
    var kd_ta = "<?=$ta['kode']?>";
    $.ajax({
        url: "<?php echo site_url("akademik/$controller/getidKrs");?>",
        type: "post",
        data: {id_his_pdk:id_his_pdk, kd_ta:kd_ta},
        dataType: 'json',
        success: function(data) {
            
            if (data.msg == 'success') {
                $('#id_krs').val(data.id_krs);
            } else{
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
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
 
function simpan() {
    var data = $('#form_cuti').serialize();
    $('#form_cuti').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan mengajukan permohonan cuti ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/$metode");?>",
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
                    if(data.msg == 'warning'){
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
                	}else{
                	    
                	    Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'Ya',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
            		    });
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