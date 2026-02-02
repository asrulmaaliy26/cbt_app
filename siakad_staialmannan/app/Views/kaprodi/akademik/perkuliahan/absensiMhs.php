
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
<!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                  <tr>
                                    <th style="width:25%">Mata Kuliah</th>
                                    <td>: <?=$perkuliahan['Mata_Kuliah']?></td>
                                  </tr>
                                  <tr>
                                    <th >Nama Dosen</th>
                                    <td>: <?=getDataRow('data_dosen', ['Kode'=>$perkuliahan['Kd_Dosen']])['Nama_Dosen']?></td>
                                  </tr>
                                  
                                  <tr>
                                    <th>Jadwal</th>
                                    <td>: <?=$perkuliahan['H_Jadwal']?> Jam <?=$perkuliahan['Jam_Jadwal']?> Ruang <?=$perkuliahan['R_Jadwal']?></td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-sm-5">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                  <tr>
                                    <th style="width:45%">Kode Kelas Perkuliahan</th>
                                    <td>: <?=$perkuliahan['kd_kelas_perkuliahan']?></td>
                                  </tr>
                                  <tr>
                                    <th >Pelaksanaan</th>
                                    <td>: <?=(!empty($perkuliahan['Pelaksanaan']))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $perkuliahan['Pelaksanaan']])['opt_val']:'-'?></td>
                                  </tr>
                                  
                                  <tr>
                                    <th>Prodi - Kelas</th>
                                    <td>: <?php $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Prodi', null,null,null,'Prodi');
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
                                            ?>
                                    </td>
                                  </tr>
                                </table>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>    
            
            <div class="card card-primary card-outline">
                <form  id="form_absensi" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Prodi</label>
                                    <select name="prodi" id="prodi" class="form-control select2" onchange="reload_table()" style="width: 100%;">
                                        <option></option>
                                        
                                        <?php $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Prodi', null,null, null, 'Prodi'); 
                                            
                                            foreach ($prodi as $key ) {
                                        ?>
                                        <option value="<?=$key->Prodi?>" ><?=$key->Prodi?></option>
                                        <?php    }    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select name="kelas" id="kelas" class="form-control select2" onchange="reload_table()" style="width: 100%;">
                                        <option></option>
                                        
                                        <?php $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Kelas', null,null, null, 'Kelas'); 
                                            
                                            foreach ($kelas as $key ) {
                                        ?>
                                        <option value="<?=$key->Kelas?>" ><?=$key->Kelas?></option>
                                        <?php    }    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Hari</label>
                                    <input type="text" class="form-control" id="hari" placeholder="Topik perkuliahan" name="hari" readonly value="<?=hari(date('Y-m-d'))?>" >
                                    
                                    <input type="text" class="form-control" id="kode_kelas_perkuliahan" name="kode_kelas_perkuliahan" readonly hidden value="<?=$perkuliahan['kd_kelas_perkuliahan']?>" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="text" class="form-control" id="tanggal" placeholder="Topik perkuliahan" name="tanggal" readonly value="<?=date('Y-m-d')?>" >
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive-sm">
                            <table id="data_mhs" class="table table-bordered table-hover table-sm">
            	                <thead>
            		                <tr>
            		                    <th rowspan="2" class="text-center align-middle">No</th>
            		                    <th rowspan="2" class="text-center align-middle">Nama</th>
            		                    <th rowspan="2" class="text-center align-middle">Prodi</th>
            		                    <th rowspan="2" class="text-center align-middle">Angkatan</th>
            		                    <th colspan="4" class="text-center">Absensi</th>
            		                </tr> 
            		                <tr>
            		                    <th class="text-center">H</th>
            		                    <th class="text-center">S</th>
            		                    <th class="text-center">I</th>
            		                    <th class="text-center">A</th>
            		                </tr>
            	                </thead>
            	                <tbody>
            	                  
            	                </tbody>
                            </table>
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
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.js"></script>
<script>
var table;
$(function() {
	
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    table = $('#data_mhs').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(2).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    		},
            "destroy": true,
            "paging": false,
            "lengthChange": false,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "fixedColumns": {
                left: 2
            },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url("akademik/$controller/ListMhsKelasAbsensi") ?>",
                "type": "POST",
                "data": function(data) {
                    data.kd_kelas_perkuliahan = '<?=$perkuliahan['kd_kelas_perkuliahan']?>';
                    data.tanggal = $('#tanggal').val();
                    data.prodi = $('#prodi').val();
                    data.kelas = $('#kelas').val();
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });

})

function reload_table(){
    table.ajax.reload(null, false);
}

function simpan() {

    var data = $('#form_absensi').serialize();
    //$('#form_jurnal').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan absensi perkuliahan ??',
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
                    } else{
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
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