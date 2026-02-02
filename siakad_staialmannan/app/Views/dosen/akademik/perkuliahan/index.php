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
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                      <tr>
                                        <th style="width:30%">Nama Dosen</th>
                                        <td>: <?=getDataRow('data_dosen',['username'=>session()->get('akun_username')])['Nama_Dosen']?></td>
                                      </tr>
                                      <tr>
                                        <th>NIY</th>
                                        <td>: <?=getDataRow('data_dosen',['username'=>session()->get('akun_username')])['NIY']?></td>
                                      </tr>
                                      <tr>
                                        <th>NIDN / NUPN</th>
                                        <td>: <?=getDataRow('data_dosen',['username'=>session()->get('akun_username')])['NIDN_NUPN']?></td>
                                      </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-4 float-right">Tahun Akademik</label>
                                    <div class="col-sm-8">
                                        <select name="tahun_akademik" id="tahun_akademik" class="form-control form-control-sm select2" onchange="reload_table()" style="width: 100%;">
                                            <option></option>
                                            
                                            <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                                $tAktif = (!empty(getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']))?getDataRow('tahun_akademik', ['aktif' => 'y'])['kode']:'';
                                                foreach ($tahunAkademik as $key ) {
                                            ?>
                                            <option value="<?=$key->kode?>" <?=(!empty($tAktif) && $tAktif==$key->kode)?'selected':''?>><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                            <?php    }    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    </form>
                
            </div>
            <!--        
            <div class="card-footer">
                
                <a role="button" class="btn btn-primary btn-sm" title="Update Jadwal" data-palcement="top"  href="javascript:void(0)" onclick="show_modal_jadwal()">
                    <i class="fa fa-sync"></i> Update Jadwal
                </a>
                
                <a role="button" class="btn btn-primary btn-sm" title="Ekspor Data" data-palcement="top"  href="javascript:void(0)" onclick="ekspor()">
                    <i class="fa fa-download"></i> Ekspor Data
                </a>
            </div>-->
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
                <table id="data" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" ></th>
                            <th class="text-center">No</th>
                            
                            <th class="text-center">Mata Kuliah</th>
                            <th class="text-center">SKS</th>
                            <th class="text-center">Dosen</th>
                            <th class="text-center">Pelaksanaan</th>
                            <th class="text-center">Prodi</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">SMT</th>
                            <th class="text-center">Hari</th>
                            <th class="text-center">Jam</th>
                            <th class="text-center">R</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
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
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Dosen</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="kd_kelas_perkuliahan" name="kd_kelas_perkuliahan" />
                            <select name="Kd_Dosen" id="Kd_Dosen" class="form-control select2" style="width:100%">
    						                	
    						</select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Hari</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('H_Jadwal', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="H_Jadwal" style="width:100%"', null, null, ['opt_group' => 'hari', 'is_aktif' => 'Y']);
                            ?>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jam</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Jam_Jadwal', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="Jam_Jadwal" style="width:100%"', null, null, ['opt_group' => 'jam_kuliah', 'is_aktif' => 'Y']);
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Ruang</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('R_Jadwal', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="R_Jadwal" style="width:100%"', null, null, ['opt_group' => 'ruang_kuliah', 'is_aktif' => 'Y']);
                            ?>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Pelaksanaan</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Pelaksanaan', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Pelaksanaan" style="width:100%"', null, null, ['opt_group' => 'pelaksanaan_kuliah', 'is_aktif' => 'Y']);
                            ?>
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


<script>
var table;
$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    
    table = $('#data').DataTable({
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
            "url": "<?php echo site_url("akademik/$controller/ajaxList") ?>",
            "type": "POST",
            "data": function(data) {
                data.tahun_akademik = $('#tahun_akademik').val();
                data.kd_dosen = "<?=getDataRow('data_dosen',['username'=>session()->get('akun_username')])['Kode']?>";
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

function show_modal_jadwal() {
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		$('#jadwalModal').modal();
			
	}
	else
	{
		Swal.fire({
			title: "Ooooppsss....!",
			text: "Silahkan Pilih Mata Kuliah!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function ekspor() {
    var kd_tahun = $('#tahun_akademik option:selected').val();
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
    				data: {id:list, kd_tahun:kd_tahun},
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
    					alert('Gagal Membuat Data LJK');
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
    var dosen = $('#dosen option:selected').val();
    var H_Jadwal = $('#H_Jadwal option:selected').val();
    var jam = $('#jam option:selected').val();
    var ruang_kuliah = $('#ruang_kuliah option:selected').val();
    var pelaksanaan_kuliah = $('#pelaksanaan_kuliah option:selected').val();
    
    var list = [];
    $('.data-check:checked').each(function(){
        list.push(this.value);
    })
    if(list.length >0){
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Memeperbarui data "+list.length+" Matakuliah ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            allowOutsideClick: false
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/simpanJadwal");?>",
                    type: "post",
                    data: {id_distribusi_mk:list, dosen:dosen, H_Jadwal:H_Jadwal, jam:jam, ruang_kuliah:ruang_kuliah, pelaksanaan_kuliah:pelaksanaan_kuliah},
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
                        	$('#jadwalModal').modal('hide');
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

function edit(kd_kelas_perkuliahan) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("akademik/$controller/getData");?>",
        data: "id=" + kd_kelas_perkuliahan,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#jadwalModal').modal('show');
                $('#exampleModalLabelEdit').text('Edit Jadwal');
                $.each(response.data, function(key, value) {
                    if ($('#' + key).is('.select2')) {
                        if( key == 'Kd_Dosen'){
                            
                            var newOption = new Option(value, value, true, true);
                            $('#' + key).append(newOption).trigger('change');
                        }else{
                            $('#' + key).val(value).trigger('change');
                        }
                            
                    } else {
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

</script>
<?=$this->endSection();?>