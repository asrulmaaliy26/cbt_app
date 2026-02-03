<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $templateJudul ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/summernote/summernote-bs4.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/dist/css/adminlte.min.css">
</head>

<body>
  <div class="wrapper">
    <!-- Main content -->
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
                      <td>: <?= getDataRow('data_dosen', ['Kode' => $perkuliahan['Kd_Dosen']])['Nama_Dosen'] ?></td>
                    </tr>
                    <tr>
                      <th>NIY</th>
                      <td>: <?= getDataRow('data_dosen', ['Kode' => $perkuliahan['Kd_Dosen']])['NIY'] ?></td>
                    </tr>
                    <tr>
                      <th>NIDN / NUPN</th>
                      <td>: <?= getDataRow('data_dosen', ['Kode' => $perkuliahan['Kd_Dosen']])['NIDN_NUPN'] ?></td>
                    </tr>
                  </table>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="table-responsive">
                  <table class="table table-sm">
                    <tr>
                      <th style="width:25%">Jenis Soal</th>
                      <td>:
                        <?= ($jns_ujian == 'uas') ? 'UJIAN AKHIR SEMESTER' : (($jns_ujian == 'uts') ? 'UJIAN TENGAH SEMESTER' : 'TUGAS AKHIR MATA KULIAH') ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Mata Kuliah</th>
                      <td>: <?= $perkuliahan['Mata_Kuliah'] ?></td>
                    </tr>

                    <tr>
                      <th>Jadwal Ujian</th>
                      <td>:
                        <?= ($jns_ujian == 'uts') ? $perkuliahan['Hari_UTS'] . ", " . $perkuliahan['Thn_UTS'] . "-" . $perkuliahan['Bln_UTS'] . "-" . $perkuliahan['Tgl_UTS'] . " Jam " . $perkuliahan['Jam_UTS'] . " Ruang " . $perkuliahan['Ruang_UTS'] : $perkuliahan['Hari'] . ", " . $perkuliahan['Thn'] . "-" . $perkuliahan['Bln'] . "-" . $perkuliahan['Tgl'] . " Jam " . $perkuliahan['Jam'] . " Ruang " . $perkuliahan['Ruang'] ?>
                      </td>
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
            <?php if ($jns_ujian == 'uts') {
              if ($perkuliahan['jns_uts'] == '2') {
                echo $perkuliahan['uts_soal'];
              } else {
                echo "Soal berupa artikel. Silahkan kerjakan form di bawah ini!!";
              }
            } elseif ($jns_ujian == 'tugas') {
              echo $perkuliahan['tugas'];
            } else {
              if ($perkuliahan['jns_uas'] == '2') {
                echo $perkuliahan['uas_soal'];
              } else {
                echo "Soal berupa artikel. Silahkan kerjakan form di bawah ini!!";
              }
            }
            ?>
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
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-edit"></i>
              LEMBAR JAWABAN
            </h3>

          </div>
          <?php if ($jns_ujian == 'uts' && $perkuliahan['jns_uts'] == '2') { ?>
            <div class="card-body">
              <form class="form-horizontal" id="form_ljk" enctype="multipart/form-data">
                <div class="form-group">

                  <button type="button" onclick="simpan_ljk('uts','<?= $id_ljk ?>','<?= $perkuliahan['id'] ?>')"
                    class="btn btn-success">Submit</button>
                  <input type="hidden" name="catatan_pelanggaran" id="catatan_pelanggaran_uts" value="">
                </div>
                <div class="form-group">
                  <textarea class="form-control summernote" rows="10" id="ljk" name="ljk">
                                  <?= (!empty(getDataRow('data_ljk', ['id_ljk' => $id_ljk]))) ? str_replace('http://', 'https://', getDataRow('data_ljk', ['id_ljk' => $id_ljk])['ljk_uts']) : '' ?>
                              </textarea>
                  <div class="invalid-feedback"></div>
                </div>


              </form>
            </div>
          <?php } ?>

          <?php if ($jns_ujian == 'uts' && $perkuliahan['jns_uts'] == '1') {
            $id_artikel = (!empty(getDataRow('data_ljk', ['id_ljk' => $id_ljk]))) ? getDataRow('data_ljk', ['id_ljk' => $id_ljk])['artikel_uts'] : '';
            $artikel = (!empty($id_artikel)) ? getDataRow('tugas_artikel', ['id_artikel' => $id_artikel]) : '';
            ?>
            <div class="card-body p-0">
              <div class="bs-stepper">
                <div class="bs-stepper-header" role="tablist">
                  <!-- your steps here -->
                  <div class="step" data-target="#judul-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="judul-part"
                      id="judul-part-trigger">
                      <span class="bs-stepper-circle">1</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#abstrak-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="abstrak-part"
                      id="abstrak-part-trigger">
                      <span class="bs-stepper-circle">2</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#fokus-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="fokus-part"
                      id="fokus-part-trigger">
                      <span class="bs-stepper-circle">3</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#review-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="review-part"
                      id="review-part-trigger">
                      <span class="bs-stepper-circle">4</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#posisi-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="posisi-part"
                      id="posisi-part-trigger">
                      <span class="bs-stepper-circle">5</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#novelty-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="novelty-part"
                      id="novelty-part-trigger">
                      <span class="bs-stepper-circle">6</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#metode-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="metode-part"
                      id="metode-part-trigger">
                      <span class="bs-stepper-circle">7</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#kesimpulan-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="kesimpulan-part"
                      id="kesimpulan-part-trigger">
                      <span class="bs-stepper-circle">8</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#referensi-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="referensi-part"
                      id="referensi-part-trigger">
                      <span class="bs-stepper-circle">9</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#sistematika-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="sistematika-part"
                      id="sistematika-part-trigger">
                      <span class="bs-stepper-circle">10</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#file-upload-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="file-upload-part"
                      id="file-upload-part-trigger">
                      <span class="bs-stepper-circle">11</span>
                    </button>
                  </div>
                </div>
                <div class="bs-stepper-content">
                  <form class="needs-validation" id="form_ljk" enctype="multipart/form-data" onSubmit="return false"
                    novalidate>
                    <input type="hidden" name="catatan_pelanggaran" id="catatan_pelanggaran_uts_artikel" value="">
                    <!-- your steps content here -->
                    <div id="judul-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="judul-part-trigger">

                      <div class="form-group">
                        <label for="judul-part-inp">
                          <h3>Tuliskan judul artikel Saudara!</h3>
                        </label>
                        <!--<input id="judul-part-inp" type="email" class="form-control" placeholder="Enter email" required>-->
                        <input type="text" class="form-control" value="<?= (!empty($artikel)) ? $artikel['id_artikel'] : '' ?>"
                          hidden name="id_artikel" id="id_artikel">
                        <textarea class="form-control" rows="10" id="judul-part-inp" name="judul-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['judul'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Judul tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-next-form">Next</button>

                    </div>
                    <div id="abstrak-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="abstrak-part-trigger">
                      <div class="form-group">
                        <label for="abstrak-part-inp">
                          <h3>Tuliskan abstrak artikel Saudara (Bahasa Indonesia)!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="abstrak-part-inp" name="abstrak-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['abstrak'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Abstrak tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="fokus-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="fokus-part-trigger">
                      <div class="form-group">
                        <label for="fokus-part-inp">
                          <h3>Jelaskan fokus pembahasan artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="fokus-part-inp" name="fokus-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['fokus'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Fokus tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="review-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="review-part-trigger">
                      <div class="form-group">
                        <label for="review-part-inp">
                          <h3>Jelaskan penelitian terdahulu (literatur review) yang relevan dengan kajian artikel Saudara!
                          </h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="review-part-inp" name="review-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['review'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Review penelitian terdahulu tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="posisi-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="posisi-part-trigger">
                      <div class="form-group">
                        <label for="posisi-part-inp">
                          <h3>Jelaskan posisi artikel Saudara dibanding penelitian-penelitian yang telah ada sebelumnya!
                          </h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="posisi-part-inp" name="posisi-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['posisi'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Posisi artikel tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="novelty-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="novelty-part-trigger">
                      <div class="form-group">
                        <label for="novelty-part-inp">
                          <h3>Jelaskan sisi kebaruan (novelty) artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="novelty-part-inp" name="novelty-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['novelty'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Novelty penelitian tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="metode-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="metode-part-trigger">
                      <div class="form-group">
                        <label for="metode-part-inp">
                          <h3>Jelaskan metode yang digunakan dalam artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="metode-part-inp" name="metode-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['metode'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Metode penelitian tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="kesimpulan-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="kesimpulan-part-trigger">
                      <div class="form-group">
                        <label for="kesimpulan-part-inp">
                          <h3>Tuliskan kesimpulan artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="kesimpulan-part-inp"
                          name="kesimpulan-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['kesimpulan'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Kesimpulan penelitian tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="referensi-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="referensi-part-trigger">
                      <div class="form-group">
                        <label for="referensi-part-inp">
                          <h3>Tuliskan daftar pustaka (referensi) artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="referensi-part-inp"
                          name="referensi-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['referensi'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Referensi artikel tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="sistematika-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="sistematika-part-trigger">
                      <div class="form-group">
                        <label for="sistematika-part-inp">
                          <h3>Tuliskan sistematika pembahasan dalam artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="sistematika-part-inp"
                          name="sistematika-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['sistematika'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Sistematika pembahasan tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="file-upload-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="file-upload-part-trigger">
                      <div class="form-group">
                        <label for="exampleInputFile">File Artikel</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                          </div>

                        </div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button type="button" onclick="simpan_ljk('uts','<?= $id_ljk ?>','<?= $perkuliahan['id'] ?>')"
                        class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          <?php } ?>

          <?php if ($jns_ujian == 'uas' && $perkuliahan['jns_uas'] == '2') { ?>
            <div class="card-body">
              <form class="form-horizontal" id="form_ljk" enctype="multipart/form-data">
                <div class="form-group">

                  <button type="button" onclick="simpan_ljk('uas','<?= $id_ljk ?>','<?= $perkuliahan['id'] ?>')"
                    class="btn btn-success">Submit</button>
                  <input type="hidden" name="catatan_pelanggaran" id="catatan_pelanggaran_uas" value="">
                </div>
                <div class="form-group">
                  <textarea class="form-control summernote" rows="10" id="ljk" name="ljk">
                                  <?= (!empty(getDataRow('data_ljk', ['id_ljk' => $id_ljk]))) ? str_replace('http://', 'https://', getDataRow('data_ljk', ['id_ljk' => $id_ljk])['ljk']) : '' ?>
                              </textarea>
                  <div class="invalid-feedback"></div>
                </div>


              </form>
            </div>
          <?php } ?>

          <?php if ($jns_ujian == 'uas' && $perkuliahan['jns_uas'] == '1') { ?>
            <?php
            $id_artikel = (!empty(getDataRow('data_ljk', ['id_ljk' => $id_ljk]))) ? getDataRow('data_ljk', ['id_ljk' => $id_ljk])['artikel'] : '';
            $artikel = (!empty($id_artikel)) ? getDataRow('tugas_artikel', ['id_artikel' => $id_artikel]) : '';
            ?>
            <div class="card-body p-0">
              <div class="bs-stepper">
                <div class="bs-stepper-header" role="tablist">
                  <!-- your steps here -->
                  <div class="step" data-target="#judul-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="judul-part"
                      id="judul-part-trigger">
                      <span class="bs-stepper-circle">1</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#abstrak-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="abstrak-part"
                      id="abstrak-part-trigger">
                      <span class="bs-stepper-circle">2</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#fokus-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="fokus-part"
                      id="fokus-part-trigger">
                      <span class="bs-stepper-circle">3</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#review-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="review-part"
                      id="review-part-trigger">
                      <span class="bs-stepper-circle">4</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#posisi-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="posisi-part"
                      id="posisi-part-trigger">
                      <span class="bs-stepper-circle">5</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#novelty-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="novelty-part"
                      id="novelty-part-trigger">
                      <span class="bs-stepper-circle">6</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#metode-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="metode-part"
                      id="metode-part-trigger">
                      <span class="bs-stepper-circle">7</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#kesimpulan-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="kesimpulan-part"
                      id="kesimpulan-part-trigger">
                      <span class="bs-stepper-circle">8</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#referensi-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="referensi-part"
                      id="referensi-part-trigger">
                      <span class="bs-stepper-circle">9</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#sistematika-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="sistematika-part"
                      id="sistematika-part-trigger">
                      <span class="bs-stepper-circle">10</span>
                    </button>
                  </div>
                  <div class="line"></div>
                  <div class="step" data-target="#file-upload-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="file-upload-part"
                      id="file-upload-part-trigger">
                      <span class="bs-stepper-circle">11</span>
                    </button>
                  </div>
                </div>
                <div class="bs-stepper-content">
                  <form class="needs-validation" id="form_ljk" onSubmit="return false" novalidate
                    enctype="multipart/form-data">
                    <input type="hidden" name="catatan_pelanggaran" id="catatan_pelanggaran_uas_artikel" value="">
                    <!-- your steps content here -->
                    <div id="judul-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="judul-part-trigger">
                      <div class="form-group">
                        <label for="judul-part-inp">
                          <h3>Tuliskan judul artikel Saudara!</h3>
                        </label>
                        <!--<input id="judul-part-inp" type="email" class="form-control" placeholder="Enter email" required>-->
                        <input type="text" class="form-control" value="<?= (!empty($artikel)) ? $artikel['id_artikel'] : '' ?>"
                          hidden name="id_artikel" id="id_artikel">
                        <textarea class="form-control" rows="10" id="judul-part-inp" name="judul-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['judul'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Judul tidak boleh kosong!!</div>
                      </div>

                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="abstrak-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="abstrak-part-trigger">
                      <div class="form-group">
                        <label for="abstrak-part-inp">
                          <h3>Tuliskan abstrak artikel Saudara (Bahasa Indonesia)!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="abstrak-part-inp" name="abstrak-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['abstrak'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Abstrak tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="fokus-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="fokus-part-trigger">
                      <div class="form-group">
                        <label for="fokus-part-inp">
                          <h3>Jelaskan fokus pembahasan artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="fokus-part-inp" name="fokus-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['fokus'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Fokus tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="review-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="review-part-trigger">
                      <div class="form-group">
                        <label for="review-part-inp">
                          <h3>Jelaskan penelitian terdahulu (literatur review) yang relevan dengan kajian artikel Saudara!
                          </h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="review-part-inp" name="review-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['review'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Review penelitian terdahulu tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="posisi-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="posisi-part-trigger">
                      <div class="form-group">
                        <label for="posisi-part-inp">
                          <h3>Jelaskan posisi artikel Saudara dibanding penelitian-penelitian yang telah ada sebelumnya!
                          </h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="posisi-part-inp" name="posisi-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['posisi'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Posisi artikel tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="novelty-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="novelty-part-trigger">
                      <div class="form-group">
                        <label for="novelty-part-inp">
                          <h3>Jelaskan sisi kebaruan (novelty) artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="novelty-part-inp" name="novelty-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['novelty'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Novelty penelitian tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="metode-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="metode-part-trigger">
                      <div class="form-group">
                        <label for="metode-part-inp">
                          <h3>Jelaskan metode yang digunakan dalam artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="metode-part-inp" name="metode-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['metode'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Metode penelitian tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="kesimpulan-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="kesimpulan-part-trigger">
                      <div class="form-group">
                        <label for="kesimpulan-part-inp">
                          <h3>Tuliskan kesimpulan artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="kesimpulan-part-inp"
                          name="kesimpulan-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['kesimpulan'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Kesimpulan penelitian tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="referensi-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="referensi-part-trigger">
                      <div class="form-group">
                        <label for="referensi-part-inp">
                          <h3>Tuliskan daftar pustaka (referensi) artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="referensi-part-inp"
                          name="referensi-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['referensi'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Referensi penelitian tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="sistematika-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="sistematika-part-trigger">
                      <div class="form-group">
                        <label for="sistematika-part-inp">
                          <h3>Tuliskan sistematika pembahasan dalam artikel Saudara!</h3>
                        </label>
                        <textarea class="form-control artikel" rows="10" id="sistematika-part-inp"
                          name="sistematika-part-inp">
                                      <?= (!empty($artikel)) ? $artikel['sistematika'] : '' ?>
                                  </textarea>
                        <div class="invalid-feedback">Sistematika penelitian tidak boleh kosong!!</div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button class="btn btn-primary btn-next-form">Next</button>
                    </div>
                    <div id="file-upload-part" class="bs-stepper-pane fade" role="tabpanel"
                      aria-labelledby="file-upload-part-trigger">
                      <div class="form-group">
                        <label for="exampleInputFile">File Artikel</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                          </div>

                        </div>
                      </div>
                      <button class="btn btn-primary btn-prev-form">Previous</button>
                      <button type="button" onclick="simpan_ljk('uas','<?= $id_ljk ?>','<?= $perkuliahan['id'] ?>')"
                        class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          <?php } ?>
          <?php if ($jns_ujian == 'tugas') { ?>
            <div class="card-body">
              <form class="form-horizontal" id="form_ljk" enctype="multipart/form-data">
                <div class="form-group">

                  <button type="button" onclick="simpan_ljk('tugas','<?= $id_ljk ?>','<?= $perkuliahan['id'] ?>')"
                    class="btn btn-success">Submit</button>

                </div>
                <div class="form-group">
                  <textarea class="form-control summernote" rows="10" id="ljk" name="ljk">
                                  <?= (!empty(getDataRow('data_ljk', ['id_ljk' => $id_ljk]))) ? str_replace('http://', 'https://', getDataRow('data_ljk', ['id_ljk' => $id_ljk])['tugas']) : '' ?>
                              </textarea>
                  <div class="invalid-feedback"></div>
                </div>


              </form>
            </div>
          <?php } ?>


        </div>


      </div>
    </section>
    <!-- /.content -->
  </div>

  <!-- ./wrapper -->
  <!-- Page specific script -->
  <!-- jQuery -->
  <script src="<?= base_url('assets'); ?>/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?= base_url('assets'); ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Summernote -->
  <script src="<?= base_url('assets'); ?>/plugins/summernote/summernote-bs4.min.js"></script>
  <script src="<?= base_url('assets'); ?>/plugins/summernote/summernote-file.js"></script>
  <script src="<?= base_url('assets'); ?>/plugins/summernote/summernote-ext-rtl.js"></script>

  <!-- BS-Stepper -->
  <script src="<?= base_url('assets'); ?>/plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- Select2 -->
  <script src="<?= base_url('assets'); ?>/plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="<?= base_url('assets'); ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="<?= base_url('assets'); ?>/plugins/toastr/toastr.min.js"></script>
  <!-- InputMask -->
  <script src="<?= base_url('assets'); ?>/plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- bs-custom-file-input -->
  <script src="<?= base_url('assets'); ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?= base_url('assets'); ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets'); ?>/dist/js/adminlte.js"></script>
  <script>
    // Listener for violation stats from Parent (React)
    window.addEventListener('message', function (event) {
      // Enhance security if needed: if (event.origin !== "http://localhost:5173") return;
      if (event.data && event.data.type === 'VIOLATION_UPDATE') {
        console.log("Received violation update:", event.data.payload);
        const stats = event.data.payload;
        const logString = `Log Aktivitas\nTab Switch: ${stats.tabSwitchCount}x\nFullscreen Exit: ${stats.fullscreenExitCount}x\nApp Switch: ${stats.appSwitchCount}x\nWajah Hilang: ${stats.noFaceCount}x`;

        // Set values to all hidden inputs we might have
        if (document.getElementById('catatan_pelanggaran_uts')) document.getElementById('catatan_pelanggaran_uts').value = logString;
        if (document.getElementById('catatan_pelanggaran_uas')) document.getElementById('catatan_pelanggaran_uas').value = logString;
        if (document.getElementById('catatan_pelanggaran_uts_artikel')) document.getElementById('catatan_pelanggaran_uts_artikel').value = logString;
        if (document.getElementById('catatan_pelanggaran_uas_artikel')) document.getElementById('catatan_pelanggaran_uas_artikel').value = logString;
      }
    });
  </script>
  <script>
    $(function () {
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
          ['view', ['undo', 'redo', 'fullscreen']],
        ],
        callbacks: {
          onPaste: function (e) {
            e.preventDefault();
            Swal.fire({
              title: "Ooooppsss....!",
              text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
              icon: "error",
            });
          },
          onImageUpload: function (image) {

            uploadImage(image[0]);
          },
          onMediaDelete: function (target) {
            deleteImage(target[0].src);
          },
          onFileUpload: function (file) {
            myOwnCallBack(file[0]);
          }
        }
      });

      $('#judul-part-inp').summernote({
        tabsize: 2,
        height: 50,
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
          ['view', ['undo', 'redo', 'fullscreen', 'help']],
        ],
        callbacks: {
          onPaste: function (e) {
            e.preventDefault();
            Swal.fire({
              title: "Ooooppsss....!",
              text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
              icon: "error",
            });
          },

        }
      });

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
          ['view', ['undo', 'redo', 'fullscreen', 'help']],
        ],
        callbacks: {
          onPaste: function (e) {
            e.preventDefault();
            Swal.fire({
              title: "Ooooppsss....!",
              text: "Mohon maaf, tidak diperbolehkan copy paste. Silahkan ketik jawaban anda pada tempat yang disediakan",
              icon: "error",
            });
          },

        }
      });

      //BS-Stepper Init
      var stepperFormEl = document.querySelector('.bs-stepper')
      window.stepperForm = new Stepper(stepperFormEl, {
        animation: true
      })

      var btnNextList = [].slice.call(document.querySelectorAll('.btn-next-form'))
      var btnPrevList = [].slice.call(document.querySelectorAll('.btn-prev-form'))
      var stepperPanList = [].slice.call(stepperFormEl.querySelectorAll('.bs-stepper-pane'))
      var judul = document.getElementById('judul-part-inp')
      var abstrak = document.getElementById('abstrak-part-inp')
      var fokus = document.getElementById('fokus-part-inp')
      var review = document.getElementById('review-part-inp')
      var posisi = document.getElementById('posisi-part-inp')
      var novelty = document.getElementById('novelty-part-inp')
      var metode = document.getElementById('metode-part-inp')
      var kesimpulan = document.getElementById('kesimpulan-part-inp')
      var referensi = document.getElementById('referensi-part-inp')
      var sistematika = document.getElementById('sistematika-part-inp')
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
          (stepperPan.getAttribute('id') === 'abstrak-part' && !abstrak.value.length) ||
          (stepperPan.getAttribute('id') === 'fokus-part' && !fokus.value.length) ||
          (stepperPan.getAttribute('id') === 'review-part' && !review.value.length) ||
          (stepperPan.getAttribute('id') === 'posisi-part' && !posisi.value.length) ||
          (stepperPan.getAttribute('id') === 'novelty-part' && !novelty.value.length) ||
          (stepperPan.getAttribute('id') === 'metode-part' && !metode.value.length) ||
          (stepperPan.getAttribute('id') === 'kesimpulan-part' && !kesimpulan.value.length) ||
          (stepperPan.getAttribute('id') === 'referensi-part' && !referensi.value.length) ||
          (stepperPan.getAttribute('id') === 'sistematika-part' && !sistematika.value.length)) {
          event.preventDefault()
          //form.classList.add('was-validated')
          //console.log('Moved to step ' + form.classList)
          $('#' + stepperPan.getAttribute('id') + '-inp').addClass('is-invalid');
        }
      })

    })

    function simpan_ljk(jns_ujian, id_ljk, id_mk) {

      var data = new FormData($("#form_ljk")[0]);
      data.append('jns_ujian', jns_ujian);
      data.append('id_ljk', id_ljk);
      data.append('id_mk', id_mk);
      $('#card_validasi').attr('hidden', true);
      $("#list_error").find("li").remove();
      $('#form_ljk').find('.invalid-feedback').text('');
      Swal.fire({
        title: 'Anda yakin akan menyimpan lembar jawaban ??',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
      }).then((result) => {

        if (result.isConfirmed) {
          $.ajax({
            url: "<?php echo site_url("akademik/$controller/$metode"); ?>",
            type: "post",
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function () {
              Swal.fire({
                title: 'Please Wait!!',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                  Swal.showLoading()
                },
              });
            },
            success: function (data) {
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
            error: function (xhr, ajaxOptions, thrownError) {
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

    function uploadImage(image) {
      var data = new FormData();
      data.append("image", image, image.name);
      $.ajax({
        url: "<?php echo site_url('summernote/upload_image') ?>",
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "POST",
        beforeSend: function () {
          Swal.fire({
            title: 'Please Wait!!',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
              Swal.showLoading()
            },
          });
        },
        success: function (url) {
          $('.summernote').summernote("insertImage", url);
          Swal.close();
        },
        error: function (xhr, ajaxOptions, thrownError) {
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
        url: "<?php echo site_url('summernote/delete_image') ?>",
        cache: false,
        success: function (response) {
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
        url: "<?php echo site_url('summernote/upload_file') ?>", //Your own back-end uploader
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
          Swal.fire({
            title: 'Please Wait!!',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
              Swal.showLoading()
            },
          });
        },
        success: function (url) {

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
            elem.setAttribute("src", "https://view.officeapps.live.com/op/embed.aspx?src=" + url);
            //elem.setAttribute("width", "100%");
            //elem.setAttribute("height", "600");
            elem.setAttribute("frameborder", "0");
            elem.setAttribute("scrolling", "yes");
            elem.setAttribute("seamless", "seamless");
            elem.setAttribute("style", "display:block; width:100%; height:100vh;");
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
  if ($session->getFlashdata('info') == 'cekal'):
    ?>
    <script type="text/javascript">
      Swal.fire({
        title: "Oooopppsss....!",
        text: "Maaf!! Anda dicekal mengikuti ujian UAS matakuliah <?= $perkuliahan['Mata_Kuliah'] ?>",
        icon: "warning",
        showConfirmButton: false,
        allowOutsideClick: false,
      });
    </script>
  <?php elseif ($session->getFlashdata('info') == 'tidak-hadir'): ?>
    <script type="text/javascript">
      Swal.fire({
        title: "Saudara tidak diijinkan mengakses soal Ujian. Silahkan konfirmasi kehadiran Saudara kepada pengawas di ruang ujian.",
        icon: "error",
        showConfirmButton: false,
        allowOutsideClick: false,
      });
    </script>
  <?php endif; ?>

</body>

</html>