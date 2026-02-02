<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<script type="text/javascript">
	
    $(document).ready(function(){
        
        const button = document.getElementById('waButton');
        let link_ref = "<?=(!empty(getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['link_referral']))?getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['link_referral']:'';?>";
        let text = "Buat kalian yang pingin jadi *Akademisi yang Santri dan Santri yang Akademisi*... Ayo segera gabung di kampus *IAI Bani Fattah Jombang || The Center Of Tafaqquh Fiddin*... Ayoo tunggu apalagi Klik tautan berikut ini.... ";
        
        // let sharehref = `whatsapp://send?text=${encodeURIComponent(imageSrc)}`;
        
        button.setAttribute('href', 'whatsapp://send?text='+text+link_ref);
    });
    
</script>

<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?=(!empty($foto))?base_url($foto):base_url().'/assets/dist/img/no-pict.jpg'?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?=$gelar_depan?> <?=$Nama_Dosen?>, <?=$gelar_belakang?></h3>

                <a href="javascript:void(0)" onclick="edit('<?=$id_dosen?>'); return false;" class="btn btn-primary btn-block"><b>Edit Profil</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> NIY</strong>

                <p class="text-muted">
                  <?=$NIY?>
                </p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i> NIDN</strong>

                <p class="text-muted"><?=$NIDN_NUPN?></p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i> TTL</strong>

                <p class="text-muted">
                  <?=$TTL?>
                </p>

                <hr>

                <strong><i class="fas fa-book mr-1"></i> Pangkat / Gol. / Ruang</strong>

                <p class="text-muted"><?=(!empty($Pangkat_Gol_Ruang))?getDataRow('ref_option',['opt_group' => 'pangkat', 'opt_id' => $Pangkat_Gol_Ruang])['opt_val']:"-"?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Jabatan</strong>

                <p class="text-muted"><?=(!empty($Jabatan))?getDataRow('ref_option',['opt_group' => 'jabatan_fungsional', 'opt_id' => $Jabatan])['opt_val']:"-"?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Status</strong>

                <p class="text-muted"><?=(!empty($Status))?getDataRow('ref_option',['opt_group' => 'status_dosen', 'opt_id' => $Status])['opt_val']:"-"?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Homebase</strong>

                <p class="text-muted"><?=(!empty($Program_Studi))?getDataRow('prodi',['singkatan'=>$Program_Studi])['nm_prodi']:"-"?></p>
                
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Tahun Mulai Tugas</strong>

                <p class="text-muted"><?=$tahun_tugas?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Alamat</strong>

                <p class="text-muted"><?=$Alamat?></p>
                
                <hr>

                
                <strong><i class="fas fa-book mr-1"></i> Alamat Email</strong>
                <p class="text-muted"><?=$Alamat_Email?></p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Jenis Kelamin</strong>
                <p class="text-muted">
                    <?php
                        echo ($jenis_kelamin == "L") ? "Laki-laki" :
                            (($jenis_kelamin == "P") ? "Perempuan" : "-");
                    ?>
                </p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Ibu Kandung</strong>
                <p class="text-muted"><?=$ibu_kandung?></p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Status Kawin</strong>
                <p class="text-muted">
                    <?php
                        echo ($status_kawin == "Kawin") ? "Kawin" :
                            (($status_kawin == "Belum Kawin") ? "Belum Kawin" : "-");
                    ?>
                </p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Agama</strong>
                <p class="text-muted">
                    <?=(!empty($Agama)) ? getDataRow('ref_option',['opt_group'=>'agama','opt_id'=>$Agama])['opt_val'] : "-"?>
                </p>
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Profil Sinta</strong>

                <p class="text-muted"><?=$profil_sinta?></p>
                
                <hr>

                <strong><i class="fas fa-book mr-1"></i> Link Google Scholar</strong>

                <p class="text-muted"><?=$scholar?></p>
                
                
              </div>
              <!-- /.card-body -->
            </div>
            <?php if(!empty(getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['link_referral'])){?>
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Link PMB</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <a id="waButton" href=""><img src="<?=base_url('assets/dist/img/share_wa.png');?>" width="100%"></img></a>
              </div>
              <!-- /.card-body -->
            </div>
            <?php } ?>
            <?php if(!empty(getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['qrcode'])){?>
            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">QRCode PMB</h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                <img src="<?=getDataRow('pmb_affiliate', ['id_referrer' => $Kode])['qrcode'];?>" width="100%"></img>
              </div>
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <?php } ?>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#pendidikan" data-toggle="tab">Pendidikan</a></li>
                  <li class="nav-item"><a class="nav-link" href="#penelitian" data-toggle="tab">Penelitian</a></li>
                  <li class="nav-item"><a class="nav-link" href="#pengabdian" data-toggle="tab">Pengabdian</a></li>
                  <li class="nav-item"><a class="nav-link" href="#penghargaan" data-toggle="tab">Penghargaan</a></li>
                  <li class="nav-item"><a class="nav-link" href="#jurnal" data-toggle="tab">Jurnal</a></li>
                  <li class="nav-item"><a class="nav-link" href="#buku" data-toggle="tab">Buku</a></li>
                  <li class="nav-item"><a class="nav-link" href="#riwayat_mengajar" data-toggle="tab">Riwayat Mengajar</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="pendidikan">
                    
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="penelitian">
                    
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="pengabdian">
                    
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="penghargaan">
                    
                  </div>
                  <!-- /.tab-pane -->
                  
                  <div class="tab-pane" id="jurnal">
                    
                  </div>
                  <div class="tab-pane" id="buku">
                    
                  </div>
                  <div class="tab-pane" id="riwayat_mengajar">
                    
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
                        <label class="col-sm-3 col-form-label">Kewarganegaraan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="kewarganegaraan" name="kewarganegaraan"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Alamat Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="Alamat_Email" name="Alamat_Email"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Ibu Kandung</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ibu_kandung" name="ibu_kandung"  />
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row ">
                        <label class="col-sm-3 col-form-label">Status Kawin</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="status_kawin" name="status_kawin">
                                <option value="">-- Pilih Status Kawin --</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                            </select>
                            <div class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Agama</label>
                        <div class="col-sm-9">
                            <?php
                                    
                                echo cmb_dinamis('Agama', 'ref_option', 'opt_val', 'opt_id', ((isset($diri['Agama']))?$diri['Agama']:NULL), null, 'id="Agama"',null,null, ['opt_group'=>'agama']);
                                ?>
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
    
    table = $('#data').DataTable({
        "destroy": true,
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "searching": true,
        "ordering": false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url("masterdata/$controller/ajaxList") ?>",
            "type": "POST",
            "data": function(data) {
                data.prodi = $('#prodi').val();
                data.status_dosen = $('#status_dosen').val();
                data.jabatan_fungsional = $('#jabatan_fungsional').val();
                data.pangkat = $('#pangkat').val();
            }
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
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

function reload_table(){
    table.ajax.reload(null, false);
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
        url: "<?php echo site_url("$controller/getDataDosen");?>",
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