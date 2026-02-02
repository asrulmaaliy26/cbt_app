
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

<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/toastr/toastr.min.css">
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
  	<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body>
<div class="wrapper">
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                Filter Data
                            </h3>
                            <div class="card-tools">
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <!--    
                        	<div class="col-md-12">
                                <div class="form-group">
                                    <label>Periode</label>
                                    <select name="periode" id="periode" onchange="ganti_periode()" class="form-control select2"  style="width: 100%;">
                                        <option></option>
                                        <option value="1"> Gasal </option>
        							    <option value="2"> Genap </option>
                                        
                                    </select>
                                </div>
                            </div>
                            -->
                            <strong>Kurikulum</strong>
        
                            <p class="text-muted"><?=$nama_kurikulum?></p>
            
                            <hr>
                            <strong>Berlaku Sejak</strong>
        
                            <p class="text-muted"><?=getDataRow('tahun_akademik',['kode'=>$mulai_berlaku])['tahunAkademik']?> <?=getDataRow('tahun_akademik',['kode'=>$mulai_berlaku])['semester'] == '1' ? 'Gasal':'Genap'?></p>
            
                            <hr>
                            <div class="col-md-12">
                            	<div class="form-group">
                                    <label>Semester</label>
		                            <select name="semester" id="semester" class="form-control select2" onchange="reload_table()" style="width: 100%;">
                                        <option></option>
                                        <option value="1"> 1 </option>
            							<option value="2"> 2 </option>
            							<option value="3"> 3 </option>
            							<option value="4"> 4 </option>
            							<option value="5"> 5 </option>
            							<option value="6"> 6 </option>
            							<option value="7"> 7 </option>
            							<option value="8"> 8 </option>
                                        
                                    </select>
		                        </div>
                            </div>
                            
                               
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card card-primary card-outline" >
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                <?=$templateJudul?>
                            </h3>
                            <div class="card-tools">
                                
                                    <a role="button" class="btn btn-success btn-xs" title="Tambah" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">
                                        <i class="fa fa-plus"></i> 
                                    </a>
                                
                                <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                        <div class="card-body" >
                            <table id="data" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" ></th>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Mata Kuliah</th>
                                        <th>Bobot MK</th>
                                        <th>SMT</th>
                                        <th></th>
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
    </section>
    <!-- /.content -->
    
</div>
<div class="modal fade" id="tambahModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_edit" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelEdit">Tambah Mata Kuliah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary card-outline">
                        
                        <div class="card-body">
                                <form action="" method="get">
                                    <div class="col-md-10 offset-md-1">
                                        <div class="row mb-2">
                                        	<div class="col-md-9">
                                                <div class="form-group">
                                                    <label>Prodi Pengampu</label>
                                                    <?php
                                                        echo cmb_dinamis('prodi', 'prodi', 'nm_prodi', 'singkatan', null, null, 'id="prodi"');
                                                    ?>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-md-3 mt-4">
                                                <div class="pt-2">
                    	                            <a role="button" class="btn btn-success " title="Tampilkan mata kuliah" data-palcement="top"  href="javascript:void(0)" onclick="getDataMk()">
                                                        <i class="fa fa-sync"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                            
                        </div>
                    </div>
                    <div class="card card-primary card-outline" id="card_mk" hidden>
                        <div class="card-body" >
                            <table id="data_mk" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Kode</th>
                                        <th>Mata Kuliah</th>
                                        <th>Bobot MK</th>
                                    </tr>
                                </thead>
                                <tbody>
            
                                </tbody>
            
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a role="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
                    <a role="button" onclick="simpan()" class="btn btn-primary" >Simpan </a>
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
var table;
$(function() {
	table = $('#data').DataTable({
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
	                "url": "<?php echo site_url("masterdata/$controller/listMatkulKurikulum") ?>",
	                "type": "POST",
	                "data": function(data) {
	                    data.id_kurikulum = "<?=$id?>";
                        data.semester = $('#semester option:selected').val();
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
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('#tambahModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#card_mk').attr('hidden', true);
        $(this).find('#data_mk tbody').empty();
        reload_table();
    });

})

function ganti_periode()
{
    var periode = $('#periode').val();
    if(periode==1){
	    
        $("#semester option[value='']").prop('disabled',false);
        $("#semester option[value='1']").prop('disabled',false);
        $("#semester option[value='2']").prop('disabled',true);
        $("#semester option[value='3']").prop('disabled',false);
        $("#semester option[value='4']").prop('disabled',true);
        $("#semester option[value='5']").prop('disabled',false);
        $("#semester option[value='6']").prop('disabled',true);
        $("#semester option[value='7']").prop('disabled',false);
        $("#semester option[value='8']").prop('disabled',true);
	}else{
	    $("#semester option[value='']").prop('disabled',false);
        $("#semester option[value='1']").prop('disabled',true);
        $("#semester option[value='2']").prop('disabled',false);
        $("#semester option[value='3']").prop('disabled',true);
        $("#semester option[value='4']").prop('disabled',false);
        $("#semester option[value='5']").prop('disabled',true);
        $("#semester option[value='6']").prop('disabled',false);
        $("#semester option[value='7']").prop('disabled',true);
        $("#semester option[value='8']").prop('disabled',false);
	}
}

function reload_table(){
    table.ajax.reload(null, false);
}

function getDataMk(){
    var prodi = $('#prodi option:selected').val();
	if(prodi == '' ){
		Swal.fire({
            icon: 'warning',
            title: 'Pilih prodi!!!',
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        })
	}else{
        $('#card_mk').attr('hidden', false);
        $('#data_mk').DataTable({
    	            "destroy": true,
    	            "paging": false,
    	            "lengthChange": false,
    	            "searching": true,
    	            "ordering": false,
    	            "info": false,
    	            "autoWidth": false,
    	            "responsive": true,
    	            "processing": true,
    	            "serverSide": true,
    	            "order": [],
    	            "ajax": {
    	                "url": "<?php echo site_url("masterdata/$controller/listMatkulMaster") ?>",
    	                "type": "POST",
    	                "data": function(data) {
    	                    data.id_kurikulum = "<?=$id?>";
                            data.prodi = $('#prodi option:selected').val();
    	                }
    	            },
    	            "columnDefs": [{
    	                "targets": [],
    	                "orderable": false,
    	            }, ],
    	    });
	}
	$('th input[type=checkbox], td input[name=check]').prop('checked', false);
                        
    var active_class = 'active';
    $('#data_mk > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header
        
        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[name=check]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[name=check]').eq(0).prop('checked', false);
        });
    });
}

function simpan(id_mastermk) {
    var id_kurikulum = "<?=$id?>";
    $.ajax({
        url: "<?php echo site_url("masterdata/$controller/simpanMatkulKurikulum");?>",
        type: "post",
        data: "id_kurikulum="+id_kurikulum+"&id_mastermk="+id_mastermk,
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
            	getDataMk();
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

function simpan_smt(field, id_matkul_kurikulum) {
	var val = $("#" + field + id_matkul_kurikulum).val();
    $.ajax({
        type: 'post',
        url: "<?php echo site_url("masterdata/$controller/updateMk");?>",
        data: {
            field: field,
            id_matkul_kurikulum: id_matkul_kurikulum,
            val: val
        },
        dataType: 'json',
        success: function(data) {
            if (data.status) {

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
                    icon: 'success',
                    title: "Data berhasil diupdate"
                })

            } else {

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
                    icon: 'error',
                    title: 'Data gagal diupdate'
                })
            }
        }
    })

}

function hapus(id) {
    //var link = "<?=site_url("masterdata/$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Data akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("masterdata/$controller/$metode");?>",
                type: "post",
                data: "aksi=hapus&id_matkul_kurikulum=" + id,
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
                    //$(".overlay").css("display","none");
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil dihapus',
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
                        });

                    } else {

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
                            icon: 'error',
                            title: 'Data gagal dihapus'
                        })
                    }
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