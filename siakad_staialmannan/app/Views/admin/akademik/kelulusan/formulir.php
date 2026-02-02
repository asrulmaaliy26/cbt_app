
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
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?=base_url('assets')?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url('assets')?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.css">
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
                        <form action="" method="get">
                            <div class="col-md-10 offset-md-1">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tahun Angkatan</label>
                                            <select name="tahun_angkatan" id="tahun_angkatan" class="form-control select2" style="width: 100%;">
                                                <option></option>
                                                
                                                <?php $tahunAngkatan = dataDinamis('tahun_akademik', null, 'kode DESC', 'tahunAkademik'); 
                                                    foreach ($tahunAngkatan as $key ) {
                                                ?>
                                                <option value="<?=$key->tahunAkademik?>" ><?=$key->tahunAkademik?></option>
                                                <?php    }    ?>
                                            </select>
                                            
                                        </div>
                                    </div>
                                	<div class="col-md-4">
                                        <div class="form-group">
                                            <label>Prodi</label>
                                            <?php
                                                echo cmb_dinamis('ps_pengampu', 'prodi', 'nm_prodi', 'singkatan', null, null, 'id="ps_pengampu" style="width: 100%;"');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                    	<div class="form-group">
                                            <label>Kelas</label>
        		                            <?php
                                                echo cmb_dinamis('kelas_program', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="kelas_program" style="width: 100%;"', null, null, ['opt_group' => 'program_kelas', 'is_aktif !=' => 'N']);
                                            ?>
        		                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 mt-4">
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
                    <a role="button" class="btn btn-primary btn-sm" title="Update Jadwal" data-palcement="top"  href="javascript:void(0)" onclick="show_modal_kelulusan()">
                        <i class="fa fa-sync"></i> Luluskan
                    </a>
                    
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
                    <div class="table-responsive">
                        <table id="data" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" ></th>
                                    <th class="text-center">No</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th class="text-center">Prodi</th>
                                    <th class="text-center">Program</th>
                                    <th class="text-center">Kelas</th>
                                    <th class="text-center">Th. Angkatan</th>
                                    <th class="text-center"></th>
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

<!-- Modal -->
<div class="modal fade" id="modalKelulusan" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_update" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Kelulusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tahun Keluar</label>
                        <div class="col-sm-9">
                            
                            <select name="keluar_smt" id="keluar_smt" class="form-control select2" style="width: 100%;">
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
                        <label class="col-sm-3 col-form-label">Jenis Keluar</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('jns_keluar', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="jns_keluar" style="width:100%"', null, null, ['opt_group' => 'jns_keluar', 'is_aktif' => 'Y']);
                            ?>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Status Mahasiswa</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('status', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="status" style="width:100%"', null, null, ['opt_group' => 'status_mhs', 'is_aktif' => 'Y']);
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tgl. Keluar / Lulus</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="tgl_keluar_date"
                                data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    id="tgl_keluar" data-toggle="datetimepicker" name="tgl_keluar"
                                    data-target="#tgl_keluar_date" placeholder="YYYY-MM-DD" />
                                <div class="input-group-append" data-target="#tgl_keluar_date"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tgl. SK Yudisium / Keluar</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="tgl_yudisium_date"
                                data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    id="tgl_yudisium" data-toggle="datetimepicker" name="tgl_yudisium"
                                    data-target="#tgl_yudisium_date" placeholder="YYYY-MM-DD" />
                                <div class="input-group-append" data-target="#tgl_yudisium_date"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">No. SK Yudisium / Keluar</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="no_sk_yudisium" name="no_sk_yudisium" />
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label col-sm-3">Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ket" name="ket" />
                            <div class="invalid-feedback"></div>
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
                                    <table id="tabel_error" class="table table-bordered table-hover">
                                        <thead></thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    
                </div>
            
        </div>
    </div>
</div>

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
<!-- daterangepicker -->
<script src="<?=base_url('assets');?>/plugins/moment/moment.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
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
    
    $('#tgl_keluar_date, #tgl_yudisium_date').datetimepicker({
        format: 'YYYY-MM-DD',
        viewMode: 'years'
    });

})

function show_modal_kelulusan() {
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		$('#modalKelulusan').modal();
			
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Silahkan Pilih Mahasiswa!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function getData() {
	
	var th_angkatan = $('#tahun_angkatan option:selected').val();
    var prodi = $('#ps_pengampu option:selected').val();
    var kelas = $('#kelas_program option:selected').val();
	if(th_angkatan == '' || prodi == '' ){
		Swal.fire({
            icon: 'warning',
            title: 'Pilih Tahun akademik, prodi!!!',
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        })
	}else{
	    
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
	                "url": "<?php echo site_url("akademik/$controller/listMahasiswa") ?>",
	                "type": "POST",
	                "data": function(data) {
	                    data.th_angkatan = th_angkatan;
	                    data.prodi = prodi;
	                    data.kelas = kelas;
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
}

function simpan() {
    var keluar_smt = $('#keluar_smt option:selected').val();
    var jns_keluar = $('#jns_keluar option:selected').val();
    var status = $('#status option:selected').val();
    var tgl_keluar = $('#tgl_keluar').val();
    var tgl_yudisium = $('#tgl_yudisium').val();
    var no_sk_yudisium = $('#no_sk_yudisium').val();
    var ket = $('#ket').val();
    
    var list = [];
    $('.data-check:checked').each(function(){
        list.push(this.value);
    })
    if(list.length >0){
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Meluluskan / mengeluarkan "+list.length+" mahasiswa ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/simpanKelulusan");?>",
                    type: "post",
                    data: {id_his_pdk:list, keluar_smt:keluar_smt, jns_keluar:jns_keluar, status:status, tgl_keluar:tgl_keluar, tgl_yudisium:tgl_yudisium, no_sk_yudisium:no_sk_yudisium, ket:ket},
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
                        	$('#modalKelulusan').modal('hide');
                            Swal.fire({
                                icon: data.msg,
                                title: data.pesan,
                                confirmButtonText: 'OK',
                                allowOutsideClick: false,
                            }).then(() => {
                                getData();
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
                        }else if (data.msg == 'info'){
                            Swal.fire({
                                icon: data.msg,
                                title: data.pesan,
                                confirmButtonText: 'OK',
                                allowOutsideClick: false,
                            })
                            if(data.listError.length > 0){
                                $('#errorModal').modal('show')
    
                                const thead = $('#tabel_error thead'); 
                                const tbody = $('#tabel_error tbody');
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
                            title : "Ooopss!! Something wrong!!",
                            text : thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
                    }
                });
            }
        })
                
    }else{
        Swal.fire({
            icon: 'warning',
            title: 'Silahkan pilih Mahasiswa!!!!',
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        })
    }
    
}
    
function simpanMhsKelas(id_his_pdk) {
    
    $.ajax({
        url: "<?php echo site_url("masterdata/$controller/simpanMhsKelas");?>",
        type: "post",
        data: {id_his_pdk:id_his_pdk, kode_kelas:kode_kelas},
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
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

}
</script>
</body>
</html>