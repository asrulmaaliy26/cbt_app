<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
    		                            <?php
                                            echo cmb_dinamis('th_angkatan', 'db_data_diri_mahasiswa', 'th_angkatan', 'th_angkatan', null, null, 'id="th_angkatan" onchange="reload_table()" style="width: 100%;"', 'th_angkatan', 'th_angkatan DESC');
                                        ?>
    		                        </div>
                                </div>
                            	<div class="col-md-3">
                                    <div class="form-group">
                                        <label>Prodi:</label>
                                        <?php
                                            echo cmb_dinamis('prodi', 'prodi', 'singkatan', 'singkatan', null, null, 'id="prodi" style="width: 100%;" onchange="reload_table()"');
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                	<div class="form-group">
                                        <label>Kelas</label>
    		                            <?php
                                            echo cmb_dinamis('kelas', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="kelas" onchange="reload_table()" style="width: 100%;"', null, null, ['opt_group' => 'program_kelas']);
                                        ?>
    		                        </div>
                                </div>
                                <!--
                                <div class="col-md-2 mt-4">
                                    <div class="pt-2">
        	                            <a role="button" class="btn btn-success " title="Tambah" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">
                                            <i class="fa fa-plus"></i> Tambah
                                        </a>
                                    </div>
                                </div>
                                -->
                            </div>
                            
                        </div>
                    </form>
                
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
                <table id="data" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" ></th>
                            <th class="text-center">Angkatan</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">NIM</th>
                            <th class="text-center">Program</th>
                            <th class="text-center">Prodi</th>
                            <th class="text-center">Kelas</th>
                            <!--<th class="text-center">SMT</th>-->
                            <th class="text-center">Status</th>
                            <!--<th class="text-center">Aksi</th>-->
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
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
    $('[data-mask]').inputmask();
    
    table = $('#data').DataTable({
        "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(1).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    			$('td', row).eq(5).addClass('text-center');
    			$('td', row).eq(6).addClass('text-center');
    			$('td', row).eq(7).addClass('text-center');
    		},
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("masterdata/$controller/ajaxList") ?>",
            "type": "POST",
            "data": function(data) {
                data.prodi = $('#prodi').val();
                data.th_angkatan = $('#th_angkatan').val();
                data.kelas = $('#kelas').val();
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

function hapus(id) {
    //var link = "<?=site_url("masterdata/$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Data akan dihapus permanen!",
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
                url: "<?php echo site_url("masterdata/$controller");?>",
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

function edit(id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("masterdata/$controller/getData");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#tambahModal').modal('show');
                $('#exampleModalLabel').text('Edit Data Dosen / Pegawai');
                $.each(response.data, function(key, value) {
                    if (key != "foto") {
                        $('#' + key).val(value);
                        if ($('#' + key).is('.select2')) {
                            
                                $('#' + key).val(value).trigger('change');
                            
                        }
                    } else if (key == "foto") {
                        if(value != null){
                            $('#pic').attr('src', "<?=base_url()?>/" + value);
                        }
                    }
                    if(key == 'username' || key == 'Kode'){
                        $('#' + key).attr('readonly',true);
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

    var data = new FormData($("#form_tambah")[0]);
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
                processData: false,
                contentType: false,
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
<?=$this->endSection();?>