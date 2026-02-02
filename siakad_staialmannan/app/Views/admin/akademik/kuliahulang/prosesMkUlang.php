
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
            <h4 class="m-0"><?=$templateJudul?> <?="Tahun Akademik ".getDataRow('tahun_akademik', ['kode'=>$ku['kd_ta']])['tahunAkademik']." ".(getDataRow('tahun_akademik', ['kode'=>$ku['kd_ta']])['semester'] == '1' ? 'Gasal':'Genap')?></h4>
            
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
				                            <?=getDataRow('db_data_diri_mahasiswa', ['id'=>getDataRow('histori_pddk',['id_his_pdk' => $ku['id_his_pdk']])['id_data_diri']])['Nama_Lengkap']?>
				                        </td>
									</tr>
									<tr>
										<th >NIM</th>
										<td><?=getDataRow('histori_pddk',['id_his_pdk' => $ku['id_his_pdk']])['NIM']?></td>
									</tr>
									<tr>
										<th>Prodi</th>
										<td><?=getDataRow('histori_pddk',['id_his_pdk' => $ku['id_his_pdk']])['Prodi']?></td>
									</tr>
									
			                      
			                    </table>
			                </div>
	                    </div>
	                    <div class="col-6">
	                    	<div class="table-responsive">
			                    <table class="table table-sm">
			                    	<tr>
				                        <th style="width:40%">Th. Angkatan</th>
				                        <td><?=getDataRow('db_data_diri_mahasiswa', ['id'=>getDataRow('histori_pddk',['id_his_pdk' => $ku['id_his_pdk']])['id_data_diri']])['th_angkatan']?></td>
									</tr>
									<tr>
										<th >Kelas</th>
										<td><?=getDataRow('db_data_diri_mahasiswa', ['id'=>getDataRow('histori_pddk',['id_his_pdk' => $ku['id_his_pdk']])['id_data_diri']])['kelas']?></td>
									</tr>
									<tr>
										<th>Program</th>
										<td><?=getDataRow('histori_pddk',['id_his_pdk' => $ku['id_his_pdk']])['Program']?></td>
									</tr>
									
			                      
			                    </table>
			                </div>
	                    </div>
	                </div>
                </div>
            </div>

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
                        <a href="<?=base_url("akademik/$controller/cetak?id_ku=").$ku['id']?>" rel="noopener" target="_blank" role="button" class="btn btn-xs btn-success" data-placement="bottom" title="Cetak" ><i class="fas fa-print"> Print</i></a>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                </div>
                <div class="card-body" >
                    <div class="table-responsive">
                        <table id="data_mk_ku" class="table table-bordered table-hover">
    		                <thead>
    		                    <tr>
    			                    <th rowspan="2" class="text-center align-middle">#</th>
    			                    <th rowspan="2" class="text-center align-middle">No</th>
    			                    <th colspan="3" class="text-center">MK Tidak Lulus</th>
    			                    <th colspan="3" class="text-center">MK Pengganti</th>
    			                </tr>
    			                <tr>
    			                    <th>Kode MK</th>
    			                    <th>Nama MK</th>
    			                    <th class="text-center">SKS</th>
    			                    <th>Kode MK</th>
    			                    <th>Nama MK</th>
    			                    <th class="text-center">Dosen</th>
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

<div class="modal fade" id="pilihMkModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_ku" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Matakuliah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Nama MK</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="id_ljk" name="id_ljk" hidden />
                            <input type="text" class="form-control" id="id_mk" name="id_mk" hidden />
                            <input type="text" class="form-control" id="id_his_pdk" name="id_his_pdk" hidden />
                            <input type="text" class="form-control" id="id_ku" name="id_ku" hidden />
                            <label class="col-sm-12 col-form-label"><span id="nama_mk"></span></label>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Th. MK Pengganti</label>
                        <div class="col-sm-9">
                            <select name="periode" id="periode" class="form-control select2"  style="width: 100%;">
                                <option></option>
                                
                                <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                    foreach ($tahunAkademik as $key ) {
                                ?>
                                <option value="<?=$key->kode?>" ><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                <?php    }    ?>
                            </select>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Prodi MK Pengganti</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('ps_pengampu', 'prodi', 'nm_prodi', 'singkatan', null, null, 'id="ps_pengampu"');
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Kelas MK Pengganti</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('kelas_program', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="kelas_program" style="width: 100%;"', null, null, ['opt_group' => 'program_kelas', 'is_aktif !=' => 'N']);
                            ?>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">MK Pengganti</label>
                        <div class="col-sm-9">
                            <select name="mk_pengganti" id="mk_pengganti" class="form-control select2">

                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="simpan()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
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
	getMkKu("<?=$ku['id']?>");
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('#pilihMkModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#nama_mk').text('');
    });
    
    $('#mk_pengganti').select2({
        placeholder: '--- Cari Matakuliah ---',
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getMatakuliahAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    tabel: 'mata_kuliah',
                    field: 'Mata_Kuliah',
                    kd_tahun: $('#periode option:selected').val(),
                    prodi: $('#ps_pengampu option:selected').val(),
                    kelas: $('#kelas_program option:selected').val(),
                };

            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data,
                    pagination: {
                        more: (params.page * 5) < data.length
                    }
                };
            },
            cache: true
        }

    });
})

function getMkKu(id_ku)
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
            "url": "<?php echo site_url("akademik/$controller/listProsesMkKu") ?>",
            "type": "POST",
            "data": function(data) {
                data.id_ku = id_ku;
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
}

function hapusMkUlang(id_ljk, id_his_pdk, kd_ta)
{
    
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
		    	
		    	getMkKu(data.id_ku);
		    });
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	Swal.close();
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

function pilihMkUlang(id_ljk) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("akademik/$controller/getDataMkUlang");?>",
        data: "id_ljk=" + id_ljk,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#pilihMkModal').modal('show');
                $('#exampleModalLabelEdit').text('Pilih Mata Kuliah Pengganti');
                $.each(response.data, function(key, value) {
                    if ($('#' + key).is('.select2')) {
                        $('#' + key).val(value).trigger('change');
                    }else{
                        if(key !== 'nama_mk'){
                           $('#' + key).val(value); 
                        }else{
                            $('#' + key).text(value);
                        }
                        
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oopsss',
                    text: 'blablabla'
                })
            }
        }
    })
}

function simpan() {

    var dataMk = $('#form_ku').serialize();
    $('#form_ku').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/simpanMkKu");?>",
                type: "post",
                data: dataMk,
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
                            showCancelButton: true,
                            confirmButtonText: 'Tetap Diproses',
                            cancelButtonText: 'Batal',
                            allowOutsideClick: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "<?php echo site_url("akademik/$controller/tetapsimpanMkKu");?>",
                                    type: "post",
                                    data: dataMk,
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
                                            $('#pilihMkModal').modal('hide');
                        		    	    getMkKu(data.id_ku);
                            		    });
                                    },
                                    error: function(xhr, ajaxOptions, thrownError) {
                                    	Swal.close();
                                        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                    }
                                });
                            }
            		    });
                	}else{
                	    
                	    Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'Ya',
                            allowOutsideClick: false,
                        }).then(() => {
                            $('#pilihMkModal').modal('hide');
            		    	getMkKu(data.id_ku);
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