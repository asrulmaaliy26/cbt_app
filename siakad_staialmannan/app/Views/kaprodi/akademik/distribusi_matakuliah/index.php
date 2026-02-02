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
                                        <label>Tahun</label>
                                        <select name="tahun_akademik" id="tahun_akademik" class="form-control select2" onchange="reload_table()" style="width: 100%;">
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
                            	<div class="col-md-2">
                                    <div class="form-group">
                                        <label>Prodi</label>
                                        <?php
                                            if(session()->get('akun_level') == 'Fakultas'){
                                                $fakultas = getDataRow('auth_groups_users', ['group_id' => session()->get('akun_level_id'), 'user_id' => session()->get('akun_id')])['bagian'];
                                                echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', null, null, 'id="prodi" style="width: 100%;" onchange="reload_table()"', null, null, ['sing_fak' => $fakultas]);
                                            }
                                            
                                            if(session()->get('akun_level') == 'Kaprodi'){
                                                $prodi = getDataRow('auth_groups_users', ['group_id' => session()->get('akun_level_id'), 'user_id' => session()->get('akun_id')])['bagian'];
                                                echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', $prodi, null, 'id="prodi" style="width: 100%;" onchange="reload_table()"', null, null, ['singkatan' => $prodi]);
                                            }
                                            
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <?php
                                            echo cmb_dinamis('kelas', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="kelas"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'program_kelas', 'is_aktif !=' => 'N']);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                	<div class="form-group">
                                        <label>Semester</label>
    		                            <select name="semester" id="semester" class="form-control select2"  onchange="reload_table()" style="width: 100%;">
                                                <option></option>
                                                <option value="1"> 1 </option>
                    							<option value="2"> 2 </option>
                    							<option value="3"> 3 </option>
                    							<option value="4"> 4 </option>
                    							<option value="5"> 5 </option>
                    							<option value="6"> 6 </option>
                    							<option value="7"> 7 </option>
                    							<option value="8"> 8 </option>
                    							<option value="9"> 9 </option>
                    							<option value="10"> 10 </option>
                    							<option value="11"> 11 </option>
                    							<option value="12"> 12 </option>
                    							<option value="13"> 13 </option>
                    							<option value="14"> 14 </option>
                    					</select>
    		                        </div>
                                </div>
                                
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
                                            echo cmb_dinamis('jam_kuliah', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="jam_kuliah"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'jam_kuliah']);
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
                <!--
                <a role="button" class="btn btn-danger btn-sm" title="Hapus Data" data-palcement="top"  href="javascript:void(0)" onclick="hapus_kolektif()">
                    <i class="fa fa-trash"></i> Hapus Data
                </a>
                <a role="button" class="btn btn-warning btn-sm" title="Hapus Data" data-palcement="top"  href="javascript:void(0)" onclick="reset_jadwal()">
                    <i class="fa fa-undo"></i> Reset Jadwal
                </a>
                <a role="button" class="btn btn-warning btn-sm"  data-palcement="top"  href="javascript:void(0)" onclick="generate_kd_perkuliahan()">
                    <i class="fa fa-undo"></i> Generate Kode Kelas Perkuliahan
                </a>
                -->
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
                                <th class="text-center">Kode Feeder</th>
                                <th class="text-center">Mata Kuliah</th>
                                <th class="text-center">SKS</th>
                                <th class="text-center">Prodi</th>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">SMT</th>
                                <th class="text-center">Dosen</th>
                                <th class="text-center">Hari</th>
                                <th class="text-center">Jam</th>
                                <th class="text-center">R</th>
                                <!--<th class="text-center">Aksi</th>-->
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
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Dosen</label>
                        <div class="col-sm-9">
                            
                            <select name="dosen" id="dosen" class="form-control select2" style="width:100%">
    						                	
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
                                echo cmb_dinamis('jam', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="jam" style="width:100%"', null, null, ['opt_group' => 'jam_kuliah', 'is_aktif' => 'Y']);
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Ruang</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('ruang_kuliah', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="ruang_kuliah" style="width:100%"', null, null, ['opt_group' => 'ruang_kuliah', 'is_aktif' => 'Y']);
                            ?>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Pelaksanaan</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('pelaksanaan_kuliah', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="pelaksanaan_kuliah" style="width:100%"', null, null, ['opt_group' => 'pelaksanaan_kuliah', 'is_aktif' => 'Y']);
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
    ganti_semester();
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
    
    // Autocomplete Select2
    $('#dosen').select2({
        placeholder: '--- Ketikan Nama Dosen ---',
        minimumInputLength: 3,
        allowClear: true,
        ajax: {
            url: '<?=base_url('admin/globalController/getNamaAutoComplete')?>',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term,
                    page: params.page,
                    tabel: 'data_dosen',
                    field: 'Nama_Dosen',
                    select: 'Kode as id, Nama_Dosen as text, NIY as atribut1',
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
    
    $('#jadwalModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
    });
    
    table = $('#data').DataTable({
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": true,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("akademik/$controller/ajaxList") ?>",
            "type": "POST",
            "data": function(data) {
                data.tahun_akademik = $('#tahun_akademik').val();
                data.prodi = $('#prodi').val();
                data.semester = $('#semester').val();
                data.kelas = $('#kelas').val();
                data.hari = $('#hari').val();
                data.jam_kuliah = $('#jam_kuliah').val();
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

function ganti_semester()
{
    let periode = $('#tahun_akademik option:selected').val();
    if(periode %2 != 0){
	    
        $("#semester option[value='']").prop('disabled',false);
        $("#semester option[value='1']").prop('disabled',false);
        $("#semester option[value='2']").prop('disabled',true);
        $("#semester option[value='3']").prop('disabled',false);
        $("#semester option[value='4']").prop('disabled',true);
        $("#semester option[value='5']").prop('disabled',false);
        $("#semester option[value='6']").prop('disabled',true);
        $("#semester option[value='7']").prop('disabled',false);
        $("#semester option[value='8']").prop('disabled',true);
        $("#semester option[value='9']").prop('disabled',false);
        $("#semester option[value='10']").prop('disabled',true);
        $("#semester option[value='11']").prop('disabled',false);
        $("#semester option[value='12']").prop('disabled',true);
        $("#semester option[value='13']").prop('disabled',false);
        $("#semester option[value='14']").prop('disabled',true);
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
        $("#semester option[value='9']").prop('disabled',true);
        $("#semester option[value='10']").prop('disabled',false);
        $("#semester option[value='11']").prop('disabled',true);
        $("#semester option[value='12']").prop('disabled',false);
        $("#semester option[value='13']").prop('disabled',true);
        $("#semester option[value='14']").prop('disabled',false);
	}
}

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

function hapus(id, matakuliah) {
    //var link = "<?=site_url("akademik/$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: matakuliah+" akan dihapus ??",
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
                url: "<?php echo site_url("akademik/$controller");?>",
                type: "post",
                data: "aksi=hapus&id=" + id,
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
                            title: matakuliah+' berhasil dihapus',
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
                            title: matakuliah+' gagal dihapus'
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

function hapus_kolektif() {
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		Swal.fire({
            title: 'Are you sure?',
            text: "Menghapus data "+list.length+" Matakuliah ??",
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
    				data: {id:list},
    			    url:"<?php echo site_url("akademik/$controller/hapus_kolektif")?>",
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
    				    Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
                        });
    				    /*
    					if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: list.length+' matakuliah berhasil dihapus',
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
                                title: list.length+' gagal dihapus'
                            })
                        }
                        */
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
			text: "Pilih matakuliah yang akan dihapus!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function reset_jadwal() {
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		Swal.fire({
            title: 'Are you sure?',
            text: "Mereset jadwal "+list.length+" Matakuliah ??",
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
    				data: {id:list},
    			    url:"<?php echo site_url("akademik/$controller/reset_jadwal")?>",
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
    				    Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
                        });
    				    /*
    					if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: list.length+' matakuliah berhasil dihapus',
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
                                title: list.length+' gagal dihapus'
                            })
                        }
                        */
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
			text: "Pilih matakuliah yang akan direset!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function generate_kd_perkuliahan() {
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
		
		Swal.fire({
            title: 'Are you sure?',
            text: "generate kode "+list.length+" Matakuliah ??",
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
    				data: {id:list},
    			    url:"<?php echo site_url("akademik/$controller/generate_kd_perkuliahan")?>",
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
    				    Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            allowOutsideClick: false,
                        }).then(() => {
                            table.ajax.reload(null, false);
                        });
    			
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
			text: "Pilih matakuliah!!",
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
    var kd_tahun = $('#tahun_akademik option:selected').val();
    
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
                    data: {id_distribusi_mk:list, dosen:dosen, H_Jadwal:H_Jadwal, jam:jam, ruang_kuliah:ruang_kuliah, pelaksanaan_kuliah:pelaksanaan_kuliah, kd_tahun:kd_tahun},
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

</script>
<?=$this->endSection();?>