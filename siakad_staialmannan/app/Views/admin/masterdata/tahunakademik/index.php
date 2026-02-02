<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<section class="content">
    <div class="card">

        <div class="card-body">
                <form action="" method="get">
                    <div class="col-md-10 offset-md-1">
                        <div class="row mb-3">
                        	<div class="col-md-2">
                                <div class="form-group">
                                    <label>Per Hlm:</label>
                                    <select name="jml_baris" id="jml_baris" class="select2" style="width: 100%;">
                                        
                                        <option value="10" <?=(isset($jml_baris) && $jml_baris==10)?'selected':''?>>10</option>
                                        <option value="20" <?=(isset($jml_baris) && $jml_baris==20)?'selected':''?>>20</option>
                                        <option value="50" <?=(isset($jml_baris) && $jml_baris==50)?'selected':''?>>50</option>
                                        <option value="100" <?=(isset($jml_baris) && $jml_baris==100)?'selected':''?>>100</option>
                                        <option value="200" <?=(isset($jml_baris) && $jml_baris==200)?'selected':''?>>200</option>
                                        <option value="500" <?=(isset($jml_baris) && $jml_baris==500)?'selected':''?>>500</option>

                                    
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-7">
                            	<div class="form-group">
                                    <label>Kata Kunci:</label>
		                            <div class="input-group ">
		                                <input name="kata_kunci" id="kata_kunci" type="search" class="form-control " placeholder="Masukkan kata kunci" value="<?=$kata_kunci;?>">
		                                <div class="input-group-append">
		                                    <button type="submit" class="btn btn-default">
		                                        <i class="fa fa-search"></i>
		                                    </button>
		                                    <a role="button" class="btn btn-success" title="Tambah" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">
                                                <i class="fa fa-plus"></i>
                                            </a>
		                                </div>
		                            </div>
		                        </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
            
        </div>
    </div>
    <div class="card">

        <div class="card-body pad table-responsive">
        	<table id="data" class="table table-sm table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="col-1 text-center"><input type="checkbox" ></th>
                        <th class="col-3 text-center">Tahun Akademik</th>
                        <th class="col-3 text-center">Semester</th>
                        <th class="col-3 text-center">Is Aktif</th>
                        <th class="col-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        foreach ($record as $value) {
                            
                    ?>
                    <tr>
                        <td class="text-center"><input type="checkbox" class="data-check" name="check" value="<?=$value['id_ta']?>" /></td>
                        <td><?=$value['tahunAkademik'];?></td>
                        <td><?=$value['semester']==1?'Gasal':'Genap';?></td>
                        <td class="text-center">
                            <?php if($value['aktif'] == 'n'){ ?>
                        		<a onclick="activate(<?=$value['id_ta'];?>); return false;" role="button" data-placement="top" title="Klik untuk mengaktifkan"><i class="fas fa-times fa-lg text-red" ></i></a>
                        	<?php } else { ?>
                        		<a onclick="deactivate(<?=$value['id_ta'];?>); return false;" role="button" data-placement="top" title="Klik untuk menonaktifkan"><i class="fas fa-check fa-lg text-green" ></i></a>
                        	<?php } ?>
                        </td>
                        <td class="text-center">
                            <a href="javascript:void(0)" role="button" class="btn btn-xs btn-warning" data-placement="top" title="Edit" onclick="edit(<?=$value['id_ta'];?>)"><i class="fa fa-edit"></i></a>
                            <a onclick="hapus(<?=$value['id_ta'];?>)" role="button" role="button" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <?php
                echo $pager->links('dt','datatable');
            ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="tambahModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_group" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tahun Akademik</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="id_ta" name="id_ta" />
                            <input type="text" class="form-control" id="tahunAkademik" name="tahunAkademik" data-inputmask='"mask": "9999/9999"' data-mask />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Semester</label>
                        <div class="col-sm-9">

                            <select name="semester" id="semester" class="form-control select2">
                                <option></option>
                                <option value="1"> Ganjil</option>
                                <option value="2"> Genap </option>
                            </select>
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

$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    $('[data-mask]').inputmask();
    $('#tambahModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
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

function hapus(id_ta) {
    //var link = "<?=site_url("masterdata/$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Data akan dipindahkan ke recycle bin!",
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
                data: "aksi=hapus&id=" + id_ta,
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
                            title: 'Tahun akademik berhasil dihapus',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
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

function edit(id_ta) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("masterdata/$controller/getData");?>",
        data: "id=" + id_ta,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#tambahModal').modal('show');
                $('#exampleModalLabelEdit').text('Edit Tahun Akademik');
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

    var data = $('#form_group').serialize();
    $('#form_group').find('.invalid-feedback').text('');
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
                            location.reload();
                        })
                    } else if (data.msg == 'invalid'){
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

function activate(id_ta) {
    
    Swal.fire({
        title: 'Are you sure?',
        text: "Mengaktifkan tahun akademik!",
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
                url: "<?php echo site_url("masterdata/$controller");?>",
                type: "post",
                data: "aksi=activate&id=" + id_ta,
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
                            title: 'Tahun akademik berhasil diaktifkan',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data gagal diaktivasi',
                            allowOutsideClick: false,
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

function deactivate(id_ta) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Tahun akademik akan dinonaktifkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, deactivate it!',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("masterdata/$controller");?>",
                type: "post",
                data: "aksi=deactivate&id=" + id_ta,
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
                            title: 'Tahun akademik berhasil dinonaktifkan',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Data gagal diupdate',
                            allowOutsideClick: false,
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
<?=$this->endSection();?>