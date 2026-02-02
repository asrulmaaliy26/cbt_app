
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
            <h4 class="m-0"><?=$templateJudul?></h4>
            
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
            <div class="card card-primary card-outline" id="card_mk">
                
                <div class="card-body" >
                    <div class="table-responsive">
                        <table id="data_jurnal" class="table table-bordered table-hover">
        	                <thead>
        		                <tr>
        		                    <th class="text-center">No</th>
        		                    <th class="text-center">Tanggal</th>
        		                    <th class="text-center">Topik</th>
        		                    <th class="text-center">Metode</th>
        		                    <th class="text-center">Sudah Direkap?</th>
        		                </tr>
        	                </thead>
        	                <tbody>
        	                  
        	                </tbody>
                        </table>
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
var table;
$(function() {
	
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    table = $('#data_jurnal').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(1).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
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
            "order": [],
            "ajax": {
                "url": "<?php echo site_url("akademik/$controller/listJurnalPerkuliahan") ?>",
                "type": "POST",
                "data": function(data) {
                    data.kd_kelas_perkuliahan = '<?=$perkuliahan['kd_kelas_perkuliahan']?>';
                    data.tgl_awal = '<?=$tgl_awal?>';
                    data.tgl_akhir = '<?=$tgl_akhir?>';
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });

})

function changeRekapJurnal(id_jurnal_kuliah) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengubah status rekap jurnal?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/$metode");?>",
                type: "post",
                data: "aksi=changeRekapJurnal&id_jurnal_kuliah=" + id_jurnal_kuliah,
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
                    
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    }).then(() => {
                        table.ajax.reload(null, false);
                    });

                    
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    //$(".overlay").css("display","none");
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    });
}


</script>
</body>
</html>