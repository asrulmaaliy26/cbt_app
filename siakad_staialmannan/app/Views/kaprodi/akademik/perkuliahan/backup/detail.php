<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>

<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                
                
                
                
              </div>
              <!-- /.card-body -->
            </div>
            
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#absensi" data-toggle="tab">Absensi</a></li>
                  <li class="nav-item"><a class="nav-link" href="#jurnal_pengajaran" data-toggle="tab">Jurnal Pengajaran</a></li>
                  <li class="nav-item"><a class="nav-link" href="#dokumen_pengajaran" data-toggle="tab">Dokumen Pengajaran</a></li>
                  <li class="nav-item"><a class="nav-link" href="#ujian" data-toggle="tab">Ujian</a></li>
                  <li class="nav-item"><a class="nav-link" href="#penilaian" data-toggle="tab">Penilaian</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="absensi">
                    <div class="mailbox-controls">
                        <div class="card">
                            <div class="card-body">
                                    <form action="" method="get">
                                        <div class="col-md-12">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Program Studi</label>
                                                        <select name="prodi" id="prodi" class="form-control select2" style="width: 100%;">
                                                            <option></option>
                                                            
                                                            <?php $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Prodi', null,null, null, 'Prodi'); 
                                                                
                                                                foreach ($prodi as $key ) {
                                                            ?>
                                                            <option value="<?=$key->Prodi?>" ><?=$key->Prodi?></option>
                                                            <?php    }    ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            	<div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Kelas</label>
                                                        <select name="kelas" id="kelas" class="form-control select2"  style="width: 100%;">
                                                            <option></option>
                                                            
                                                            <?php $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $perkuliahan['kd_kelas_perkuliahan']], null, 'Kelas', null,null, null, 'Kelas'); 
                                                                
                                                                foreach ($kelas as $key ) {
                                                            ?>
                                                            <option value="<?=$key->Kelas?>" ><?=$key->Kelas?></option>
                                                            <?php    }    ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2  pt-4 mt-2">
                                                    <button type="button" class="btn btn-success btn-sm" data-placement="top" title="Tambah Mahasiswa" onclick="getDataMhs()">
                                                        Lihat Data
                                                    </button>
                                                </div>
                                                
                                                
                                            </div>
                                            
                                        </div>
                                    </form>
                                
                            </div>
                        </div>
                    </div>
                    <table id="data_mhs" class="table table-bordered table-hover">
    	                <thead>
    		                <tr>
    		                    <th class="text-center">No</th>
    		                    <?php if(session()->get('akun_username') == "Administrator"){ ?>
    		                    <th>id_his_pdk</th>
    		                    <th>id_mhs_his_pdk</th>
    		                    <th>id_data_diri</th>
    		                    <?php } else { ?>
    		                    <th>Nama</th>
    		                    <th>NIM</th>
    		                    <th class="text-center">Tahun Angkatan</th>
    		                    <th class="text-center">SMT</th>
    		                    <?php } ?>
    		                </tr>
    	                </thead>
    	                <tbody>
    	                  
    	                </tbody>
                    </table>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="jurnal_pengajaran">
                    
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="ujian">
                    
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="penilaian">
                    
                  </div>
                  <!-- /.tab-pane -->
                  
                  
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="tambahModal" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form-horizontal" id="form_tambah" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Dosen / Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Kode</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" hidden id="id_dosen" name="id_dosen" />
                            <input type="text" class="form-control" id="Kode" name="Kode"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Gelar Depan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gelar_depan" name="gelar_depan"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Gelar Belakang</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="Nama_Dosen" name="Nama_Dosen"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">NIY</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="NIY" name="NIY"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">TTL</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="TTL" name="TTL"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">NIDN / NUPN</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="NIDN_NUPN" name="NIDN_NUPN"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="Alamat" name="Alamat"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Pangkat / Golongan</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Pangkat_Gol_Ruang', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Pangkat_Gol_Ruang" style="width: 100%;"', null, null, ['opt_group' => 'pangkat']);
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jabatan Fungsional</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Jabatan', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Jabatan" style="width: 100%;"', null, null, ['opt_group' => 'jabatan_fungsional']);
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Status', 'ref_option', 'opt_val', 'opt_id', null, null, 'id="Status" style="width: 100%;"', null, null, ['opt_group' => 'status_dosen']);
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Tahun Tugas</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="tahun_tugas" name="tahun_tugas"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Homebase</label>
                        <div class="col-sm-9">
                            <?php
                                echo cmb_dinamis('Program_Studi', 'prodi', 'nm_prodi', 'singkatan', null, null, 'id="Program_Studi" style="width: 100%;"');
                            ?>
                            
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Profil Sinta</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="profil_sinta" name="profil_sinta"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Profil Google Scholar</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="scholar" name="scholar"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" class="custom-file-input" id="foto" name="foto"
                                        oninput="pic.src=window.URL.createObjectURL(this.files[0])"> >
                                    <label class="custom-file-label" for="input_post_thumbnail">Choose file</label>
                                </div>

                            </div>

                            <div class="invalid-feedback">

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
    $('#tambahModal').on('hidden.bs.modal', function() {
        var modal = $(this)
        $(this).find('input').removeClass('is-invalid');
        $(this).find('form').trigger('reset');
        $(this).find('.select2').val('').trigger('change');
        $(this).find('.invalid-feedback').text('');
        $(this).find('#pic').removeAttr('src');
        $(this).find('#username').attr('readonly', false);
    });
})

function reload_table(){
    table.ajax.reload(null, false);
}

function getDataMhs(){
    var prodi = $('#prodi option:selected').val();
    var kelas = $('#kelas option:selected').val();
    if(prodi == '' || kelas == ''){
        Swal.fire({
            icon: 'warning',
            title:"pilih prodi dan kelas!!",
            confirmButtonText: 'OK',
            allowOutsideClick: false,
        })
    }else{
        $('#data_mhs').DataTable({
            "createdRow": function (row, data, index) {
    			$('td', row).eq(0).addClass('text-center');
    			$('td', row).eq(3).addClass('text-center');
    			$('td', row).eq(4).addClass('text-center');
    		},
            "destroy": true,
            "paging": false,
            "lengthChange": false,
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url("akademik/$controller/ajaxListMhsKelas") ?>",
                "type": "POST",
                "data": function(data) {
                    data.prodi = $('#prodi').val();
                    data.kelas = $('#kelas').val();
                    data.kd_kelas_perkuliahan = '<?=$perkuliahan['kd_kelas_perkuliahan']?>';
                }
            },
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });
    
        $('th input[type=checkbox], td input[name=check]').prop('checked', false);
                            
        var active_class = 'active';
        $('#data_mhs > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header
            
            $(this).closest('table').find('tbody > tr').each(function(){
                var row = this;
                if(th_checked) $(row).addClass(active_class).find('input[name=check]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[name=check]').eq(0).prop('checked', false);
            });
        });
    }
        
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
        url: "<?php echo site_url("$controller/getData");?>",
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
                url: "<?php echo site_url("$controller");?>",
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
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    })

}

</script>
<?=$this->endSection();?>