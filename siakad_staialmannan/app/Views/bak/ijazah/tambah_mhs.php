
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
                        <form id="form_filter">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tahun Pengajuan</label>
                                            <select name="tahun_pengajuan" id="tahun_pengajuan" class="form-control select2" style="width: 100%;">
                                                <option></option>
                                                
                                                <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                                    $tAktif = (!empty(getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']))?getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']:'';
                                                    foreach ($tahunAkademik as $key ) {
                                                ?>
                                                <option value="<?=$key->kode?>" <?=(!empty($tAktif) && $tAktif==$key->kode)?'selected':''?>><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                                <?php    }    ?>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tahun NIM</label>
                                            <select name="tahun_nim" id="tahun_nim" class="form-control select2" style="width: 100%;">
                                                <option></option>
                                                
                                                <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC', 'tahunAkademik'); 
                                                    
                                                    foreach ($tahunAkademik as $key ) {
                                                ?>
                                                <option value="<?=substr($key->kode,2,2)?>" ><?=$key->tahunAkademik?></option>
                                                <?php    }    ?>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Prodi</label>
                                            <?php
                                                echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', null, null, 'id="prodi" style="width:100%;"');
                                            ?>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    	<div class="form-group">
                                            <label>Program</label>
        		                            <?php
                                                echo cmb_dinamis('program_kuliah', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="program_kuliah" style="width: 100%;"', null, null, ['opt_group' => 'program_kuliah', 'is_aktif !=' => 'N']);
                                            ?>
                                            <div class="invalid-feedback"></div>
        		                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-1 mt-4">
                                        <div class="pt-2">
            	                            <a role="button" class="btn btn-success " title="Tampilkan Data" data-palcement="top"  href="javascript:void(0)" onclick="getData()" >
                                                <i class="fa fa-sync"></i> 
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    
                </div>
                
                <div class="card-footer">
                
                    <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Tambah Data" onclick="simpan()">
                        Tambahkan
                    </button>
                </div>
            </div>
            <div class="card card-primary card-outline" id="card_mhs" hidden>
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        <?=$templateJudul?>
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
                    <table id="data" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" ></th>
                                <th class="text-center">No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th class="text-center">Prodi</th>
                                <th class="text-center">Program</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Th. Angkatan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
    
                        </tbody>
    
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="errorModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        
                    <div class="card card-primary">
                       
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 id="judulError" hidden>Data Error</h4>
                                    <table id="table1" class="table table-bordered table-hover">
                                        <thead></thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
                
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
var table;
$(function() {
	$('.numeric').inputmask("numeric", {
      removeMaskOnSubmit: true,
      radixPoint: ".",
      groupSeparator: ",",
      digits: 2,
      autoGroup: true,
            prefix: 'Rp ', //Space after $, this will not truncate the first character.
            rightAlign: false,
            // oncleared: function() {
            //   self.Value('');
            // }
    });
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

})


function getData() {
    var data = new FormData($("#form_filter")[0]);
    $.ajax({
        url: "<?php echo site_url("$controller/list_data_mhs");?>",
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
            if (data.msg == 'warning') {
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

            } else {
                $("#card_mhs").attr('hidden', false);
        		$('#data').DataTable({
        		        "createdRow": function (row, data, index) {
                			$('td', row).eq(0).addClass('text-center');
                			$('td', row).eq(1).addClass('text-center');
                			$('td', row).eq(4).addClass('text-center');
                			$('td', row).eq(5).addClass('text-center');
                			$('td', row).eq(6).addClass('text-center');
                			$('td', row).eq(7).addClass('text-center');
                			$('td', row).eq(8).addClass('text-center');
                			$('td', row).eq(9).addClass('text-center');
                		},
        	            "destroy": true,
        	            "paging": false,
        	            "lengthChange": false,
        	            "searching": false,
        	            "ordering": false,
        	            "info": false,
        	            "autoWidth": false,
        	            "responsive": false,
        	            "processing": true,
        	            "serverSide": true,
        	            "order": [],
        	            "ajax": {
        	                "url": "<?php echo site_url("$controller/list_data_mhs") ?>",
        	                "type": "POST",
        	                "data": function(data) {
        	                    data.tahun_nim = $('#tahun_nim option:selected').val();
        	                    data.prodi = $('#prodi option:selected').val();
                                data.program_kuliah = $('#program_kuliah option:selected').val();;
        	                }
        	            },
        	            "columnDefs": [{
        	                "targets": [],
        	                "orderable": false,
        	            }, ],
        	    });
        	    
        	    $('th input[type=checkbox], td input[name=check]').prop('checked', false);
                        
                var active_class = 'active';
                $('#data > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
                    var th_checked = this.checked;//checkbox inside "TH" table header
                    
                    $(this).closest('table').find('tbody > tr').each(function(){
                        var row = this;
                        if(th_checked) $(row).addClass(active_class).find('input[name=check]').eq(0).prop('checked', true);
                        else $(row).removeClass(active_class).find('input[name=check]').eq(0).prop('checked', false);
                    });
                });
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	Swal.close();
        	Swal.fire({
                icon: 'error',
                title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
            //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
    
    
}

function simpan(){
    var list = [];
    var tahun_pengajuan = $('#tahun_pengajuan option:selected').val();
    $('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		Swal.fire({
            title: 'Are you sure?',
            text: "Menambahkan "+list.length+" mahasiswa??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
    				type: "POST",
    				data: {id:list, tahun_pengajuan:tahun_pengajuan},
    			    url:"<?php echo site_url("$controller/simpan")?>",
    				dataType: "JSON",
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
    				success: function (data) {
    				    Swal.close();
    				    if (data.msg == 'warning') {
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
            
                        } else {
        				    Swal.fire({
                                icon: data.msg,
                                title: data.pesan,
                                allowOutsideClick: false,
                            }).then(() => {
                                getData();
                                if(data.listError.length > 0){
                                    $('#errorModal').modal('show');
                                    $('#judulError').attr('hidden', false)
            
                                    const thead = $('#table1 thead'); 
                                    const tbody = $('#table1 tbody');
                                    let tr = $("<tr />");
            
                                    $.each(Object.keys(data.listError[0]), function(_, key){
                                        tr.append("<th>" + key + "</th>")
                                    });
                                    tr.appendTo(thead);
            
                                    $.each(data.listError, function (_, value) {
                                        tr = $("<tr />");
                                        $.each(value, function(_, text){
                                            tr.append("<td>" + text + "</td>")
                                        });
                                        tr.appendTo(tbody);
                                    })
            
                                }
                            });
                        }
    				},
    				error: function (xhr, status, errorThrown) {
    				    Swal.close();
    				    Swal.fire({
                            icon: 'error',
                            title: xhr.status+ " "+xhr.responseText,
                            allowOutsideClick: false,
                        })
                        
                    }
    			});
    			return true;
            }
        })
			
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Pilih mahasiswa!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function simpanMhs(id_his_pdk) {
    let tahun_pengajuan = $('#tahun_pengajuan option:selected').val();
    $.ajax({
        url: "<?php echo site_url("$controller/simpanMhs");?>",
        type: "post",
        data: {id_his_pdk:id_his_pdk, tahun_pengajuan:tahun_pengajuan},
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
            	getData();
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


            }else if (data.msg == 'warning') {
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

            } else {
                Swal.fire({
	                icon: data.msg,
	                title: data.pesan,
	                confirmButtonText: 'Ya',
	                allowOutsideClick: false,
	            })
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	Swal.close();
            Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
        }
    });

}
</script>
</body>
</html>