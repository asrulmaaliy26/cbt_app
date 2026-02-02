
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
                	<div class="row">
	                    <div class="col-6">
	                        <div class="table-responsive">
			                    <table class="table table-sm">
			                    	<tr>
				                        <th style="width:40%">Nama</th>
				                        <td>
				                            <select name="m" id="m" class="form-control form-control-sm select2" style="width: 100%;">
                                                
                                            </select>
				                        </td>
									</tr>
									<tr>
										<th >NIM</th>
										<td><span id='nim'></span></td>
									</tr>
									<tr>
										<th>Prodi</th>
										<td><span id='prodi'></span></td>
									</tr>
									
			                      
			                    </table>
			                </div>
	                    </div>
	                    <div class="col-6">
	                    	<div class="table-responsive">
			                    <table class="table table-sm">
			                    	<tr>
				                        <th style="width:40%">Th. Angkatan</th>
				                        <td><span id='th_angkatan'></span></td>
									</tr>
									<tr>
										<th >Kelas</th>
										<td><span id='kelas'></span></td>
									</tr>
									<tr>
										<th>Program</th>
										<td><span id='program'></span></td>
									</tr>
									
			                      
			                    </table>
			                </div>
	                    </div>
	                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary card-outline" id="card_mk">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                Matakuliah yang tidak lulus
                            </h3>
                            <div class="card-tools">
                                <!--
                                    <a role="button" class="btn btn-success btn-xs" title="Tambah" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">
                                        <i class="fa fa-plus"></i> Tambah MK
                                    </a>
                                -->
                                
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                        <div class="card-body" >
                            <div class="table-responsive">
                                <table id="data_mk_tl" class="table table-bordered table-hover">
            		                <thead>
            			                <tr>
            			                    <th class="text-center">#</th>
            			                    <th class="text-center">No</th>
            			                    <th>Kode MK</th>
            			                    <th>Nama MK</th>
            			                    <th class="text-center">SKS</th>
            			                    <th class="text-center">Tahun</th>
            			                </tr>
            		                </thead>
            		                <tbody>
            		                  
            		                </tbody>
            	                </table>
            	            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-primary card-outline" id="card_mk">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                Matakuliah yang didaftarkan kuliah ulang
                            </h3>
                            <div class="card-tools">
                                <!--
                                    <a role="button" class="btn btn-success btn-xs" title="Tambah" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">
                                        <i class="fa fa-plus"></i> Tambah MK
                                    </a>
                                -->
                                
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                        <div class="card-body" >
                            <div class="table-responsive">
                                <table id="data_mk_ku" class="table table-bordered table-hover">
            		                <thead>
            			                <tr>
            			                    <th class="text-center">#</th>
            			                    <th class="text-center">No</th>
            			                    <th>Kode MK</th>
            			                    <th>Nama MK</th>
            			                    <th class="text-center">SKS</th>
            			                </tr>
            		                </thead>
            		                <tbody>
            		                  
            		                </tbody>
            	                </table>
            	            </div>
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
        placeholder: '--- Cari Mahasiswa ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: "<?=base_url("akademik/$controller/getMhs")?>",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    tabel: 'db_data_diri_mahasiswa',
                    field: 'Nama_Lengkap',
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.text + " (" + item.Prodi + " - " + item.Program + ")",
                            id: item.id,
                            prodi: item.Prodi,
                            program: item.Program,
                            nim: item.nim,
                            th_angkatan: item.th_angkatan,
                            kelas: item.kelas,
                        }
                    }),
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    }).on('select2:select', function(e) {
        var data = $(this).select2('data')[0];
        $('#nim').text(data.nim);
        $('#prodi').text(data.prodi);
        $('#th_angkatan').text(data.th_angkatan);
        $('#program').text(data.program);
        $('#kelas').text(data.kelas);
        getMkTl(data.id);
        getMkKu(data.id);
    });
    

})

function getMkTl(id_his_pdk)
{
    $('#data_mk_tl').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(1).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
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
            "url": "<?php echo site_url("akademik/$controller/listMkTl") ?>",
            "type": "POST",
            "data": function(data) {
                data.id_his_pdk = id_his_pdk;
                data.kd_ta = "<?=$ta['kode']?>";
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function getMkKu(id_his_pdk)
{
    $('#data_mk_ku').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(1).addClass('text-center');
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
            "url": "<?php echo site_url("akademik/$controller/listMkKu") ?>",
            "type": "POST",
            "data": function(data) {
                data.id_his_pdk = id_his_pdk;
                data.kd_ta = "<?=$ta['kode']?>";
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function tambahMkUlang(id_ljk, id_his_pdk)
{
    var kd_ta = "<?=$ta['kode']?>";
    $.ajax({
        url: "<?php echo site_url("akademik/$controller/$metode");?>",
        type: "post",
        data: {aksi:'tambah', id_ljk:id_ljk, id_his_pdk:id_his_pdk, kd_ta:kd_ta},
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
        	if(data.msg == 'info'){
        	    Swal.fire({
                    icon: data.msg,
                    title: data.pesan,
                    showCancelButton: true,
                    confirmButtonText: 'Tetap Diproses',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?php echo site_url("akademik/$controller/$metode");?>",
                            type: "post",
                            data: {aksi:'tambah_ulang', id_ljk:id_ljk, id_his_pdk:id_his_pdk, kd_ta:kd_ta},
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
                                    confirmButtonText: 'Ok',
                                    allowOutsideClick: false,
                                }).then(() => {
                                    getMkTl(id_his_pdk);
                		    	    getMkKu(id_his_pdk);
                    		    });
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                            	Swal.close();
                                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    } else {
                        getMkTl(id_his_pdk);
    		    	    getMkKu(id_his_pdk);
                    }
    		    });
        	}else{
        	    Swal.fire({
                    icon: data.msg,
                    title: data.pesan,
                    confirmButtonText: 'Ya',
                    allowOutsideClick: false,
                }).then(() => {
    		    	getMkTl(id_his_pdk);
    		    	getMkKu(id_his_pdk);
    		    });
        	}
            
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	Swal.close();
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function hapusMkUlang(id_ljk, id_his_pdk)
{
    var kd_ta = "<?=$ta['kode']?>";
    $.ajax({
        url: "<?php echo site_url("akademik/$controller/$metode");?>",
        type: "post",
        data: {aksi:'hapus', id_ljk:id_ljk, id_his_pdk:id_his_pdk, kd_ta:kd_ta},
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
                confirmButtonText: 'Ya',
                allowOutsideClick: false,
            }).then(() => {
		    	getMkTl(id_his_pdk);
		    	getMkKu(id_his_pdk);
		    });
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	Swal.close();
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function getData() {
	
	var th_akademik = $('#tahun_akademik option:selected').val();
    var prodi = $('#ps_pengampu option:selected').val();
    var kelas = $('#kelas_program option:selected').val();
    var semester = $('#semester option:selected').val();
	if(th_akademik == '' || prodi == '' || kelas == '' || semester == ''){
		Swal.fire({
            icon: 'warning',
            title: 'Pilih Tahun akademik, prodi, kelas, dan semester!!!',
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        })
	}else{
	    if(kelas == 'PA'){
	        var kls = '1';
	    }else if(kelas == 'PI'){
	        var kls = '0';
	    }else if(kelas == 'Kelas Siang'){
	        var kls = '2';
	    }
		$("#card_mhs").attr('hidden', false);
		$('#data').DataTable({
		        "createdRow": function (row, data, index) {
        			$('td', row).eq(0).addClass('text-center');
        			$('td', row).eq(1).addClass('text-center');
        			$('td', row).eq(4).addClass('text-center');
        			$('td', row).eq(5).addClass('text-center');
        			$('td', row).eq(6).addClass('text-center');
        			$('td', row).eq(7).addClass('text-center');
        		},
	            "destroy": true,
	            "paging": false,
	            "lengthChange": false,
	            "searching": false,
	            "ordering": false,
	            "info": false,
	            "autoWidth": false,
	            "responsive": true,
	            "processing": true,
	            "serverSide": true,
	            "order": [],
	            "ajax": {
	                "url": "<?php echo site_url("masterdata/$controller/listPesertaKelasSebelumnya") ?>",
	                "type": "POST",
	                "data": function(data) {
	                    data.kode_th_lalu = th_akademik;
	                    data.kode_kelas_lama = th_akademik+prodi+kls+semester;
	                }
	            },
	            "columnDefs": [{
	                "targets": [],
	                "orderable": false,
	            }, ],
	    });
	}
}
    
function simpanKrs(id_krs) {
    var list = [];
    $('.data-check:checked').each(function(){
        list.push(this.value);
    })
    if(list.length >0){
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Anda akan mengikuti perkuliahan "+list.length+" Matakuliah ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/simpanKrs");?>",
                    type: "post",
                    data: {id_krs:id_krs, id_mk:list},
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
                            }).then(() => {
                                location.reload();
                            })
                            
                        }else if (data.msg == 'info'){
                            Swal.fire({
                                icon: data.msg,
                                title: data.pesan,
                                confirmButtonText: 'OK',
                                allowOutsideClick: false,
                            }).then(() => {
                                location.reload();
                            })
                            
                        }else{
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
                        Swal.close();
                        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        })
                
    }else{
        Swal.fire({
            icon: 'warning',
            title: 'Silahkan pilih Matakuliah terlebih dahulu!!!!',
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        })
    }
}
</script>
</body>
</html>