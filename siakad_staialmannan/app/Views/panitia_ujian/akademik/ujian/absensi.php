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
                                        <select name="tahun_akademik" id="tahun_akademik" class="form-control select2" style="width: 100%;">
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
                                            echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'kode_prodi_kop', null, null, 'id="prodi" style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Kelas</label>
                                        <select name="kelas" id="kelas" class="form-control select2" style="width: 100%;">
                                            <option></option>
                                            <option value="1">PA</option>
                                            <option value="0">PI</option>
                                            <option value="2">Kelas Siang</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
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
                    							<option value="9"> 9 </option>
                    							<option value="10"> 10 </option>
                    							<option value="11"> 11 </option>
                    							<option value="12"> 12 </option>
                    							<option value="13"> 13 </option>
                    							<option value="14"> 14 </option>
                    					</select>
    		                        </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label for="tanggal" >Tanggal</label>
                                        <div class="input-group date " id="reservationdate" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" id="tanggal" data-toggle="datetimepicker" name="tanggal" data-target="#reservationdate" placeholder="DD-MM-YYYY" value="<?=date('d-m-Y')?>"/>
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                
                                
                            </div>
                            
                        <!--</div>-->
                    </form>
                
            </div>
                    
            <div class="card-footer">
                
                <a role="button" class="btn btn-primary btn-sm" title="Ekspor Data" data-palcement="top"  href="javascript:void(0)" onclick="getDataMahasiswa()">
                    <i class="fa fa-download"></i> Lihat Data
                </a>
                
                
                <a role="button" class="btn btn-success btn-sm"  data-palcement="top"  href="javascript:void(0)" onclick="hadirAll()">
                    <i class="fa fa-check"></i> Hadir
                </a>
                <a role="button" class="btn btn-danger btn-sm"  data-palcement="top"  href="javascript:void(0)" onclick="tidakHadirAll()">
                    <i class="fa fa-times"></i> Tidak Hadir
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
                                <th class="text-center">Nama</th>
                                <th class="text-center">NIM</th>
                                <th class="text-center">Prodi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Lunas Pembayaran UAS?</th>
                                <th class="text-center">Hadir?</th>
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
    ganti_semester();
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
    
    $('#reservationdate').datetimepicker({
        defaultDate:'now',
        format: 'DD-MM-YYYY',

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

function getDataMahasiswa(){
    var tahun_akademik = $('#tahun_akademik option:selected').val();
    var prodi = $('#prodi option:selected').val();
    var kelas = $('#kelas option:selected').val();
    var semester = $('#semester option:selected').val();
    var tanggal = $('#tanggal').val();
    
    if(prodi == '' || kelas == '' || semester == '' || tahun_akademik == '' || tanggal == ''){
        Swal.fire({
            icon: 'warning',
            title:"pilih tahun akademik, prodi, kelas, semester dan tanggal!!",
            confirmButtonText: 'OK',
            allowOutsideClick: false,
        })
    }else{
        loadDataMahasiswa();
    }
        
}

function loadDataMahasiswa(){
    
    $('#data').DataTable({
        "createdRow": function (row, data, index) {
			$('td', row).eq(0).addClass('text-center');
			$('td', row).eq(1).addClass('text-center');
			$('td', row).eq(4).addClass('text-center');
			$('td', row).eq(5).addClass('text-center');
			$('td', row).eq(6).addClass('text-center');
			$('td', row).eq(7).addClass('text-center');
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
            "url": "<?php echo site_url("akademik/$controller/loadDataMahasiswa") ?>",
            "type": "POST",
            "data": function(data) {
                
                data.kode_kelas = $('#tahun_akademik option:selected').val()+$('#prodi option:selected').val()+$('#kelas option:selected').val()+$('#semester option:selected').val();
                
                data.tanggal = $('#tanggal').val();
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });

    $('th input[type=checkbox], td input[name=check]').prop('checked', false);
                        
    var active_class = 'active';
    $('#data_mhs > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header
        
        $(this).closest('table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) $(row).addClass(active_class).find('input[name=check]').eq(0).prop('checked', true);
            else $(row).removeClass(active_class).find('input[name=check]').eq(0).prop('checked', false);
        });
    });
      
}

function hadir(id_his_pdk, nama, tanggal) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengubah status kehadiran "+nama+" ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        allowOutsideClick: false
    }).then((result) => {
        //window.location.href = link;
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/$metode");?>",
                type: "post",
                data: "aksi=hadir&id_his_pdk=" + id_his_pdk+"&tanggal="+tanggal,
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
                       loadDataMahasiswa();
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

function hadirAll() {
    var tanggal = $('#tanggal').val();
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
        Swal.fire({
            title: 'Are you sure?',
            text: "Mengubah kehadiran "+list.length+" mahasiswa ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            allowOutsideClick: false
        }).then((result) => {
            //window.location.href = link;
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/$metode");?>",
                    type: "post",
                    data: {id_his_pdk:list, aksi:"hadirAll", tanggal:tanggal},
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
                           loadDataMahasiswa();
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
			text: "Pilih mahasiswa!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

function tidak_hadir(id_his_pdk, nama, tanggal) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengubah status kehadiran "+nama+" ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/$metode");?>",
                type: "post",
                data: "aksi=tidak_hadir&id_his_pdk=" + id_his_pdk+"&tanggal="+tanggal,
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
                        loadDataMahasiswa();
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

function tidakHadirAll() {
    var tanggal = $('#tanggal').val();
	var list = [];
	//var soal = 'ini adalah soal';
	$('.data-check:checked').each(function(){
		list.push(this.value);
	})
	if(list.length>0)
	{
        Swal.fire({
            title: 'Are you sure?',
            text: "Mengubah kehadiran "+list.length+" mahasiswa ??",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            allowOutsideClick: false
        }).then((result) => {
            //window.location.href = link;
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url("akademik/$controller/$metode");?>",
                    type: "post",
                    data: {id_his_pdk:list, aksi:"tidakHadirAll", tanggal:tanggal},
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
                           loadDataMahasiswa();
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
			text: "Pilih mahasiswa!!",
			icon: "error",
			allowOutsideClick: false
		});
	}
}

</script>
<?=$this->endSection();?>