<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<script type="text/javascript">
	
    
    
    
	
</script>

<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<section class="content">
    
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-outline-tabs">
          <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-four-kriteria1-tab" data-toggle="pill" href="#custom-tabs-four-kriteria1" role="tab" aria-controls="custom-tabs-four-kriteria1" aria-selected="true">Kriteria 1</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-kriteria2-tab" data-toggle="pill" href="#custom-tabs-four-kriteria2" role="tab" aria-controls="custom-tabs-four-kriteria2" aria-selected="false">Kriteria 2</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-kriteria3-tab" data-toggle="pill" href="#custom-tabs-four-kriteria3" role="tab" aria-controls="custom-tabs-four-kriteria3" aria-selected="false">Kriteria 3</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-kriteria4-tab" data-toggle="pill" href="#custom-tabs-four-kriteria4" role="tab" aria-controls="custom-tabs-four-kriteria4" aria-selected="false">Kriteria 4</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-kriteria5-tab" data-toggle="pill" href="#custom-tabs-four-kriteria5" role="tab" aria-controls="custom-tabs-four-kriteria5" aria-selected="false">Kriteria 5</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-kriteria6-tab" data-toggle="pill" href="#custom-tabs-four-kriteria6" role="tab" aria-controls="custom-tabs-four-kriteria6" aria-selected="false">Kriteria 6</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-kriteria7-tab" data-toggle="pill" href="#custom-tabs-four-kriteria7" role="tab" aria-controls="custom-tabs-four-kriteria7" aria-selected="false">Kriteria 7</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-kriteria8-tab" data-toggle="pill" href="#custom-tabs-four-kriteria8" role="tab" aria-controls="custom-tabs-four-kriteria8" aria-selected="false">Kriteria 8</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-four-kriteria9-tab" data-toggle="pill" href="#custom-tabs-four-kriteria9" role="tab" aria-controls="custom-tabs-four-kriteria9" aria-selected="false">Kriteria 9</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">
              <div class="tab-pane fade show active" id="custom-tabs-four-kriteria1" role="tabpanel" aria-labelledby="custom-tabs-four-kriteria1-tab">
                 Kriteria 1
              </div>
              <div class="tab-pane fade" id="custom-tabs-four-kriteria2" role="tabpanel" aria-labelledby="custom-tabs-four-kriteria2-tab">
                 Kriteria 2
              </div>
              <div class="tab-pane fade" id="custom-tabs-four-kriteria3" role="tabpanel" aria-labelledby="custom-tabs-four-kriteria3-tab">
                 Kriteria 3
              </div>
              <div class="tab-pane fade" id="custom-tabs-four-kriteria4" role="tabpanel" aria-labelledby="custom-tabs-four-kriteria4-tab">
                 Kriteria 4
              </div>
              <div class="tab-pane fade" id="custom-tabs-four-kriteria5" role="tabpanel" aria-labelledby="custom-tabs-four-kriteria5-tab">
                 Kriteria 5
              </div>
              <div class="tab-pane fade" id="custom-tabs-four-kriteria6" role="tabpanel" aria-labelledby="custom-tabs-four-kriteria6-tab">
                 Kriteria 6
              </div>
              <div class="tab-pane fade" id="custom-tabs-four-kriteria7" role="tabpanel" aria-labelledby="custom-tabs-four-kriteria7-tab">
                 Kriteria 7
              </div>
              <div class="tab-pane fade" id="custom-tabs-four-kriteria8" role="tabpanel" aria-labelledby="custom-tabs-four-kriteria8-tab">
                 Kriteria 8
              </div>
              <div class="tab-pane fade" id="custom-tabs-four-kriteria9" role="tabpanel" aria-labelledby="custom-tabs-four-kriteria9-tab">
                 Kriteria 9
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
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
});
    

</script>
<?=$this->endSection();?>