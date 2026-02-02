
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$templateJudul?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/select2/css/select2.min.css">
<link rel="stylesheet"
    href="<?=base_url('assets');?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Moment Js -->
<script src="<?=base_url('assets');?>/plugins/moment/moment.min.js"></script>
<!-- Daterange picker -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/toastr/toastr.min.css">
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
    
                    <!-- About Me Box -->
                    <div class="card card-primary card-outline">
                      
                      <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> Matakuliah</strong>
        
                        <p class="text-muted">
                          <?=$perkuliahan['Mata_Kuliah']?>
                        </p>
        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Dosen</strong>
        
                        <p class="text-muted"><?=getDataRow('data_dosen', ['Kode'=>$perkuliahan['Kd_Dosen']])['Nama_Dosen']?></p>
        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Hari</strong>
        
                        <p class="text-muted">
                          <?=$perkuliahan['H_Jadwal']?>
                        </p>
        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Jam</strong>
        
                        <p class="text-muted"><?=$perkuliahan['Jam_Jadwal']?></p>
                        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Ruang</strong>
        
                        <p class="text-muted"><?=$perkuliahan['R_Jadwal']?></p>
                        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Kode Kelas Perkuliahan</strong>
        
                        <p class="text-muted"><?=$perkuliahan['kd_kelas_perkuliahan']?></p>
                        
                        <hr>
        
                        <strong><i class="fas fa-book mr-1"></i> Pelaksanaan</strong>
        
                        <p class="text-muted"><?=(!empty($perkuliahan['Pelaksanaan']))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $perkuliahan['Pelaksanaan']])['opt_val']:'-'?></p>
                        
                        <strong><i class="fas fa-book mr-1"></i> Prodi - Kelas</strong>
        
                        <p class="text-muted"><?php $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Prodi', null,null,null,'Prodi');
                                                    $prod =[]; 
                                                    foreach ($prodi as $key ) {
                                                       $prod[] = $key->Prodi;
                                                    }
                                                    $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Kelas', null,null,null,'Kelas');
                                                    $kls =[]; 
                                                    foreach ($kelas as $key ) {
                                                       $kls[] = $key->Kelas;
                                                    }
                                                    echo implode(" - ", $prod)." (".implode(" - ", $kls).")";
                        ?></p>
                        
                        
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                    
                </div>
                <div class="col-md-9">
                        
                    <div class="card card-primary card-outline">
                        <form  id="form_jurnal" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Hari</label>
                                            <input type="text" class="form-control" id="hari" placeholder="Topik perkuliahan" name="hari" readonly value="<?=hari(date('Y-m-d'))?>" >
                                            
                                            <input type="text" class="form-control" id="kode_kelas_perkuliahan" placeholder="Topik perkuliahan" name="kode_kelas_perkuliahan" readonly hidden value="<?=$perkuliahan['kd_kelas_perkuliahan']?>" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <!--
                                            <input type="text" class="form-control" id="tanggal" placeholder="Topik perkuliahan" name="tanggal" readonly value="<?=date('Y-m-d')?>" >-->
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" onfocusout="getIdHari()" id="tanggal" data-toggle="datetimepicker" name="tanggal" data-target="#reservationdate" placeholder="YYYY-MM-DD" value="<?=date('Y-m-d')?>"/>
                                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Topik</label>
                                    <input type="text" class="form-control " id="topik" placeholder="Topik perkuliahan" name="topik" >
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Metode Perkuliahan</label>
                                    <input type="text" class="form-control " id="metode_kuliah" placeholder="Metode perkuliahan" name="metode_kuliah" >
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label>Catatan Perkuliahan</label>
                                    <textarea class="form-control summernote" rows="10" id="catatan_perkuliahan" name="catatan_perkuliahan"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </form>    
                        <div class="card-footer">
                            <button type="button" onclick="simpan()" class="btn btn-info float-right">Simpan</button>
                        </div>
                    </div>
                    
                    <div class="card card-danger">
                        <div class="card-header">
                            Keterangan
                        </div>
                        <div class="card-body">
                            <ol>
                                <li>Jurnal perkuliahan hanya bisa diinput sekali dalam sehari.</li>
                                <li>Jurnal perkuliahan hanya bisa diinput sesuai dengan jadwal perkuliahan.</li>
                            </ol>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- ./wrapper -->
<!-- Page specific script -->
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
<!-- daterangepicker -->
<script src="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Select2 -->
<script src="<?=base_url('assets');?>/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('assets');?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url('assets');?>/plugins/toastr/toastr.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url('assets');?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.js"></script>
<script>
$(function() {
	$('#reservationdate').datetimepicker({
        defaultDate:'now',
        format: 'YYYY-MM-DD'
    });
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('.summernote').summernote({
        tabsize: 2,
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['ltr', 'rtl']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
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

function getIdHari() {
    let tgl = $('#tanggal').val();
    
    $.ajax({
        url: "<?php echo site_url("akademik/$controller/getIdHari");?>",
        type: "POST",
        dataType: 'json',
        data: {
            tgl: tgl
        },
        success: function(data) {
            $("#hari").val(data.hari);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            Swal.close();
            if (xhr.status === 0) {
               var textError = 'Not connected.\nPlease verify your network connection.';
            } else if (xhr.status == 404) {
                var textError = 'The requested page not found.';
            }  else if (xhr.status == 401) {
                var textError = 'Sorry!! You session has expired. Please login to continue access.';
            } else if (xhr.status == 500) {
                var textError = 'Internal Server Error.';
            } else if (ajaxOptions === 'parsererror') {
                var textError = 'Requested JSON parse failed.';
            } else if (ajaxOptions === 'timeout') {
                var textError = 'Time out error.';
            } else if (ajaxOptions === 'abort') {
                var textError = 'Ajax request aborted.';
            } else {
                var textError = 'Unknown error occured. Please try again.';
            }
            Swal.fire({
                icon: 'error',
                title: "Ooppss!! Something wrong!!!",
                text: thrownError + "\r\n" + xhr.statusText + "\r\n" + textError,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
    })
}

function simpan() {

    var data = $('#form_jurnal').serialize();
    $('#form_jurnal').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan jurnal perkuliahan ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/$metode");?>",
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
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
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
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooops!! Something wrong!!',
                        text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                }
            });
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
        error: function(data) {
            console.log(data);
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
        }
    });
}


</script>
</body>
</html>