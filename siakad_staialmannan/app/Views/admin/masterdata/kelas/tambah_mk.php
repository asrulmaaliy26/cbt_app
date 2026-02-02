
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
                        <form action="" method="get">
                            <div class="col-md-10 offset-md-1">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Kurikulum</label>
                                            <?php
                                                echo cmb_dinamis('kurikulum', 'kurikulum', 'nama_kurikulum', 'id', null, null, 'id="kurikulum" style="width: 100%;"',null, null, ['set_aktif' => '1']);
                                            ?>
                                            
                                        </div>
                                    </div>
                                	<div class="col-md-3">
                                        <div class="form-group">
                                            <label>Periode</label>
                                            <select name="periode" id="periode" onchange="ganti_periode()" class="form-control select2"  style="width: 100%;">
                                                <option></option>
                                                <option value="1"> Gasal </option>
                							    <option value="2"> Genap </option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                    	<div class="form-group">
                                            <label>Semester</label>
        		                            <select name="semester" id="semester" class="form-control select2"  style="width: 100%;">
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
                                    
                                    <div class="col-md-3 mt-4">
                                        <div class="pt-2">
            	                            <a role="button" class="btn btn-success " title="Tampilkan Data MK" data-palcement="top"  href="javascript:void(0)" onclick="getData()" >
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
                                <th>Kode</th>
                                <th>Mata Kuliah</th>
                                <th class="text-center">Bobot MK</th>
                                <th class="text-center">SMT</th>
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

function getData() {
	
	var kurikulum = $('#kurikulum option:selected').val();
    var periode = $('#periode option:selected').val();
    var semester = $('#semester option:selected').val();
	if(kurikulum == '' || periode == '' || semester == ''){
		Swal.fire({
            icon: 'warning',
            title: 'Pilih kurikulum. periode dan semester!!!',
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        })
	}else{
		$("#card_mk").attr('hidden', false);
		$('#data').DataTable({
		        "createdRow": function (row, data, index) {
        			$('td', row).eq(0).addClass('text-center');
        			$('td', row).eq(1).addClass('text-center');
        			$('td', row).eq(4).addClass('text-center');
        			$('td', row).eq(5).addClass('text-center');
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
	                "url": "<?php echo site_url("masterdata/$controller/listMatkulKurikulum") ?>",
	                "type": "POST",
	                "data": function(data) {
	                    data.id_kurikulum = kurikulum;
                        data.semester = semester;
                        data.kode_kelas = "<?=$kd_kelas?>";
	                }
	            },
	            "columnDefs": [{
	                "targets": [],
	                "orderable": false,
	            }, ],
	    });
	}
}
    function hapusTagihan(id_tagihan){
        Swal.fire({
            title: 'Anda yakin akan menghapus Tagihan ??',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url("keuangan/tagihan/hapus");?>",
                    type: "post",
                    data: "aksi=hapus&id_tagihan=" + id_tagihan,
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
                        if (data.status) {
                            Swal.fire({
    					        title: data.pesan,
    					        showCancelButton: false,
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
    function edit(id) {
        $.ajax({
            type: "post",
            url: "<?php echo site_url("keuangan/tagihan/getData");?>",
            data: "id=" + id,
            dataType: 'json',
            success: function(response) {
                if (response.msg) {
                    $('#editModal').modal('show');
                    $('#exampleModalLabelEdit').text('Edit Tagihan');
                    $.each(response.data, function(key, value) {
                    	if($('#'+key).is('.select2')){
                    		$('#' + key).val(value).trigger('change');
                    	}else{
                    		
                        	$('#' + key).val(value);
    					}
                    });
                    if($('#angsuran option:selected').val() == 'N'){
    					$('#price').attr('readonly',true);
    					$('#price').val($('#jml_tagihan').val());
    				}
    				$('#sisa_tagihan').val($('#jml_tagihan').val() - $('#jml_terbayar').val());
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
function simpanMkKelas(id_matkul_kurikulum) {
    let kd_kelas = "<?=$kd_kelas?>";
    $.ajax({
        url: "<?php echo site_url("masterdata/$controller/simpanMkKelas");?>",
        type: "post",
        data: "id_matkul_kurikulum="+id_matkul_kurikulum+"&kd_kelas="+kd_kelas,
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