<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">
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
		                                    <a role="button" class="btn btn-success" title="Tambah Ujian" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahUjianModal">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <!--
                                            <a role="button" class="btn btn-success" title="Tambah User" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#getUserModal">
                                                <i class="fa fa-plus"></i>
                                            </a>
		                                    -->
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

        <div class="card-body">
        	<table id="data" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="col-1 text-center align-middle">No.</th>
                        <th class="col-1 text-center align-middle">Kode Ujian</th>
                        <th class="col-1 text-center align-middle">Tahun Akademik</th>
                        <th class="col-1 text-center align-middle">Semester</th>
                        <th class="col-3 text-center align-middle">Jenis Ujian</th>
                        <th class="col-1 text-center align-middle">Status Ujian</th>
                        <th class="col-1 text-center align-middle">Akses Mhs</th>
                        <th class="col-1 text-center align-middle">Cek Pembayaran</th>
                        <th class="col-1 text-center align-middle">Absensi MHS</th>
                        <th class="col-1 text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        foreach ($record as $value) {
                            
                    ?>
                    <tr>
                        <td class="text-center align-middle"><?=$nomor++;?></td>
                        <td class="text-center align-middle"><?=$value['id'];?></td>
                        <td class="text-center align-middle"><?=$value['tahun'];?></td>
                        <td class="text-center align-middle"><?=$value['semester']== 1?'Gasal':'Genap';?></td>
                        <td class="text-center align-middle">
                        	<?=($value['jenis_ujian'] == 'UTS') ? 'Ujian Tengah Semester' : (($value['jenis_ujian'] == 'UAS')?'Ujian Akhir Semester':$value['jenis_ujian'])?>
                        </td>
                        <td class="text-center align-middle">
                            <?=$value['status']== 1?'<a onclick="deactivate('."'".$value['id_ujian']."','status'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$value['id_ujian']."','status'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';?>
                        </td>
                        <td class="text-center align-middle">
                            <?=$value['stts_ujian']== 1?'<a onclick="deactivate('."'".$value['id_ujian']."','stts_ujian'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$value['id_ujian']."','stts_ujian'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';?>
                        </td>
                        <td class="text-center align-middle">
                            <?=$value['cek_spp']== 1?'<a onclick="deactivate('."'".$value['id_ujian']."','cek_spp'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-check fa-lg text-green" ></i></a>':'<a onclick="activate('."'".$value['id_ujian']."','cek_spp'".'); return false;" role="button" data-placement="top" title="Klik untuk mengubah"><i class="fas fa-times fa-lg text-red" ></i></a>';?>
                        </td>
                        <td class="text-center align-middle">
                            <a href="<?=site_url()?>/akademik/ujian/absensi?id=<?=urlencode(base64_encode($value['id_ujian']))?>" target="_blank" role="button" class="btn btn-xs btn-primary" data-placement="top" title="Detail">Absensi MHS</i></a>
                        </td>
                        <td class="text-center align-middle">
                            <a href="javascript:void(0)" role="button" class="btn btn-xs btn-warning" data-placement="top" title="Edit" onclick="edit(<?=$value['id_ujian'];?>)"><i class="fa fa-edit"></i></a>
                            <a href="<?=site_url()?>/akademik/ujian/detail?id=<?=urlencode(base64_encode($value['id_ujian']))?>" role="button" class="btn btn-xs btn-primary" data-placement="top" title="Detail"><i class="fa fa-eye"></i></a>
                            <a onclick="hapus(<?=$value['id_ujian'];?>)" role="button" role="button" class="btn btn-xs btn-danger" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></a>
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
<div class="modal fade" id="tambahUjianModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_group" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Ujian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="id_ujian" name="id_ujian" />
                            <select name="kd_tahun" id="kd_tahun" class="form-control select2" style="width: 100%;">
                                <option></option>
                                
                                <?php $tahunAkademik = dataDinamis('tahun_akademik', null, 'kode DESC'); 
                                    
                                    foreach ($tahunAkademik as $key ) {
                                ?>
                                <option value="<?=$key->kode?>" ><?=$key->tahunAkademik?> <?=$key->semester == '1'?'Gasal':'Genap';?></option>
                                <?php    }    ?>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jenis Ujian</label>
                        <div class="col-sm-9">
                            <select name="jenis_ujian" id="jenis_ujian" class="form-control select2" style="width: 100%;">
                                <option></option>
                                <option value="UTS" >UTS</option>
                                <option value="UAS" >UAS</option>
                                
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Status Ujian</label>
                        <div class="col-sm-9">
                            <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                <option></option>
                                <option value="0" >Tidak Aktif</option>
                                <option value="1" >Aktif</option>
                                
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Akses Mahasiswa</label>
                        <div class="col-sm-9">
                            <select name="stts_ujian" id="stts_ujian" class="form-control select2" style="width: 100%;">
                                <option></option>
                                <option value="0" >Tidak Aktif</option>
                                <option value="1" >Aktif</option>
                                
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Cek Pembayaran</label>
                        <div class="col-sm-9">
                            <select name="cek_spp" id="cek_spp" class="form-control select2" style="width: 100%;">
                                <option></option>
                                <option value="0" >Tidak Aktif</option>
                                <option value="1" >Aktif</option>
                                
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Informasi</label>
                        <div class="col-sm-9">
                            <textarea class="form-control summernote" rows="10" id="informasi" name="informasi">
                                
                            </textarea>
                            <div class="invalid-feedback">

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
<!-- Summernote -->
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-file.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-ext-rtl.js"></script>

<script>

$(function() {
    $('.select2').select2({
        placeholder: "---- Semua ----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });

    $('#tambahUjianModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('.summernote').summernote('reset');
    });
    
    $('.summernote').summernote({
        dialogsInBody: true,
        dialogsFade: true,
        tabsize: 2,
        height: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['ltr', 'rtl', 'link', 'picture', 'video', 'file']],
            ['view', ['undo', 'redo', 'fullscreen']],
        ],
        callbacks: {
            
            onImageUpload: function(image) {

                uploadImage(image[0]);
            },
            onMediaDelete: function(target) {
                deleteImage(target[0].src);
            },
            onFileUpload: function(file) {
                myOwnCallBack(file[0]);
            }
        }
    });
    
})

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
                url: "<?php echo site_url("akademik/$controller");?>",
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
                       location.reload();
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
                url: "<?php echo site_url("akademik/$controller");?>",
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
                    //$(".overlay").css("display","none");
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    }).then(() => {
                        location.reload();
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

function hapus(id) {
    //var link = "<?=site_url("$controller/$metode/?aksi=hapus&id=")?>" + id;
    Swal.fire({
        title: 'Are you sure?',
        text: "Data akan dihapus!",
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
                    Swal.fire({
                        icon: data.msg,
                        title: data.pesan,
                        allowOutsideClick: false,
                    }).then(() => {
                        location.reload();
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

function simpan() {
    var data = new FormData($("#form_group")[0]);
    data.append('aksi', "simpan");
    $('#form_group').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller");?>",
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
                        $('#tambahUjianModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        });
                    }  else if (data.msg == 'warning') {

                        $.each(data.validation, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).parents('.form-group').find('.invalid-feedback')
                                .text(value);
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data gagal disimpan',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        })
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

function edit(id) {
    $.ajax({
        type: "post",
        url: "<?php echo site_url("akademik/$controller/getData");?>",
        data: "id=" + id,
        dataType: 'json',
        success: function(response) {
            if (response.msg) {
                $('#tambahUjianModal').modal('show');
                $('#exampleModalLabelEdit').text('Edit Data Ujian');
                $.each(response.data, function(key, value) {
                    if ($('#' + key).is('.select2')) {
                        $('#' + key).val(value).trigger('change');
                    }else if ($('#' + key).is('.summernote')) {
                            $('#' + key).summernote('code', value);
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

function uploadImage(image) {
    var data = new FormData();
    data.append("image", image, image.name);
    $.ajax({
        url: "<?php echo site_url('summernote/upload_image')?>",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "POST",
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
        success: function(url) {
            $('.summernote').summernote("insertImage", url);
            Swal.close();
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

function deleteImage(src) {
    $.ajax({
        data: {
            src: src
        },
        type: "POST",
        url: "<?php echo site_url('summernote/delete_image')?>",
        cache: false,
        success: function(response) {
            console.log(response);
        }
    });
}

function myOwnCallBack(file) {
    let data = new FormData();
    data.append("file", file, file.name);
    $.ajax({
        data: data,
        type: "POST",
        url: "<?php echo site_url('summernote/upload_file')?>", //Your own back-end uploader
        cache: false,
        contentType: false,
        processData: false,
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
        success: function(url) {
            
            let listMimeImg = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/gif', 'image/svg'];
            let listMimeAudio = ['audio/mpeg', 'audio/ogg', 'audio/mp3'];
            let listMimeVideo = ['video/mpeg', 'video/mp4', 'video/webm'];
            let listMimePdf = ['application/pdf'];
            let elem;

            if (listMimeImg.indexOf(file.type) > -1) {
                //Picture
                $('.summernote').summernote('editor.insertImage', url);
            } else if (listMimeAudio.indexOf(file.type) > -1) {
                //Audio
                elem = document.createElement("audio");
                elem.setAttribute("src", url);
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('.summernote').summernote('editor.insertNode', elem);
            } else if (listMimeVideo.indexOf(file.type) > -1) {
                //Video
                elem = document.createElement("video");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "300");
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('.summernote').summernote('editor.insertNode', elem);
            } else if (listMimePdf.indexOf(file.type) > -1) {
                //Video
                elem = document.createElement("iframe");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "600");
                elem.setAttribute("allow", "autoplay");
                $('.summernote').summernote('editor.insertNode', elem);
            } else {
                //Other file type
                var node;
                node = document.createElement("a");
                let linkText = document.createTextNode(file.name);
                node.appendChild(linkText);
                node.title = file.name;
                node.href = url;
                $('.summernote').summernote('insertNode', node);
            }
            Swal.close();
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

</script>
<?=$this->endSection();?>