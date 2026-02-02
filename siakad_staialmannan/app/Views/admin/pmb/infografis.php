<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!--
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">-->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Filter Data</h3>
                        </div> <!-- /.card-body -->
                        <div class="card-body pad ">
                            <form class="form-horizontal">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row ">
                                            <label class="col-sm-4 col-form-label">Is Aktif</label>
                                            <div class="col-sm-8">
                                                <select name="is_aktif2" id="is_aktif2" class="form-control select2" style="width:100%;">

                                                    <option value="Y">Aktif</option>
                                                    <option value="N">Inaktif</option>
                                                </select>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group row ">
                                            <label class="col-sm-4 col-form-label">Is Deleted</label>
                                            <div class="col-sm-8">
                                                <select name="is_deleted" id="is_deleted" class="form-control select2"  style="width:100%;">

                                                    <option value="1">Tidak</option>
                                                    <option value="2">Ya</option>
                                                </select>

                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">

                            <a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="reload_table()">Load
                                Data</a>
                            <a class="btn btn-sm btn-success" role="button" href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">Tambah</a>

                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                Data <?=$templateJudul;?>
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="data" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Image</th>
                                        <th>Is Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->


<!-- Modal -->
<div class="modal fade" id="tambahModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_simpan" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Slider Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="id" name="id" />
                            <input type="text" class="form-control" id="slider_title" name="slider_title" />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Slider Subtitle</label>
                        <div class="col-sm-9">

                            <input type="text" class="form-control" id="slider_subtitle" name="slider_subtitle" />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Slider Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="10" id="slider_description"
                                name="slider_description"></textarea>

                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Is Aktif</label>
                        <div class="col-sm-9">
                            <select name="is_aktif" id="is_aktif" class="form-control select2">
                                <option></option>
                                <option value="Y"> Ya </option>
                                <option value="N"> Tidak </option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Brosur Jenjang</label>
                        <div class="col-sm-9">
                            <select name="jenjang" id="jenjang" class="form-control select2">
                                <option></option>
                                <option value="S1"> S1 </option>
                                <option value="S2"> S2 </option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Slider Btn Text</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="slider_btntext" name="slider_btntext" />

                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>


                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Slider Link</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="slider_link" name="slider_link" />

                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>


                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Slider Image</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" class="custom-file-input" id="slider_img"
                                        name="slider_img" oninput="pic.src=window.URL.createObjectURL(this.files[0])"> >
                                    <label class="custom-file-label" for="slider_img">Choose file</label>
                                </div>

                            </div>

                            <div id="slider_img_invalid" class="invalid-feedback">

                            </div>

                            <div class="col-sm-4 pt-2">
                                <div class="position-relative">
                                    <img id="pic" class="img-fluid" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn_simpan" onclick="simpan()">Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<!--</div> End Overlay-->


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
        $(this).find('#pic').removeAttr('src');
        $(this).find('#slider_img_invalid').text('');

    });

    table = $('#data').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("$controller/ajaxListInfografis") ?>",
            "type": "POST",
            "data": function(data) {
                data.is_aktif = $('#is_aktif2').val();
                data.is_deleted = $('#is_deleted').val();
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ]
    });
})

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax 
}

function simpan() {
    //var form = $('#form_simpan');
    var data = new FormData($("#form_simpan")[0]);
    $('#form_simpan').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
        /*customClass: {
			      confirmButton: 'btn btn-primary btn-lg',
			      cancelButton: 'btn btn-danger btn-lg',
			      loader: 'custom-loader'
			    },
			    loaderHtml: '<div class="spinner-border text-primary"></div>',
			    preConfirm: () => {
			      Swal.showLoading()
			      return new Promise((resolve) => {
			        setTimeout(() => {
			          resolve(true)
			        }, 3000)
			      })
			    }*/
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/tambahInfografis");?>",
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
                    if (data.msg == 'success') {
                        reload_table();
                        $('#tambahModal').modal('hide');
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

                    } else if (data.msg == 'invalid') {

                        $.each(data.validation, function(key, value) {
                            if (key != slider_img) {
                                $('#' + key).addClass('is-invalid');

                                $('#' + key).parents('.form-group').find(
                                        '.invalid-feedback')
                                    .text(value);
                            } else {
                                $('#' + key).addClass('is-invalid');

                                $('#slider_img_invalid').text(value);
                            }
                        });

                    } else {
                        reload_table();
                        $('#tambahModal').modal('hide');
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
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Wrong!!',
                        text:thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    })

}

function hapus(id) {
    //var link = "<?=site_url("admin/$controller/$metode/?aksi=hapus&id=")?>" + id;
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
                url: "<?php echo site_url("$controller/hapusInfografis");?>",
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
                        table.ajax.reload(null, false);
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
                            title: "Data sudah dipindahkan ke tempat sampah"
                        })

                    } else {
                        table.ajax.reload(null, false);
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Something Wrong!!',
                        text:thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
        }
    });
}

function edit(id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("$controller/getDataInfografis");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#tambahModal').modal('show');
                $('#exampleModalLabel').text('Edit Slider');
                $.each(response.data, function(key, value) {

                    if (key != "slider_img") {
                        if ($('#' + key).is('.select2')) {
                            $('#' + key).val(value).trigger('change');
                        } else if ($('#' + key).is('textarea')) {
                            $('#' + key).text(value);
                        } else {
                            $('#' + key).val(value);
                        }
                    } else if (key == "slider_img") {
                        $('#pic').attr('src', "<?=base_url()?>/" + value);
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