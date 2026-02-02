<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                    <form action="" method="get">
                        <!--<div class="col-md-10 offset-md-1">-->
                            <div class="row ">
                                
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Hari</label>
                                        <?php
                                            echo cmb_dinamis('hari', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="hari"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'hari']);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Jam</label>
                                        <?php
                                            echo cmb_dinamis('jam', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="jam"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'jam_kuliah']);
                                        ?>
                                    </div>
                                </div>
                                
                            </div>
                            
                        <!--</div>-->
                    </form>
                
            </div>
                    
            <div class="card-footer">
                <!--
                <a role="button" class="btn btn-primary btn-sm" title="Update Jadwal" data-palcement="top"  href="javascript:void(0)" onclick="show_modal_jadwal()">
                    <i class="fa fa-sync"></i> Update Jadwal
                </a>
                -->
                <a role="button" class="btn btn-primary btn-sm" title="Ekspor Data" data-palcement="top"  href="javascript:void(0)" onclick="ekspor()">
                    <i class="fa fa-download"></i> Ekspor Data
                </a>
                
                <a role="button" class="btn btn-primary btn-sm" title="Update Jadwal" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#jadwalModal">
                    <i class="fa fa-sync"></i> Update Jadwal
                </a>
                
                <a role="button" class="btn btn-success btn-sm" title="Aktifkan Soal" data-palcement="top"  href="javascript:void(0)" onclick="activateAll()">
                    <i class="fa fa-check"></i> Aktifkan
                </a>
                <a role="button" class="btn btn-danger btn-sm" title="Non-Aktifkan Soal" data-palcement="top"  href="javascript:void(0)" onclick="deactivateAll()">
                    <i class="fa fa-times"></i> Non-Aktifkan
                </a>
            </div>
        </div>
        <div class="card card-primary card-outline">
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
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" ></th>
                                <th class="text-center">No</th>
                                <th class="text-center">Mata Kuliah</th>
                                <th class="text-center">Dosen</th>
                                <th class="text-center">Pelaksanaan</th>
                                <th class="text-center">Prodi</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">SMT</th>
                                <th class="text-center">Hari</th>
                                <th class="text-center">Tgl</th>
                                <th class="text-center">Jam</th>
                                <th class="text-center">Soal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
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


<!-- Modal -->
<div class="modal fade" id="jadwalModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_update" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary">
                       
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label">File Excel</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" accept=".xlsx, .xls" class="custom-file-input"
                                                        id="file_xlsUpdate" name="file_xlsUpdate"> 
                                                    <label class="custom-file-label" for="file_xlsUpdate">Pilih
                                                        file</label>
                                                </div>

                                            </div>

                                            <div class="invalid-feedback">

                                            </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 id="judulErrorUpdate" hidden>Data gagal update</h4>
                                    <table id="table_error_update" class="table table-bordered table-hover">
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
<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
var table;
$(function() {
    bsCustomFileInput.init();
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $('#tahun_akademik').on('select2:select', function (e) {
        ganti_semester();
    });
    
    
    $('#jadwalModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('#judulErrorUpdate').attr('hidden', true);
        $(this).find('#table_error_update tr').remove();
        $('#file_xlsUpdate').val('');
    });
    
    $('#errorModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        
        $(this).find('#table_error tr').remove();
    });
    
    table = $('#data').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(1).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    			$('td', row).eq(8).addClass('text-center');
    			$('td', row).eq(9).addClass('text-center');
    			$('td', row).eq(10).addClass('text-center');
    			$('td', row).eq(11).addClass('text-center');
    			$('td', row).eq(12).addClass('text-center');
    			$('td', row).eq(13).addClass('text-center');
    		},
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("akademik/$controller/ajaxListPerkuliahan") ?>",
            "type": "POST",
            "data": function(data) {
                data.tahun_akademik = "<?=$kd_tahun?>";
                data.jns_ujian = "<?=$jenis_ujian?>";
                data.hari = $('#hari').val();
                data.jam = $('#jam').val();
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
})


function reload_table(){
    table.ajax.reload(null, false);
}


function ekspor() {
    var kd_tahun = "<?=$kd_tahun?>";
    var jns_ujian = "<?=$jenis_ujian?>";
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		Swal.fire({
            title: 'Are you sure?',
            text: "Mengunduh data "+list.length+" Matakuliah ??",
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
    				data: {id:list, kd_tahun:kd_tahun, jns_ujian:jns_ujian},
    			    url:"<?php echo site_url("akademik/$controller/ekspor")?>",
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
    					var $a = $("<a>");
                        $a.attr("href",data.file);
                        $("body").append($a);
                        $a.attr("download",data.nama_file);
                        $a[0].click();
                        $a.remove();
    				},
    				error: function (jqXHR, textStatus, errorThrown) {
    				    Swal.close();
    					Swal.fire({
                            icon: 'error',
                            title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                            confirmButtonText: 'OK',
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
			text: "Pilih matakuliah yang akan diekspor!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}


function simpan() {
    var data = new FormData($("#form_update")[0]);
    data.append('jns_ujian', "<?=$jenis_ujian?>");
    $('#form_update').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/updateJadwal");?>",
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
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        confirmButtonText: 'Ya',
                        allowOutsideClick: false,
                    });
                    if(data.listError.length > 0){
                        $('#judulErrorUpdate').attr('hidden', false)

                        const thead = $('#table_error_update thead'); 
                        const tbody = $('#table_error_update tbody');
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

                    }else{
                        $('#jadwalModal').modal('hide');
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
    })
    
}

function activate(id, field) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengubah status!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, activate it!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/$metode");?>",
                type: "post",
                data: "aksi=activate&id=" + id+"&field="+field,
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
                       reload_table();
                    });

                    
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
    });
}

function activateAll() {
    var jns_ujian = "<?=$jenis_ujian?>";
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
        Swal.fire({
            title: 'Are you sure?',
            text: "Mengaktifkan "+list.length+" Matakuliah ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, activate it!',
            allowOutsideClick: false
        }).then((result) => {
            //window.location.href = link;
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/$metode");?>",
                    type: "post",
                    data: {kd_kelas_perkuliahan:list, aksi:"activateAll", jns_ujian:jns_ujian},
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
                           reload_table();
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
                        });
    
                        
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
        });
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Pilih matakuliah yang akan diaktifkan!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function deactivate(id, field) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengubah data ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, deactivate it!',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/$metode");?>",
                type: "post",
                data: "aksi=deactivate&id=" + id +"&field="+field,
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
                        reload_table();
                    });
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
    });
}

function deactivateAll() {
    var jns_ujian = "<?=$jenis_ujian?>";
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
        Swal.fire({
            title: 'Are you sure?',
            text: "Menon-aktifkan "+list.length+" Matakuliah ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, deactivate it!',
            allowOutsideClick: false
        }).then((result) => {
            //window.location.href = link;
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/$metode");?>",
                    type: "post",
                    data: {kd_kelas_perkuliahan:list, aksi:"deactivateAll", jns_ujian:jns_ujian},
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
                           reload_table();
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
                        });
    
                        
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
        });
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Pilih matakuliah yang akan dinon-aktifkan!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

</script>
<?=$this->endSection();?>