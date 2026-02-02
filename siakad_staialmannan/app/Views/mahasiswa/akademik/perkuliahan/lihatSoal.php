<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-body">
                   
                <div class="row">
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <table class="table table-sm">
                              <tr>
                                <th style="width:30%">Nama Dosen</th>
                                <td>: <?=getDataRow('data_dosen',['Kode'=>$perkuliahan['Kd_Dosen']])['Nama_Dosen']?></td>
                              </tr>
                              <tr>
                                <th>NIY</th>
                                <td>: <?=getDataRow('data_dosen',['Kode'=>$perkuliahan['Kd_Dosen']])['NIY']?></td>
                              </tr>
                              <tr>
                                <th>NIDN / NUPN</th>
                                <td>: <?=getDataRow('data_dosen',['Kode'=>$perkuliahan['Kd_Dosen']])['NIDN_NUPN']?></td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <table class="table table-sm">
                              <tr>
                                <th style="width:25%">Jenis Soal</th>
                                <td>: <?=($jns_ujian == 'uas')?'UJIAN AKHIR SEMESTER':(($jns_ujian == 'uts')?'UJIAN TENGAH SEMESTER':'TUGAS AKHIR MATA KULIAH')?></td>
                              </tr>
                              <tr>
                                <th >Mata Kuliah</th>
                                <td>: <?=$perkuliahan['Mata_Kuliah']?></td>
                              </tr>
                              
                              <tr>
                                <th>Jadwal Ujian</th>
                                <td>: <?=($jns_ujian == 'uts')?$perkuliahan['Hari_UTS'].", ".$perkuliahan['Thn_UTS']."-".$perkuliahan['Bln_UTS']."-".$perkuliahan['Tgl_UTS']." Jam ".$perkuliahan['Jam_UTS']." Ruang ".$perkuliahan['Ruang_UTS']:$perkuliahan['Hari'].", ".$perkuliahan['Thn']."-".$perkuliahan['Bln']."-".$perkuliahan['Tgl']." Jam ".$perkuliahan['Jam']." Ruang ".$perkuliahan['Ruang']?></td>
                              </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    SOAL
                </h3>
                
            </div>
            <div class="card-body">
                <?php   if($jns_ujian == 'uts'){
                            echo $perkuliahan['uts_soal'];
                        }elseif($jns_ujian == 'tugas'){
                            echo $perkuliahan['tugas'];
                        }else{
                            if($perkuliahan['jns_uas'] == '2'){
                                echo $perkuliahan['uas_soal'];
                            }else{
                                echo "Soal berupa artikel. Silahkan kerjakan form di bawah ini!!";
                            }
                        }
                ?>
            </div>
        </div>
        
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    LEMBAR jAWABAN
                </h3>
                
            </div>
            <div class="card-body">
                <?php   if($jns_ujian == 'uts'){    ?>
                    <form class="form-horizontal" id="form_uts" enctype="multipart/form-data">
                        <div class="form-group row">
                            <textarea class="form-control summernote" rows="10" id="ljk" name="ljk"></textarea>
                        </div>
                        
                        <div class="form-group row">                            
                            
                            <button type="button" onclick="simpan_ljk('uts')" class="btn btn-success">Submit</button>
                            
                        </div>
                    </form>
                <?php } ?>
                
                <?php   if($jns_ujian == 'uas' && $perkuliahan['jns_uas'] == '2'){    ?>
                    <form class="form-horizontal" id="form_uas" enctype="multipart/form-data">
                        <div class="form-group row">
                            <textarea class="form-control summernote" rows="10" id="ljk" name="ljk"></textarea>
                        </div>
                        
                        <div class="form-group row">                            
                            
                            <button type="button" onclick="simpan_ljk('uas')" class="btn btn-success">Submit</button>
                            
                        </div>
                    </form>
                <?php } ?>
                
                <?php   if($jns_ujian == 'uas' && $perkuliahan['jns_uas'] == '1'){    ?>
                    
                <?php } ?>
                
                <?php   if($jns_ujian == 'tugas'){    ?>
                    <form class="form-horizontal" id="form_uas" enctype="multipart/form-data">
                        <div class="form-group row">
                            <textarea class="form-control summernote" rows="10" id="ljk" name="ljk"></textarea>
                        </div>
                        
                        <div class="form-group row">                            
                            
                            <button type="button" onclick="simpan_ljk('tugas')" class="btn btn-success">Submit</button>
                            
                        </div>
                    </form>
                <?php } ?>
                
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

<!-- Summernote -->
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-file.js"></script>
<script src="<?=base_url('assets');?>/plugins/summernote/summernote-ext-rtl.js"></script>



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
    // BS-Stepper Init
      document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
      })
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
            onPaste: function(e) {
              e.preventDefault();
              Swal.fire({
					title: "Ooooppsss....!",
					text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
					icon: "error",
				});
            },
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


<?=$this->endSection();?>