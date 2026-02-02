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
                                <div class="col-md-3">
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
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Hari</label>
                                        <?php
                                            echo cmb_dinamis('hari', 'ref_option', 'opt_val', 'opt_val', null, null, 'id="hari"  style="width: 100%;" onchange="reload_table()"', null, null, ['opt_group' => 'hari']);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(2).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    			$('td', row).eq(8).addClass('text-center');
    			$('td', row).eq(9).addClass('text-center');
    			$('td', row).eq(10).addClass('text-center');
    			$('td', row).eq(11).addClass('text-center');
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
            "url": "<?php echo site_url("akademik/$controller/ajaxListPerkuliahanMahasiswa") ?>",
            "type": "POST",
            "data": function(data) {
                data.tahun_akademik = $('#tahun_akademik').val();
                data.id_data_diri = "<?=$id_data_diri?>";
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