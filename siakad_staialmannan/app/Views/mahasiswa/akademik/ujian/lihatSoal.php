<?= $this->extend('layout/template_backend');?>
<?= $this->section('content');?>
<!-- summernote -->
<link rel="stylesheet" href="<?=base_url('assets');?>/plugins/summernote/summernote-bs4.min.css">
<!-- BS Stepper -->
  <link rel="stylesheet" href="<?=base_url('assets');?>/plugins/bs-stepper/css/bs-stepper.min.css">

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
                            if($perkuliahan['jns_uts'] == '2'){
                                echo $perkuliahan['uts_soal'];
                            }else{
                                echo "Soal berupa artikel. Silahkan kerjakan form di bawah ini!!";
                            }
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
                    LEMBAR JAWABAN
                </h3>
                
            </div>
            <?php   if($jns_ujian == 'uts' && $perkuliahan['jns_uts'] == '2'){    ?>
            <div class="card-body">
                    <form class="form-horizontal" id="form_uts" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea class="form-control summernote" rows="10" id="ljk" name="ljk"></textarea>
                        </div>
                        
                        <div class="form-group">                            
                            
                            <button type="button" onclick="simpan_ljk('uts')" class="btn btn-success">Submit</button>
                            
                        </div>
                    </form>
            </div>
            <?php } ?>
                
            <?php   if($jns_ujian == 'uts' && $perkuliahan['jns_uts'] == '1'){    ?>
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
                    <div class="step" data-target="#abstrak-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="abstrak-part" id="abstrak-part-trigger">
                        <span class="bs-stepper-circle">2</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#fokus-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="fokus-part" id="fokus-part-trigger">
                        <span class="bs-stepper-circle">3</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#review-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="review-part" id="review-part-trigger">
                        <span class="bs-stepper-circle">4</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#posisi-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="posisi-part" id="posisi-part-trigger">
                        <span class="bs-stepper-circle">5</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#novelty-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="novelty-part" id="novelty-part-trigger">
                        <span class="bs-stepper-circle">6</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#metode-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="metode-part" id="metode-part-trigger">
                        <span class="bs-stepper-circle">7</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#kesimpulan-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="kesimpulan-part" id="kesimpulan-part-trigger">
                        <span class="bs-stepper-circle">8</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#referensi-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="referensi-part" id="referensi-part-trigger">
                        <span class="bs-stepper-circle">9</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#sistematika-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="sistematika-part" id="sistematika-part-trigger">
                        <span class="bs-stepper-circle">10</span>
                      </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#file-upload-part">
                      <button type="button" class="step-trigger" role="tab" aria-controls="file-upload-part" id="file-upload-part-trigger">
                        <span class="bs-stepper-circle">11</span>
                      </button>
                    </div>
                  </div>
                  <div class="bs-stepper-content">
                      <form class="needs-validation" onSubmit="return false" novalidate>
                        <!-- your steps content here -->
                        <div id="judul-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="judul-part-trigger">
                          <div class="form-group">
                            <label for="judul-part-inp"><h3>Tuliskan judul artikel Saudara!</h3></label>
                            <!--<input id="judul-part-inp" type="email" class="form-control" placeholder="Enter email" required>-->
                            <textarea class="form-control" rows="10" id="judul-part-inp" name="judul-part-inp"></textarea>
                            <div class="invalid-feedback">Judul tidak boleh kosong!!</div>
                          </div>
                          
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="abstrak-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="abstrak-part-trigger">
                          <div class="form-group">
                            <label for="abstrak-part-inp"><h3>Tuliskan abstrak artikel Saudara (Bahasa Indonesia)!</h3></label>
                            <textarea class="form-control artikel" rows="10" id="abstrak-part-inp" name="abstrak-part-inp"></textarea>
                            <div class="invalid-feedback">Abstrak tidak boleh kosong!!</div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="fokus-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="fokus-part-trigger">
                          <div class="form-group">
                            <label for="fokus-part-inp"><h3>Jelaskan fokus pembahasan artikel Saudara!</h3></label>
                            <textarea class="form-control artikel" rows="10" id="fokus-part-inp" name="fokus-part-inp"></textarea>
                            <div class="invalid-feedback">Fokus tidak boleh kosong!!</div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="review-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="review-part-trigger">
                          <div class="form-group">
                            <label for="review-part-inp"><h3>Jelaskan penelitian terdahulu (literatur review) yang relevan dengan kajian artikel Saudara!</h3></label>
                            <textarea class="form-control artikel" rows="10" id="review-part-inp" name="review-part-inp"></textarea>
                            <div class="invalid-feedback">Review penelitian terdahulu tidak boleh kosong!!</div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="posisi-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="posisi-part-trigger">
                          <div class="form-group">
                            <label for="posisi-part-inp"><h3>Jelaskan posisi artikel Saudara dibanding penelitian-penelitian yang telah ada sebelumnya!</h3></label>
                            <textarea class="form-control artikel" rows="10" id="posisi-part-inp" name="posisi-part-inp"></textarea>
                            <div class="invalid-feedback">Posisi artikel tidak boleh kosong!!</div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="novelty-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="novelty-part-trigger">
                          <div class="form-group">
                            <label for="posisi-part-inp"><h3>Jelaskan sisi kebaruan (novelty) artikel Saudara!</h3></label>
                            <textarea class="form-control artikel" rows="10" id="novelty-part-inp" name="novelty-part-inp"></textarea>
                            <div class="invalid-feedback">Novelty penelitian tidak boleh kosong!!</div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="metode-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="metode-part-trigger">
                          <div class="form-group">
                            <label for="posisi-part-inp"><h3>Jelaskan metode yang digunakan dalam artikel Saudara!</h3></label>
                            <textarea class="form-control artikel" rows="10" id="metode-part-inp" name="metode-part-inp"></textarea>
                            <div class="invalid-feedback">Metode penelitian tidak boleh kosong!!</div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="kesimpulan-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="kesimpulan-part-trigger">
                          <div class="form-group">
                            <label for="posisi-part-inp"><h3>Tuliskan kesimpulan artikel Saudara!</h3></label>
                            <textarea class="form-control artikel" rows="10" id="kesimpulan-part-inp" name="kesimpulan-part-inp"></textarea>
                            <div class="invalid-feedback">Kesimpulan penelitian tidak boleh kosong!!</div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="referensi-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="referensi-part-trigger">
                          <div class="form-group">
                            <label for="posisi-part-inp"><h3>Tuliskan daftar pustaka (referensi) artikel Saudara!</h3></label>
                            <textarea class="form-control artikel" rows="10" id="referensi-part-inp" name="referensi-part-inp"></textarea>
                            <div class="invalid-feedback">Referensi penelitian tidak boleh kosong!!</div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="sistematika-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="sistematika-part-trigger">
                          <div class="form-group">
                            <label for="posisi-part-inp"><h3>Tuliskan sistematika pembahasan dalam artikel Saudara!</h3></label>
                            <textarea class="form-control artikel" rows="10" id="sistematika-part-inp" name="sistematika-part-inp"></textarea>
                            <div class="invalid-feedback">Sistematika penelitian tidak boleh kosong!!</div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button class="btn btn-primary btn-next-form" >Next</button>
                        </div>
                        <div id="file-upload-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="file-upload-part-trigger">
                          <div class="form-group">
                            <label for="exampleInputFile">File Artikel</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                              </div>
                            </div>
                          </div>
                          <button class="btn btn-primary btn-prev-form" >Previous</button>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                  </div>
                </div>
            </div>
                    
            <?php } ?>
                
            <?php   if($jns_ujian == 'uas' && $perkuliahan['jns_uas'] == '2'){    ?>
            <div class="card-body">
                    <form class="form-horizontal" id="form_uas" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea class="form-control summernote" rows="10" id="ljk" name="ljk"></textarea>
                        </div>
                        
                        <div class="form-group">                            
                            
                            <button type="button" onclick="simpan_ljk('uas')" class="btn btn-success">Submit</button>
                            
                        </div>
                    </form>
            </div>
            <?php } ?>
                
            <?php   if($jns_ujian == 'uas' && $perkuliahan['jns_uas'] == '1'){    ?>
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
                        <div class="step" data-target="#abstrak-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="abstrak-part" id="abstrak-part-trigger">
                            <span class="bs-stepper-circle">2</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#fokus-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="fokus-part" id="fokus-part-trigger">
                            <span class="bs-stepper-circle">3</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#review-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="review-part" id="review-part-trigger">
                            <span class="bs-stepper-circle">4</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#posisi-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="posisi-part" id="posisi-part-trigger">
                            <span class="bs-stepper-circle">5</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#novelty-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="novelty-part" id="novelty-part-trigger">
                            <span class="bs-stepper-circle">6</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#metode-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="metode-part" id="metode-part-trigger">
                            <span class="bs-stepper-circle">7</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#kesimpulan-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="kesimpulan-part" id="kesimpulan-part-trigger">
                            <span class="bs-stepper-circle">8</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#referensi-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="referensi-part" id="referensi-part-trigger">
                            <span class="bs-stepper-circle">9</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#sistematika-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="sistematika-part" id="sistematika-part-trigger">
                            <span class="bs-stepper-circle">10</span>
                          </button>
                        </div>
                        <div class="line"></div>
                        <div class="step" data-target="#file-upload-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="file-upload-part" id="file-upload-part-trigger">
                            <span class="bs-stepper-circle">11</span>
                          </button>
                        </div>
                      </div>
                      <div class="bs-stepper-content">
                          <form class="needs-validation" onSubmit="return false" novalidate>
                            <!-- your steps content here -->
                            <div id="judul-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="judul-part-trigger">
                              <div class="form-group">
                                <label for="judul-part-inp"><h3>Tuliskan judul artikel Saudara!</h3></label>
                                <!--<input id="judul-part-inp" type="email" class="form-control" placeholder="Enter email" required>-->
                                <textarea class="form-control" rows="10" id="judul-part-inp" name="judul-part-inp"></textarea>
                                <div class="invalid-feedback">Judul tidak boleh kosong!!</div>
                              </div>
                              
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="abstrak-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="abstrak-part-trigger">
                              <div class="form-group">
                                <label for="abstrak-part-inp"><h3>Tuliskan abstrak artikel Saudara (Bahasa Indonesia)!</h3></label>
                                <textarea class="form-control artikel" rows="10" id="abstrak-part-inp" name="abstrak-part-inp"></textarea>
                                <div class="invalid-feedback">Abstrak tidak boleh kosong!!</div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="fokus-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="fokus-part-trigger">
                              <div class="form-group">
                                <label for="fokus-part-inp"><h3>Jelaskan fokus pembahasan artikel Saudara!</h3></label>
                                <textarea class="form-control artikel" rows="10" id="fokus-part-inp" name="fokus-part-inp"></textarea>
                                <div class="invalid-feedback">Fokus tidak boleh kosong!!</div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="review-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="review-part-trigger">
                              <div class="form-group">
                                <label for="review-part-inp"><h3>Jelaskan penelitian terdahulu (literatur review) yang relevan dengan kajian artikel Saudara!</h3></label>
                                <textarea class="form-control artikel" rows="10" id="review-part-inp" name="review-part-inp"></textarea>
                                <div class="invalid-feedback">Review penelitian terdahulu tidak boleh kosong!!</div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="posisi-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="posisi-part-trigger">
                              <div class="form-group">
                                <label for="posisi-part-inp"><h3>Jelaskan posisi artikel Saudara dibanding penelitian-penelitian yang telah ada sebelumnya!</h3></label>
                                <textarea class="form-control artikel" rows="10" id="posisi-part-inp" name="posisi-part-inp"></textarea>
                                <div class="invalid-feedback">Posisi artikel tidak boleh kosong!!</div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="novelty-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="novelty-part-trigger">
                              <div class="form-group">
                                <label for="posisi-part-inp"><h3>Jelaskan sisi kebaruan (novelty) artikel Saudara!</h3></label>
                                <textarea class="form-control artikel" rows="10" id="novelty-part-inp" name="novelty-part-inp"></textarea>
                                <div class="invalid-feedback">Novelty penelitian tidak boleh kosong!!</div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="metode-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="metode-part-trigger">
                              <div class="form-group">
                                <label for="posisi-part-inp"><h3>Jelaskan metode yang digunakan dalam artikel Saudara!</h3></label>
                                <textarea class="form-control artikel" rows="10" id="metode-part-inp" name="metode-part-inp"></textarea>
                                <div class="invalid-feedback">Metode penelitian tidak boleh kosong!!</div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="kesimpulan-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="kesimpulan-part-trigger">
                              <div class="form-group">
                                <label for="posisi-part-inp"><h3>Tuliskan kesimpulan artikel Saudara!</h3></label>
                                <textarea class="form-control artikel" rows="10" id="kesimpulan-part-inp" name="kesimpulan-part-inp"></textarea>
                                <div class="invalid-feedback">Kesimpulan penelitian tidak boleh kosong!!</div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="referensi-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="referensi-part-trigger">
                              <div class="form-group">
                                <label for="posisi-part-inp"><h3>Tuliskan daftar pustaka (referensi) artikel Saudara!</h3></label>
                                <textarea class="form-control artikel" rows="10" id="referensi-part-inp" name="referensi-part-inp"></textarea>
                                <div class="invalid-feedback">Referensi penelitian tidak boleh kosong!!</div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="sistematika-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="sistematika-part-trigger">
                              <div class="form-group">
                                <label for="posisi-part-inp"><h3>Tuliskan sistematika pembahasan dalam artikel Saudara!</h3></label>
                                <textarea class="form-control artikel" rows="10" id="sistematika-part-inp" name="sistematika-part-inp"></textarea>
                                <div class="invalid-feedback">Sistematika penelitian tidak boleh kosong!!</div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button class="btn btn-primary btn-next-form" >Next</button>
                            </div>
                            <div id="file-upload-part" class="bs-stepper-pane fade" role="tabpanel" aria-labelledby="file-upload-part-trigger">
                              <div class="form-group">
                                <label for="exampleInputFile">File Artikel</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                  </div>
                                  <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                  </div>
                                </div>
                              </div>
                              <button class="btn btn-primary btn-prev-form" >Previous</button>
                              <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                          </form>
                      </div>
                    </div>
                  </div>
                
            <?php } ?>
            <?php   if($jns_ujian == 'tugas'){    ?>
            <div class="card-body">
                    <form class="form-horizontal" id="form_uas" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea class="form-control summernote" rows="10" id="ljk" name="ljk"></textarea>
                        </div>
                        
                        <div class="form-group">                            
                            
                            <button type="button" onclick="simpan_ljk('tugas')" class="btn btn-success">Submit</button>
                            
                        </div>
                    </form>
            </div>
            <?php } ?>
                
            
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

<!-- BS-Stepper -->
<script src="<?=base_url('assets');?>/plugins/bs-stepper/js/bs-stepper.min.js"></script>


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
        (stepperPan.getAttribute('id') === 'fokus-part' && !fokus.value.length)||
        (stepperPan.getAttribute('id') === 'review-part' && !review.value.length)||
        (stepperPan.getAttribute('id') === 'posisi-part' && !posisi.value.length)||
        (stepperPan.getAttribute('id') === 'novelty-part' && !novelty.value.length)||
        (stepperPan.getAttribute('id') === 'metode-part' && !metode.value.length)||
        (stepperPan.getAttribute('id') === 'kesimpulan-part' && !kesimpulan.value.length)||
        (stepperPan.getAttribute('id') === 'referensi-part' && !referensi.value.length)||
        (stepperPan.getAttribute('id') === 'sistematika-part' && !sistematika.value.length)) {
          event.preventDefault()
          //form.classList.add('was-validated')
          //console.log('Moved to step ' + form.classList)
          $('#' +stepperPan.getAttribute('id')+'-inp').addClass('is-invalid');
        }
    })
})



// BS-Stepper Init
/*
  document.addEventListener('DOMContentLoaded', function () {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'), {
        animation: true
      })
    
  })
*/
  
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