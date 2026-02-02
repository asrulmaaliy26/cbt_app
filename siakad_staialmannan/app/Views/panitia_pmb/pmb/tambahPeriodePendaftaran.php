
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
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  	<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/toastr/toastr.min.css">
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">

<!-- Moment Js -->
  <script src="<?=base_url('assets');?>/plugins/moment/moment.min.js"></script>
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  
	<!-- Theme style -->
  	<link rel="stylesheet" href="<?=base_url('assets');?>/dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                
                <div class="card-body">
                    <form class="form-horizontal" id="form_tambah" enctype="multipart/form-data">
                    	<div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Tahun Akademik</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="id_gel" name="id_gel" hidden value="<?=(isset($id_gel))?$id_gel:''?>"/>
                                <input type="text" class="form-control" id="Tahun_Akademik" name="Tahun_Akademik"  placeholder="2023/2024" value="<?=(isset($Tahun_Akademik))?$Tahun_Akademik:''?>"/>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Jenjang</label>
                            <div class="col-sm-9">
                                <select name="jenjang" id="jenjang" class="form-control select2" style="width: 100%;">
                                    <option></option>
                                    <option value="S1" <?=(isset($jenjang) && $jenjang == 'S1')?'selected':''?>> Sarjana (S1) </option>
                                    <option value="S2" <?=(isset($jenjang) && $jenjang == 'S2')?'selected':''?>> Pascasarjana (S2) </option>
                                    
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Nama Pendaftaran</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Nama_Periode" name="Nama_Periode"  placeholder="Pendaftaran Mahasiswa S1 Gel. 1" value="<?=(isset($Nama_Periode))?$Nama_Periode:''?>"/>
                                
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Nama Gelombang</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="Nama_Gelombang" name="Nama_Gelombang"  placeholder="Gelombang I Tahun 2023/2024" value="<?=(isset($Nama_Gelombang))?$Nama_Gelombang:''?>"/>
                                
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tanggal</label>
                            <div class="col-sm-4">
                                <div class="input-group date" id="reservationdate_tgl_mulai" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="Tgl_Mulai"
                                        data-toggle="datetimepicker" name="Tgl_Mulai" data-target="#reservationdate_tgl_mulai"
                                        placeholder="DD-MM-YYYY" value="<?=(isset($Tgl_Mulai))?$Tgl_Mulai:''?>"/>
                                    <div class="input-group-append" data-target="#reservationdate_tgl_mulai"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback">
                                        
                                    </div>
                                </div>
                            </div>
                            <label class="col-sm-1 col-form-label text-center">s/d</label>
                            <div class="col-sm-4">
                                <div class="input-group date" id="reservationdate_tgl_selesai" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="Tgl_Akhir"
                                        data-toggle="datetimepicker" name="Tgl_Akhir" data-target="#reservationdate_tgl_selesai"
                                        placeholder="DD-MM-YYYY" value="<?=(isset($Tgl_Akhir))?$Tgl_Akhir:''?>"/>
                                    <div class="input-group-append" data-target="#reservationdate_tgl_selesai"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Biaya Pendaftaran</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="biaya" name="biaya"  placeholder="250000"  value="<?=(isset($biaya))?$biaya:''?>"/>
                                
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Informasi Pendaftaran</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="info_pendaftaran" name="info_pendaftaran"><?=(isset($info_pendaftaran))?$info_pendaftaran:''?></textarea>
                                
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Informasi Biaya Perkuliahan</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="info_biaya_kuliah" name="info_biaya_kuliah"><?=(isset($info_biaya_kuliah))?$info_biaya_kuliah:''?></textarea>
                                
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Syarat Pendaftaran</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="persyaratan" name="persyaratan"><?=(isset($persyaratan))?$persyaratan:''?></textarea>
                                
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Kontak Person</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="contact_person" name="contact_person"><?=(isset($contact_person))?$contact_person:''?></textarea>
                                
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="form-group row ">
                            <label class="col-sm-3 col-form-label">Set Aktif?</label>
                            <div class="col-sm-9">
                                <select name="Aktif" id="Aktif" class="form-control select2" style="width: 100%;">
                                    <option></option>
                                    <option value="0" <?=(isset($Aktif) && $Aktif == '0')?'selected':''?>> Tidak </option>
                                    <option value="1" <?=(isset($Aktif) && $Aktif == '1')?'selected':''?>> Ya </option>
                                    
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" onclick="simpan()">Simpan </button>
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
<!-- Summernote -->
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-file.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-ext-rtl.js"></script>

<!-- Select2 -->
<script src="<?=base_url('assets');?>/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('assets');?>/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url('assets');?>/plugins/toastr/toastr.min.js"></script>
<!-- daterangepicker -->
<script src="<?=base_url('assets');?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url('assets');?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url('assets');?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.js"></script>
<script>
$(function() {
    
	
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('#reservationdate_tgl_mulai, #reservationdate_tgl_selesai').datetimepicker({
        format: 'DD-MM-YYYY'

    });
    
    $('#info_pendaftaran').summernote({
        dialogsInBody: true,
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
            ['insert', ['ltr', 'rtl', 'file']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {

            onFileUpload: function(file) {
                myOwnCallBackinfo_pendaftaran(file[0]);
            }
        }
    });
    
    $('#info_biaya_kuliah').summernote({
        dialogsInBody: true,
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
            ['insert', ['ltr', 'rtl', 'file']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {

            onFileUpload: function(file) {
                myOwnCallBackinfo_biaya_kuliah(file[0]);
            }
        }
    });
    
    $('#persyaratan').summernote({
        dialogsInBody: true,
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
            ['insert', ['ltr', 'rtl', 'file']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {

            onFileUpload: function(file) {
                myOwnCallBackpersyaratan(file[0]);
            }
        }
    });
    
    $('#contact_person').summernote({
        dialogsInBody: true,
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
            ['insert', ['ltr', 'rtl', 'file']],
            ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']],
        ],
        callbacks: {

            onFileUpload: function(file) {
                myOwnCallBackkontak(file[0]);
            }
        }
    });
    
})


function simpan() {

    var data = $('#form_tambah').serialize();
    $('#form_tambah').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan data ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("$controller/simpanSettingPmb");?>",
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

function myOwnCallBackinfo_pendaftaran(file) {
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
            let listMimeWord = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/rtf'];
            let elem;

            if (listMimeImg.indexOf(file.type) > -1) {
                //Picture
                $('#info_pendaftaran').summernote('editor.insertImage', url);
            } else if (listMimeAudio.indexOf(file.type) > -1) {
                //Audio
                elem = document.createElement("audio");
                elem.setAttribute("src", url);
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('#info_pendaftaran').summernote('editor.insertNode', elem);
            } else if (listMimeVideo.indexOf(file.type) > -1) {
                //Video
                elem = document.createElement("video");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "300");
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('#info_pendaftaran').summernote('editor.insertNode', elem);
            } else if (listMimePdf.indexOf(file.type) > -1) {
                //Pdf
                elem = document.createElement("iframe");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "600");
                elem.setAttribute("allow", "autoplay");
                $('#info_pendaftaran').summernote('editor.insertNode', elem);
            } else if (listMimeWord.indexOf(file.type) > -1) {
                //.doc .docx .rtf
                elem = document.createElement("iframe");
                elem.setAttribute("src", "https://view.officeapps.live.com/op/embed.aspx?src="+url);
                //elem.setAttribute("width", "100%");
                //elem.setAttribute("height", "600");
                elem.setAttribute("frameborder", "0");
                elem.setAttribute("scrolling", "yes");
                elem.setAttribute("seamless", "seamless");
                elem.setAttribute("style", "display:block; width:100%; height:100vh;");
                elem.setAttribute("allow", "autoplay");
                $('#info_pendaftaran').summernote('editor.insertNode', elem);
            }else {
                //Other file type
                var node;
                node = document.createElement("a");
                let linkText = document.createTextNode(file.name);
                node.appendChild(linkText);
                node.title = file.name;
                node.href = url;
                $('#info_pendaftaran').summernote('insertNode', node);
            }
            Swal.close();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: "Ooppss!! Something wrong!!!",
                text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
    });
}

function myOwnCallBackinfo_biaya_kuliah(file) {
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
            let listMimeWord = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/rtf'];
            let elem;

            if (listMimeImg.indexOf(file.type) > -1) {
                //Picture
                $('#info_biaya_kuliah').summernote('editor.insertImage', url);
            } else if (listMimeAudio.indexOf(file.type) > -1) {
                //Audio
                elem = document.createElement("audio");
                elem.setAttribute("src", url);
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('#info_biaya_kuliah').summernote('editor.insertNode', elem);
            } else if (listMimeVideo.indexOf(file.type) > -1) {
                //Video
                elem = document.createElement("video");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "300");
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('#info_biaya_kuliah').summernote('editor.insertNode', elem);
            } else if (listMimePdf.indexOf(file.type) > -1) {
                //Pdf
                elem = document.createElement("iframe");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "600");
                elem.setAttribute("allow", "autoplay");
                $('#info_biaya_kuliah').summernote('editor.insertNode', elem);
            } else if (listMimeWord.indexOf(file.type) > -1) {
                //.doc .docx .rtf
                elem = document.createElement("iframe");
                elem.setAttribute("src", "https://view.officeapps.live.com/op/embed.aspx?src="+url);
                //elem.setAttribute("width", "100%");
                //elem.setAttribute("height", "600");
                elem.setAttribute("frameborder", "0");
                elem.setAttribute("scrolling", "yes");
                elem.setAttribute("seamless", "seamless");
                elem.setAttribute("style", "display:block; width:100%; height:100vh;");
                elem.setAttribute("allow", "autoplay");
                $('#info_biaya_kuliah').summernote('editor.insertNode', elem);
            }else {
                //Other file type
                var node;
                node = document.createElement("a");
                let linkText = document.createTextNode(file.name);
                node.appendChild(linkText);
                node.title = file.name;
                node.href = url;
                $('#info_biaya_kuliah').summernote('insertNode', node);
            }
            Swal.close();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: "Ooppss!! Something wrong!!!",
                text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
    });
}

function myOwnCallBackpersyaratan(file) {
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
            let listMimeWord = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/rtf'];
            let elem;

            if (listMimeImg.indexOf(file.type) > -1) {
                //Picture
                $('#persyaratan').summernote('editor.insertImage', url);
            } else if (listMimeAudio.indexOf(file.type) > -1) {
                //Audio
                elem = document.createElement("audio");
                elem.setAttribute("src", url);
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('#persyaratan').summernote('editor.insertNode', elem);
            } else if (listMimeVideo.indexOf(file.type) > -1) {
                //Video
                elem = document.createElement("video");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "300");
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('#persyaratan').summernote('editor.insertNode', elem);
            } else if (listMimePdf.indexOf(file.type) > -1) {
                //Pdf
                elem = document.createElement("iframe");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "600");
                elem.setAttribute("allow", "autoplay");
                $('#persyaratan').summernote('editor.insertNode', elem);
            } else if (listMimeWord.indexOf(file.type) > -1) {
                //.doc .docx .rtf
                elem = document.createElement("iframe");
                elem.setAttribute("src", "https://view.officeapps.live.com/op/embed.aspx?src="+url);
                //elem.setAttribute("width", "100%");
                //elem.setAttribute("height", "600");
                elem.setAttribute("frameborder", "0");
                elem.setAttribute("scrolling", "yes");
                elem.setAttribute("seamless", "seamless");
                elem.setAttribute("style", "display:block; width:100%; height:100vh;");
                elem.setAttribute("allow", "autoplay");
                $('#persyaratan').summernote('editor.insertNode', elem);
            }else {
                //Other file type
                var node;
                node = document.createElement("a");
                let linkText = document.createTextNode(file.name);
                node.appendChild(linkText);
                node.title = file.name;
                node.href = url;
                $('#persyaratan').summernote('insertNode', node);
            }
            Swal.close();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: "Ooppss!! Something wrong!!!",
                text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
    });
}

function myOwnCallBackkontak(file) {
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
            let listMimeWord = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/rtf'];
            let elem;

            if (listMimeImg.indexOf(file.type) > -1) {
                //Picture
                $('#contact_person').summernote('editor.insertImage', url);
            } else if (listMimeAudio.indexOf(file.type) > -1) {
                //Audio
                elem = document.createElement("audio");
                elem.setAttribute("src", url);
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('#contact_person').summernote('editor.insertNode', elem);
            } else if (listMimeVideo.indexOf(file.type) > -1) {
                //Video
                elem = document.createElement("video");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "300");
                elem.setAttribute("controls", "controls");
                elem.setAttribute("preload", "metadata");
                $('#contact_person').summernote('editor.insertNode', elem);
            } else if (listMimePdf.indexOf(file.type) > -1) {
                //Pdf
                elem = document.createElement("iframe");
                elem.setAttribute("src", url);
                elem.setAttribute("width", "100%");
                elem.setAttribute("height", "600");
                elem.setAttribute("allow", "autoplay");
                $('#contact_person').summernote('editor.insertNode', elem);
            } else if (listMimeWord.indexOf(file.type) > -1) {
                //.doc .docx .rtf
                elem = document.createElement("iframe");
                elem.setAttribute("src", "https://view.officeapps.live.com/op/embed.aspx?src="+url);
                //elem.setAttribute("width", "100%");
                //elem.setAttribute("height", "600");
                elem.setAttribute("frameborder", "0");
                elem.setAttribute("scrolling", "yes");
                elem.setAttribute("seamless", "seamless");
                elem.setAttribute("style", "display:block; width:100%; height:100vh;");
                elem.setAttribute("allow", "autoplay");
                $('#contact_person').summernote('editor.insertNode', elem);
            }else {
                //Other file type
                var node;
                node = document.createElement("a");
                let linkText = document.createTextNode(file.name);
                node.appendChild(linkText);
                node.title = file.name;
                node.href = url;
                $('#contact_person').summernote('insertNode', node);
            }
            Swal.close();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: "Ooppss!! Something wrong!!!",
                text: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                confirmButtonText: 'OK',
                allowOutsideClick: false,
            })
        }
    });
}
</script>
</body>
</html>