<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
	<div class="container-fluid">
        <div class="row">
	        <div class="col-sm-3">
	            <div class="card card-primary card-outline">
	                <div class="card-body">
	                	<div class="row">
		                    <div class="col-12">
		                        <div class="table-responsive">
				                    <table class="table table-sm">
				                    	<tr>
					                        <th style="width:40%">Tahun</th>
					                        <td><?=getDataRow('tahun_akademik', ['kode' => $kdta])['tahunAkademik'];?> <?=getDataRow('tahun_akademik', ['kode' => $kdta])['semester'] == '1'?'Gasal':'Genap'?></td>
										</tr>
										<tr>
											<th >Prodi</th>
											<td><?=$prodi;?></td>
										</tr>
										<tr>
											<th >Semester</th>
											<td><?="SMT ".$smt;?></td>
										</tr>
										<tr>
											<th >Kelas</th>
											<td><?=$kelas;?></td>
										</tr>
										<tr>
											<th>Kode Kelas</th>
											<td><?=$kd_kelas?></td>
										</tr>
				                      
				                    </table>
				                </div>
		                    </div>
		                </div>
	                </div>
	            </div>
	            <!-- /.card -->
	        </div>
	        <div class="col-sm-9">
    	        <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true" onclick="reload_table_mk()">Mata Kuliah</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false" onclick="reload_table_mhs()">Mahasiswa</a>
                          </li>
                          
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                          <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                              
                              <div class="mailbox-controls">
                                  <div class="row">
                                      
                                        <div class="btn-group">
                                          <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Tambah Mata Kuliah" onclick="frmtmbmk(<?=$kd_kelas?>)">
                                            <i class="fa fa-plus"></i>
                                          </button>
                                          
                                        </div>
                                  </div>
                                        
                                
                              </div>
                              <table id="data_mk" class="table table-bordered table-hover">
    				                <thead>
    					                <tr>
    					                    <th class="text-center">No</th>
    					                    <th>Kode MK</th>
    					                    <th>Nama MK</th>
    					                    <th>SKS</th>
    					                    <th>Dosen</th>
    					                    <th>Aksi</th>
    					                </tr>
    				                </thead>
    				                <tbody>
    				                  
    				                </tbody>
    			                </table>
                                
                          </div>
                          <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                              <div class="mailbox-controls">
                                  <div class="row">
                                        <div class="col-md-5">
                                            <select name="s" id="s" class="form-control form-control-sm select2" style="width:100%">
    						                	
    						                </select>
                                        </div>  
                                        <div class="col-md-7">
                                            <button type="button" onclick="simpan_per_mhs()" class="btn btn-sm btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Tambah Mahasiswa" onclick="frmtmbmhs1(<?=$kd_kelas?>)">
                                                Data Kelas Sebelumnya
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Tambah Mahasiswa" onclick="frmtmbmhs2(<?=$kd_kelas?>)">
                                                Data Mahasiswa
                                            </button>
                                          
                                        </div>
                                    </div>
                              </div>
                             <table id="data_mhs" class="table table-bordered table-hover">
				                <thead>
					                <tr>
					                    <th class="text-center">No</th>
					                    <th>NIM</th>
					                    <th>Nama</th>
					                    <th>Th. Angkatan</th>
					                    <th>SMT</th>
					                    <th>Status</th>
					                    <th></th>
					                </tr>
				                </thead>
				                <tbody>
				                  
				                </tbody>
			                </table>
                          </div>
                          
                        </div>
                    </div>
                  <!-- /.card -->
                </div>
	            <!-- /.card -->
	        </div>
	        
	    </div>
    </div>
</section>


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

<script>
var table_mk;
var table_mhs;
$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $('[data-mask]').inputmask();
   
    table_mk = $('#data_mk').DataTable({
        "createdRow": function (row, data, index) {
			$('td', row).eq(0).addClass('center');
		},
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("masterdata/$controller/listMkKelas") ?>",
            "type": "POST",
            "data": function(data) {
                data.kode_kelas = "<?=$kd_kelas?>";
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
    table_mhs = $('#data_mhs').DataTable({
        "createdRow": function (row, data, index) {
			$('td', row).eq(0).addClass('center');
		},
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("masterdata/$controller/listMhsKelas") ?>",
            "type": "POST",
            "data": function(data) {
                data.kode_kelas = "<?=$kd_kelas?>";
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });
    
    // Autocomplete Select2
    $('#s').select2({
        placeholder: '--- Ketikan NIM / Nama Mahasiswa ---',
        minimumInputLength: 3,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getMahasiswaAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    field2: 'h.NIM',
                    field1: 'm.Nama_Lengkap',
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

function reload_table_mk(){
    table_mk.ajax.reload(null, false);
}

function reload_table_mhs(){
    table_mhs.ajax.reload(null, false);
}

function hapus(tabel, id, param) {
    //var link = "<?=site_url("masterdata/$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: param+" akan dihapus?",
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
                data: "aksi=hapus&id=" + id +"&tabel="+tabel,
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
                            icon: 'success',
                            title: param+' berhasil dihapus',
                            allowOutsideClick: false,
                        }).then(() => {
                            if(tabel == 'distribusi_mk'){
                                reload_table_mk();
                            }
                            if(tabel == 'krs'){
                                reload_table_mhs();
                            }
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

function edit(id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("masterdata/$controller/getData");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#tambahModal').modal('show');
                $('#exampleModalLabelEdit').text('Edit Master Matakuliah');
                $.each(response.data, function(key, value) {
                    if ($('#' + key).is('.select2')) {
                        $('#' + key).val(value).trigger('change');
                    }else{
                        $('#' + key).val(value);
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

    var data = $('#form_tambah').serialize();
    $('#form_tambah').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("masterdata/$controller/simpan");?>",
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
                    	$('#tambahModal').modal('hide');
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
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
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })

}

</script>

<script type="text/javascript">
  

/*
* Here is how you use it
*/

function frmtmbmk(kd_kelas) {
    var link = "<?=base_url("masterdata/$controller/tambah_mk?kd_kelas=")?>"+kd_kelas;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Tambah Mata Kuliah',
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      reload_table:true,
      tbl_id:'table_mk',
      scrollable:false
    });
    return false;
}

function frmtmbmhs1(kd_kelas) {
    var link = "<?=base_url("masterdata/$controller/tambah_mhs1?kd_kelas=")?>"+kd_kelas;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Tambah Mahasiswa Dari Kelas Sebelumnya',
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      reload_table:true,
      tbl_id:'table_mhs',
      scrollable:false
    });
    return false;
}

function frmtmbmhs2(kd_kelas) {
    var link = "<?=base_url("masterdata/$controller/tambah_mhs2?kd_kelas=")?>"+kd_kelas;
    var iframe = '<object type="text/html" data="'+link+'" frameborder="0" scrolling="yes" seamless="seamless" style="display:block; width:100%; height:100vh;">No Support</object>';
    //var link_cetak = "<?=base_url("keuangan/transaksi/cetak_nota?id_transaksi=")?>"+id_trx;

    $.createModal({
      title:'Tambah Mahasiswa Baru',
      message: iframe,
      //link_cetak: link_cetak,
      //id_transaksi: id_trx,
      //status_transaksi: status_trx,
      closeButton:true,
      reload_table:true,
      tbl_id:'table_mhs',
      scrollable:false
    });
    return false;
}

function simpan_per_mhs() {
    let id_his_pdk = $('#s option:selected').val();
    let mhs = $('#s option:selected').text();
    let kode_kelas = "<?=$kd_kelas?>";

    Swal.fire({
        title: 'Anda yakin akan memasukkan '+mhs +' ke kelas ini ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
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
                    	reload_table_mhs();
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
    })
}

</script>

<?=$this->endSection();?>