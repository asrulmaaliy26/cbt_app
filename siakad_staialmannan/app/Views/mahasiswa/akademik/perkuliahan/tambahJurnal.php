
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
            <div class="row">
                <div class="col-md-3">
    
                    <!-- About Me Box -->
                    <div class="card card-primary card-outline">
                      
                      <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Matakuliah</strong>
        
                        <p class="text-muted">
                          <?=$perkuliahan['Mata_Kuliah']?>
                        </p>
        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Dosen</strong>
        
                        <p class="text-muted"><?=getDataRow('data_dosen', ['Kode'=>$perkuliahan['Kd_Dosen']])['Nama_Dosen']?></p>
        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Hari</strong>
        
                        <p class="text-muted">
                          <?=$perkuliahan['H_Jadwal']?>
                        </p>
        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Jam</strong>
        
                        <p class="text-muted"><?=$perkuliahan['Jam_Jadwal']?></p>
                        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Ruang</strong>
        
                        <p class="text-muted"><?=$perkuliahan['R_Jadwal']?></p>
                        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Kode Kelas Perkuliahan</strong>
        
                        <p class="text-muted"><?=$perkuliahan['kd_kelas_perkuliahan']?></p>
                        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Pelaksanaan</strong>
        
                        <p class="text-muted"><?=(!empty($perkuliahan['Pelaksanaan']))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $perkuliahan['Pelaksanaan']])['opt_val']:'-'?></p>
                        
                        <strong><i class="fas fa-book mr-1"></i> Prodi - Kelas</strong>
        
                        <p class="text-muted"><?php $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Prodi', null,null,null,'Prodi');
                                                    $prod =[]; 
                                                    foreach ($prodi as $key ) {
                                                       $prod[] = $key->Prodi;
                                                    }
                                                    $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Kelas', null,null,null,'Kelas');
                                                    $kls =[]; 
                                                    foreach ($kelas as $key ) {
                                                       $kls[] = $key->Kelas;
                                                    }
                                                    echo implode(" - ", $prod)." (".implode(" - ", $kls).")";
                        ?></p>
                        
                        
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    
                </div>
                <div class="col-md-9">
                        
                    <div class="card card-primary card-outline">
                        <form  id="form_jurnal" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hari</label>
                                            <input type="text" class="form-control" id="hari" placeholder="Topik perkuliahan" name="hari" readonly value="<?=hari(date('Y-m-d'))?>" >
                                            
                                            <input type="text" class="form-control" id="kode_kelas_perkuliahan" placeholder="Topik perkuliahan" name="kode_kelas_perkuliahan" readonly hidden value="<?=$perkuliahan['kd_kelas_perkuliahan']?>" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <input type="text" class="form-control" id="tanggal" placeholder="Topik perkuliahan" name="tanggal" readonly value="<?=date('Y-m-d')?>" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Topik</label>
                                    <input type="text" class="form-control " id="topik" placeholder="Topik perkuliahan" name="topik" >
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Metode Perkuliahan</label>
                                    <input type="text" class="form-control " id="metode_kuliah" placeholder="Metode perkuliahan" name="metode_kuliah" >
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </form>    
                        <div class="card-footer">
                            <button type="button" onclick="simpan()" class="btn btn-info float-right">Simpan</button>
                        </div>
                    </div>
                    
                    <div class="card card-danger">
                        <div class="card-header">
                            Keterangan
                        </div>
                        <div class="card-body">
                            <ol>
                                <li>Jurnal perkuliahan hanya bisa diinput sekali dalam sehari.</li>
                                <li>Jurnal perkuliahan hanya bisa diinput sesuai dengan jadwal perkuliahan.</li>
                            </ol>
                        </div>
                    </div>
                    
                    
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
$(function() {
	
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

})

function simpan() {

    var data = $('#form_jurnal').serialize();
    $('#form_jurnal').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan jurnal perkuliahan ??',
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
                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
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
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops!! Something wrong!!',
                        text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
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