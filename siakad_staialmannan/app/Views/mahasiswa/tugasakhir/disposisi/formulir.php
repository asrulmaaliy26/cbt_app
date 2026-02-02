
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

<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/toastr/toastr.min.css">
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">
<!-- BS Stepper -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/bs-stepper/css/bs-stepper.min.css">
<!-- tags Input -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/bootstrap-tagsinput/tagsinput.css">
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
            <div class="card card-danger card-outline" id="card_validasi" hidden>
                <div class="card-body">
                    <div class="alert alert-danger">
            			<ul id="list_error">
            				
            			</ul>
            		</div>
                </div>
            </div>
            
            <div class="card card-primary card-outline">
                <div class="card-body p-0">
                        <div class="bs-stepper">
                          <div class="bs-stepper-header" role="tablist">
                            <!-- your steps here -->
                            <div class="step" data-target="#judul-part">
                              <button type="button" class="step-trigger" role="tab" aria-controls="judul-part" id="judul-part-trigger">
                                <span class="bs-stepper-circle">1</span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#problem-part">
                              <button type="button" class="step-trigger" role="tab" aria-controls="problem-part" id="problem-part-trigger">
                                <span class="bs-stepper-circle">2</span>
                              </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#rumusan-part">
                              <button type="button" class="step-trigger" role="tab" aria-controls="rumusan-part" id="rumusan-part-trigger">
                                <span class="bs-stepper-circle">3</span>
                              </button>
                            </div>
                            
                            <div class="line"></div>
                            <div class="step" data-target="#file-upload-part">
                              <button type="button" class="step-trigger" role="tab" aria-controls="file-upload-part" id="file-upload-part-trigger">
                                <span class="bs-stepper-circle">4</span>
                              </button>
                            </div>
                          </div>
                          <div class="bs-stepper-content">
                              <form id="form_disposisi" class="needs-validation" onSubmit="return false" novalidate enctype="multipart/form-data">
                                <!-- your steps content here -->
                                <input type="text" class="form-control" value="<?=$id_his_pdk?>" hidden name="id_his_pdk" id="id_his_pdk">
                                <div id="judul-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="judul-part-trigger">
                                  
                                  <div class="form-group">
                                    <div class="callout callout-info" style="text-align: justify;">
                                      <h4><i class="fas fa-info"></i> Tuliskan rencana judul penelitian Saudara!</h4>
                                      Judul penelitian merupakan gambaran dari pelaksanaan penelitian (<em>conceptual framework</em>) yang akan dilakukan, yang biasanya dirangkai dalam kalimat pernyataan. Judul penelitian harus dibuat dengan menggunakan <strong>maksimal 15 (lima belas) kata</strong> yang bisa diukur, clear, singkat, dan menggambarkan pelaksanaan penelitian yang akan dilaksanakan. 
                                    </div>
                                    <textarea class="form-control" rows="10" id="judul-part-inp" name="judul-part-inp"></textarea>
                                    <div class="invalid-feedback">Judul tidak boleh kosong!!</div>
                                    <div class="col-12 text-right">
                                      <span id="maxContentJudul" class="badge badge-info"></span>
                                    </div>
                                  </div>
                                  
                                  <button class="btn btn-primary btn-next-form" >Next</button>
                                </div>
                                <div id="problem-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="problem-part-trigger">
                                    
                                  <div class="form-group">
                                    <label for="problem-part-inp"><h3></h3></label>
                                    <div class="callout callout-info" style="text-align: justify;">
                                      <h4><i class="fas fa-info"></i> Deskripsikan problematika / permasalahan dalam penelitian Saudara!</h4>
                                      <p>Pada bagian ini peneliti/mahasiswa menguraikan akar permasalahan yang dikaji dalam penelitian atau hal yang menimbulkan pertanyaan penelitian (<em>research question</em>), yang akan dilakukan untuk menyiapkan penelitian.</p><p>Masalah penelitian merupakan "kesenjangan" atau perbedaan antara yang seharusnya (<em>Das Sollen</em>) dan yang senyatanya (<em>Das Sein</em>).</p> <p>Masalah penelitian <strong>maksimal 250 (dua ratus lima puluh) kata</strong>.</p>

                                    </div>
                                    <textarea class="form-control artikel" rows="10" id="problem-part-inp" name="problem-part-inp"></textarea>
                                    <div class="invalid-feedback">Problematika / permasalahan tidak boleh kosong!!</div>
                                    <div class="col-12 text-right">
                                      <span id="maxContentMasalah" class="badge badge-info"></span>
                                    </div>
                                  </div>
                                  <button class="btn btn-primary btn-prev-form" >Previous</button>
                                  <button class="btn btn-primary btn-next-form" >Next</button>
                                </div>
                                <div id="rumusan-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="rumusan-part-trigger">
                                  
                                  <div class="form-group">
                                    <div class="callout callout-info" style="text-align: justify;">
                                      <h4><i class="fas fa-info"></i> Tulis rumusan masalah / fokus penelitian dalam penelitian Saudara!</h4>
                                      <p>Rumusan masalah merupakan bagian yang harus dituliskan dengan jelas. Rumusan masalah adalah masalah ilmiah penelitian (<em>scientific research problems</em>). Masalah penelitian inilah yang akan dipecahkan atau dicarikan solusinya melalui suatu proses penelitian ilmiah. Dalam pembuatan rumusan masalah, peneliti harus bisa membedakan dan memahami rumusan masalah untuk penelitian kualitatif dan penelitian kuantitatif. Dalam rumusan masalah penelitian kualitatif, peneliti sudah bisa menunjukkan teori apa yang akan ditemukan.</p> 
                                      <p>Dalam penelitian kualitatif, minimal ada 2 (dua) teori yang akan ditemukan. Sedangkan untuk penelitian kuantitatif, peneliti sudah bisa menunjukkan teori apa yang akan diuji dengan minimal 2 (dua) variabel independent dan 1 (satu) variabel dependen untuk penelitian asosiatif, dan minimal 1 (satu) variabel dan 2 (dua) sample untuk penelitian komparatif.</p> 
                                      <p>Semua variabel tersebut harus dapat diukur dan dimanage (<em>measurable and managable</em>). Selain itu, peneliti juga bisa mengkombinasikan rumusan masalah ini dengan pertanyaan-pertanyaan yang termasuk dalam <em>mixed methods</em>.</p>
                                      <p>Rumusan masalah / fokus penelitian <strong>maksimal 40 (empat puluh) kata.</strong></p>

                                    </div>
                                    <textarea class="form-control artikel" rows="10" id="rumusan-part-inp" name="rumusan-part-inp"></textarea>
                                    <div class="invalid-feedback">Rumusan Masalah / Fokus Penelitian tidak boleh kosong!!</div>
                                    <div class="col-12 text-right">
                                      <span id="maxContentRumusan" class="badge badge-info"></span>
                                    </div>
                                  </div>
                                  <button class="btn btn-primary btn-prev-form" >Previous</button>
                                  <button class="btn btn-primary btn-next-form" >Next</button>
                                </div>
                                
                                <div id="file-upload-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="file-upload-part-trigger">
                                  <div class="form-group">
                                    <label for="kata_kunci">Kata Kunci</label>
                                    <input type="text" id="kata_kunci" class="form-control" name="kata_kunci" data-role="tagsinput">
                                    <small id="katakunciHelpBlock" class="form-text text-muted">
									  Pisahkan kata kunci dengan koma.
									</small>
                                  </div>
                                  <div class="form-group">
                                    <label for="file_disposisi">File Disposisi</label>
                                    <div class="input-group">
                                      <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file_disposisi" name="file_disposisi">
                                        <label class="custom-file-label" for="file_disposisi">Choose file</label>
                                      </div>
                                      
                                    </div>
                                  </div>
                                  <button class="btn btn-primary btn-prev-form" >Previous</button>
                                  <button type="button" class="btn btn-primary" onclick="simpan()">Simpan </button>
                                </div>
                              </form>
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
<script src="<?=base_url('assets');?>/plugins/bootstrap-tagsinput/tagsinput.js"></script>

<!-- BS-Stepper -->
<script src="<?=base_url('assets');?>/plugins/bs-stepper/js/bs-stepper.min.js"></script>
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
<!-- bs-custom-file-input -->
<script src="<?=base_url('assets');?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url('assets');?>/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url('assets');?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets');?>/dist/js/adminlte.js"></script>
<script>
var maxJudul = 15;
var maxMasalah = 250;
var maxRumusan = 40;
$(function() {
	bsCustomFileInput.init();
    $('.select2').select2({
        placeholder: "----Pilih Opsi----",
        allowClear: true
    });
    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
    });
    
    $('#judul-part-inp').summernote({
        tabsize: 2,
        height: 100,
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
            ['view', ['undo', 'redo', 'fullscreen']],
        ],
        callbacks: {
            onPaste: function(e) {
              var t = e.currentTarget.innerText;
              var bufferText = ((e.originalEvent || e).clipboardData || 
                                 window.clipboardData).getData('Text');
              e.preventDefault();
              var all = t + bufferText;
              var words = all.split(" ");
              var array = words.slice(0, maxJudul)
              document.execCommand('insertText', false, array.join(" "));
              /*
              e.preventDefault();
              Swal.fire({
      					title: "Ooooppsss....!",
      					text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
      					icon: "error",
      				});
              */
            },
            onKeydown: function (e) {
             var t = e.currentTarget.innerText;   
             var words = t.split(" ");
             if (words.length > maxJudul) {
                  //delete key
              if (e.keyCode != 8)
                e.preventDefault();
                // add other keys ...
              }
            },
            onKeyup: function(e) {
                var t = e.currentTarget.innerText;
                var words = t.split(" ");
                
                $('#maxContentJudul').text(words.length+" Kata");
            },
        }
    });

    $('#problem-part-inp').summernote({
        tabsize: 2,
        height: 400,
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
            ['view', ['undo', 'redo', 'fullscreen']],
        ],
        callbacks: {
            onPaste: function(e) {
              var t = e.currentTarget.innerText;
              var bufferText = ((e.originalEvent || e).clipboardData || 
                                 window.clipboardData).getData('Text');
              e.preventDefault();
              var all = t + bufferText;
              var words = all.split(" ");
              var array = words.slice(0, maxMasalah)
              document.execCommand('insertText', false, array.join(" "));
              /*
              e.preventDefault();
              Swal.fire({
                title: "Ooooppsss....!",
                text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
                icon: "error",
              });
              */
            },
            onKeydown: function (e) {
             var t = e.currentTarget.innerText;   
             var words = t.split(" ");
             if (words.length > maxMasalah) {
                  //delete key
              if (e.keyCode != 8)
                e.preventDefault();
                // add other keys ...
              }
            },
            onKeyup: function(e) {
                var t = e.currentTarget.innerText;
                var words = t.split(" ");
                
                $('#maxContentMasalah').text(words.length+" Kata");
            },
        }
    });

    $('#rumusan-part-inp').summernote({
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
            ['view', ['undo', 'redo', 'fullscreen']],
        ],
        callbacks: {
            onPaste: function(e) {
              var t = e.currentTarget.innerText;
              var bufferText = ((e.originalEvent || e).clipboardData || 
                                 window.clipboardData).getData('Text');
              e.preventDefault();
              var all = t + bufferText;
              var words = all.split(" ");
              var array = words.slice(0, maxRumusan)
              document.execCommand('insertText', false, array.join(" "));
              /*
              e.preventDefault();
              Swal.fire({
                title: "Ooooppsss....!",
                text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
                icon: "error",
              });
              */
            },
            onKeydown: function (e) {
             var t = e.currentTarget.innerText;   
             var words = t.split(" ");
             if (words.length > maxRumusan) {
                  //delete key
              if (e.keyCode != 8)
                e.preventDefault();
                // add other keys ...
              }
            },
            onKeyup: function(e) {
                var t = e.currentTarget.innerText;
                var words = t.split(" ");
                
                $('#maxContentRumusan').text(words.length+" Kata");
            },
        }
    });
    /*
    $('.artikel').summernote({
        tabsize: 2,
        height: 400,
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
            onPaste: function(e) {
              e.preventDefault();
              Swal.fire({
					title: "Ooooppsss....!",
					text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
					icon: "error",
				});
            },
            
        }
    });
    */
    //BS-Stepper Init
    var stepperFormEl = document.querySelector('.bs-stepper')
        window.stepperForm = new Stepper(stepperFormEl, {
        animation: true
    })
    
    var btnNextList = [].slice.call(document.querySelectorAll('.btn-next-form'))
    var btnPrevList = [].slice.call(document.querySelectorAll('.btn-prev-form'))
    var stepperPanList = [].slice.call(stepperFormEl.querySelectorAll('.bs-stepper-pane'))
    var judul = document.getElementById('judul-part-inp')
    var problem = document.getElementById('problem-part-inp')
    var rumusan = document.getElementById('rumusan-part-inp')
    var form = stepperFormEl.querySelector('.bs-stepper-content form')
    
    btnNextList.forEach(function (btn) {
        btn.addEventListener('click', function () {
          window.stepperForm.next()
        })
    })
    btnPrevList.forEach(function (btn) {
        btn.addEventListener('click', function () {
          window.stepperForm.previous()
        })
    })
    
    stepperFormEl.addEventListener('show.bs-stepper', function (event) {
        //form.classList.remove('was-validated')
        var nextStep = event.detail.indexStep
        var currentStep = nextStep
    
        if (currentStep > 0) {
          currentStep--
        }
    
        var stepperPan = stepperPanList[currentStep]
    
        if ((stepperPan.getAttribute('id') === 'judul-part' && !judul.value.length) ||
        (stepperPan.getAttribute('id') === 'problem-part' && !problem.value.length) ||
        (stepperPan.getAttribute('id') === 'rumusan-part' && !rumusan.value.length)) {
          event.preventDefault()
          //form.classList.add('was-validated')
          //console.log('Moved to step ' + form.classList)
          $('#' +stepperPan.getAttribute('id')+'-inp').addClass('is-invalid');
        }
    })
})

function simpan() {

    var data = new FormData($("#form_disposisi")[0]);
    $('#card_validasi').attr('hidden', true);
    $("#list_error").find("li").remove();
    Swal.fire({
        title: 'Anda yakin akan menyimpan pengajuan judul penelitian ??',
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
                        
                        $('#card_validasi').attr('hidden', false)

                        const ul = $('#list_error');
                        $.each(data.validation, function (_, value) {
                            tr = $("<li />");
                            tr.append("<li>" + value + "</li>");
                            tr.appendTo(ul);
                        })
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


</script>
<?php
	$session = \Config\Services::session();
	if($session->getFlashdata('info') == 'warning'):
?>
<script type="text/javascript">
				Swal.fire({
					title: "Oooopppsss....!",
					text: "Maaf!! Anda tidak dijinkan mengakses Formulir Pengajuan Judul Skripsi karena Anda belum melakukan pemrograman KRS di Semester ini.",
					icon: "warning",
					showConfirmButton: false,
                    allowOutsideClick: false,
				});
			</script>
<?php elseif($session->getFlashdata('krs_tidak_aktif')):?>
<script type="text/javascript">
				Swal.fire({
					title: "Periode Tidak Aktif!",
					text: "<?=$session->getFlashdata('krs_tidak_aktif')?>",
					icon: "error",
					showConfirmButton: false,
                    allowOutsideClick: false,
				});
			</script>
<?php endif;?>
</body>
</html>