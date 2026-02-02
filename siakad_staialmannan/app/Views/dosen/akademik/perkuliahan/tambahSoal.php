
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
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i>
                                <?=$templateJudul?>
                            </h3>
                            
                        </div>
                        <form id="form_soal" enctype="multipart/form-data">
                            <div class="card-body">
                                <input type="text" class="form-control" hidden id="kd_kelas_perkuliahan" name="kd_kelas_perkuliahan" value="<?php echo (isset($perkuliahan['kd_kelas_perkuliahan']))?$perkuliahan['kd_kelas_perkuliahan']:""?>" />
                                <div class="form-group">
                                    <label>Jenis Ujian</label>
                                    <select name="jns_ujian" id="jns_ujian" class="form-control select2" onchange="changeJnsUjian()" style="width: 100%;">
                                        <option></option>
                                        
                                        <option value="uts_soal" <?php echo (isset($jns_ujian) && $jns_ujian=="uts_soal")?"selected":"";?>>Soal UTS</option>
                                        <option value="uas_soal" <?php echo (isset($jns_ujian) && $jns_ujian=="uas_soal")?"selected":"";?>>Soal UAS</option>
                                        <option value="tugas" <?php echo (isset($jns_ujian) && $jns_ujian=="tugas")?"selected":"";?>>Tugas Akhir Matakuliah</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group" id="box_jns_soal" hidden>
                                    <label>Jenis Soal</label>
                                    <select name="jns_soal" id="jns_soal" class="form-control select2" onchange="changeJnsSoal()" style="width: 100%;">
                                        <option></option>
                                        <?php 
                                            if(isset($jns_ujian) && $jns_ujian == 'uas_soal'){
                                        ?>
                                        <option value="2" <?php echo (isset($jns_ujian) && $perkuliahan['jns_uas']=="2")?"selected":"";?>>Esai / Penugasan Lain</option>
                                        <option value="1" <?php echo (isset($jns_ujian) && $perkuliahan['jns_uas']=="1")?"selected":"";?>>Artikel</option>
                                        <?php } ?>
                                        <?php 
                                            if(isset($jns_ujian) && $jns_ujian == 'uts_soal'){
                                        ?>
                                        <option value="2" <?php echo (isset($jns_ujian) && $perkuliahan['jns_uts']=="2")?"selected":"";?>>Esai / Penugasan Lain</option>
                                        <option value="1" <?php echo (isset($jns_ujian) && $perkuliahan['jns_uts']=="1")?"selected":"";?>>Artikel</option>
                                        <?php } ?>
                                        <?php 
                                            if(empty($jns_ujian)){
                                        ?>
                                        <option value="2" >Esai / Penugasan Lain</option>
                                        <option value="1" >Artikel</option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group" id="box_soal_esay">
						            <label for="file_perkuliahan">Soal / Tugas</label>
						            <textarea class="form-control summernote" rows="10" id="soal" name="soal"><?php echo (isset($jns_ujian) && $jns_ujian=="uts_soal")?$perkuliahan['uts_soal']:(((isset($jns_ujian) && $jns_ujian=="uas_soal"))?$perkuliahan['uas_soal']:(((isset($jns_ujian) && $jns_ujian=="tugas"))?$perkuliahan['tugas']:''))?></textarea>
						            <div class="invalid-feedback"></div>
						        </div>
						        <div class="form-group" id="box_soal_artikel" hidden>
						            <div class="info-box mb-3 bg-success">
                                    
                                    <div class="info-box-content">
                                        <span class="info-box-text">Soal artikel dibuat secara otomatis oleh sistem.</span>
                                    </div>
						        </div>
                            </div>
                        </form>    
                        <div class="card-footer">
                            <button type="button" onclick="simpan()" class="btn btn-info float-right">Simpan</button>
                        </div>
                    </div>
                    
                        </form>
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
    changeJnsUjian();
    changeJnsSoal();
	bsCustomFileInput.init();
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('.summernote').summernote({
        tabsize: 2,
        height: 500,
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

function changeJnsUjian() {
    var val = $('#jns_ujian option:selected').val();
    if (val == 'uas_soal' || val == 'uts_soal') {
        $('#box_jns_soal').attr('hidden', false)
    } else {
        $('#box_jns_soal').attr('hidden', true);
        $('#box_soal_esay').attr('hidden', false);
        $('#box_soal_artikel').attr('hidden', true);
    }
}

function changeJnsSoal() {
    var val = $('#jns_soal option:selected').val();
    if (val == '2') {
        $('#box_soal_esay').attr('hidden', false);
        $('#box_soal_artikel').attr('hidden', true);
    } else if (val == '1'){
        $('#box_soal_esay').attr('hidden', true);
        $('#box_soal_artikel').attr('hidden', false);
    }
}

function simpan() {

    var data = new FormData($("#form_soal")[0]);
    $('#form_soal').find('.invalid-feedback').text('');
    Swal.fire({
        title: 'Anda yakin akan menyimpan soal ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("akademik/$controller/$metode");?>",
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
                        Swal.fire({
                            icon: data.msg,
                            title: data.pesan,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        }).then(() => {
                            location.reload();
                        })
        				
                    } else if (data.msg == 'warning') {
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

                    } else {
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
            let listMimeWord = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/rtf'];
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
                $('.summernote').summernote('editor.insertNode', elem);
            }else {
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