
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4 class="m-0"><?=$templateJudul?> <?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id'=>$id_data_diri])['Nama_Lengkap'])?></h4>
            
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                
                <div class="card-body">
                	<div class="row">
	                    <div class="col-6">
	                        <div class="table-responsive">
			                    <table class="table table-sm">
			                    	<tr>
				                        <th style="width:40%">Nama</th>
				                        <td><?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);?></td>
									</tr>
									<tr>
										<th >NIM</th>
										<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['NIM'];?></td>
									</tr>
									<tr>
										<th>Prodi</th>
										<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Prodi'];?></td>
									</tr>
									
			                      
			                    </table>
			                </div>
	                    </div>
	                    <div class="col-6">
	                    	<div class="table-responsive">
			                    <table class="table table-sm">
			                    	<tr>
				                        <th style="width:40%">Tahun Angkatan</th>
				                        <td><?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['th_angkatan']?>
				                        </td>
									</tr>
									<tr>
										<th >Kelas</th>
										<td><?=(getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Kelas'] == "PA") ? "Putera" : ((getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Kelas'] == "PI") ? "Puteri" : getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Kelas']);?></td>
									</tr>
									<tr>
										<th>Program</th>
										<td><?=getDataRow('histori_pddk', ['id_his_pdk' => $id_his_pdk])['Program'];?></td>
									</tr>
									
			                      
			                    </table>
			                </div>
	                    </div>
	                </div>
                </div>
            </div>
            <div class="card card-primary" >
                <div class="card-header">
                    <h3 class="card-title">
                        Judul
                    </h3>
                </div>
                <div class="card-body">
                    <?=strip_tags($judul_disposisi)?>
                </div>
            </div>
            <div class="card card-primary" >
                <div class="card-header">
                    <h3 class="card-title">
                        Problematika / Masalah Penelitian
                    </h3>
                </div>
                <div class="card-body">
                    <?=$problem_disposisi?>
                </div>
            </div>
            <div class="card card-primary" >
                <div class="card-header">
                    <h3 class="card-title">
                        Rumusan Masalah / Fokus Penelitian
                    </h3>
                </div>
                <div class="card-body">
                    <?=$rumusan_disposisi?>
                </div>
            </div>
            <div class="card card-primary card-outline">
                
                <div class="card-body">
                	
                    <div class="table-responsive">
                        <form class="form-horizontal" id="form_kualifikasi" enctype="multipart/form-data">
    	                    <table class="table table-sm">
    	                    	<tr>
    		                        <th style="width:17%">Full Text</th>
    		                        <td>
    		                            <?php
                        				    if(!empty($file_disposisi)){
                        				?>
                        				    <a href="<?=base_url('upload/file_disposisi')?>/<?=$file_disposisi?>" target="popup" role="button" class="btn btn-sm btn-success" onclick="window.open('<?=base_url()?>/upload/file_disposisi/<?=$file_disposisi?>','popup','width=600,height=600'); return false;" >Open Full Text</a>
                        				<?php } ?>
                        				    
    		                        </td>
    							</tr>
    							<tr>
    								<th >Status</th>
    								<td>
    								    <input type="text" hidden class="form-control" id="id_disposisi" name="id_disposisi" value="<?php echo (isset($id_disposisi))?$id_disposisi:""?>" />
    								    <?php
                                            echo cmb_dinamis('status', 'ref_option', 'opt_val', 'opt_id', ((isset($status))?$status:NULL), 'form-control-sm', 'id="status"  style="width: 100%;" onchange="ubahStatus()"', null, null, ['opt_group' => 'status_disposisi', 'is_aktif !=' => 'N']);     
                                           
                                        ?>
    								</td>
    							</tr>
    							<tr>
                                    <td class="align-middle">Tgl. Ujian Kualifikasi</td>
                                    <td>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" class="form-control form-control-sm datetimepicker-input" id="tgl_kualifikasi" data-toggle="datetimepicker" name="tgl_kualifikasi"
                                                data-target="#reservationdate" placeholder="YYYY-MM-DD" value="<?=$tgl_kualifikasi;?>" />
                                            <div class="input-group-append" data-target="#reservationdate"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                            <div class="invalid-feedback">

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reviewer</td>
                                    <td>
                                        <?php
                                            echo cmb_dinamis('reviewer', 'data_dosen', 'Nama_Dosen', 'Kode', ((isset($reviewer))?$reviewer:NULL), 'form-control-sm', 'id="reviewer"  style="width: 100%;"');     
                                           
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Catatan Kualifikasi</td>
                                    <td>
                                        <?= (isset($catatan_kaprodi))?$catatan_kaprodi:""?>
                                        <!--
                                        <div class="form-group">
                                            <textarea class="form-control summernote" rows="10" id="catatan_kaprodi" name="catatan_kaprodi">
                                                <?= (isset($catatan_kaprodi))?$catatan_kaprodi:""?>
                                            </textarea>
                                        </div>
                                        -->
                                    </td>
                                </tr>
                                
                                <tr class="<?=($status == 4)?'':'d-none'?>" id="tr_pembimbing">
                                    <td>Pembimbing</td>
                                    <td>
                                        <?php
                                            echo cmb_dinamis('dosen_pembimbing', 'data_dosen', 'Nama_Dosen', 'Kode', ((isset($dosen_pembimbing))?$dosen_pembimbing:NULL), 'form-control-sm', 'id="dosen_pembimbing"  style="width: 100%;" ');     
                                           
                                        ?>
                                    </td>
                                </tr>
                                
    	                    </table>
    	                </form>
	                </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="simpan()" class="btn btn-info float-right">Simpan</button>
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
var table_mk;
$(function() {
	
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

function simpan() {

    var data = new FormData($("#form_kualifikasi")[0]);
    Swal.fire({
        title: 'Anda yakin akan menyimpan hasil ujian kualifikasi ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo site_url("tugasakhir/$controller/$metode");?>",
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
                	Swal.fire({
                        icon: 'error',
                        title: thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    })
                    //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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

function ubahStatus(){
    var val = $('#status option:selected').val();
    if (val == "4") {
        $('#tr_pembimbing').removeClass('d-none');
    } else {
        $('#tr_pembimbing').addClass('d-none');
    }
}

</script>
</body>
</html>