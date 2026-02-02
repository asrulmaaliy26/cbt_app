    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-edit"></i>
            
        </h3>
        <div class="card-tools">
            <!--
                <a role="button" class="btn btn-success btn-xs" title="Tambah" data-palcement="top"  href="javascript:void(0)" data-toggle="modal" data-target="#tambahModal">
                    <i class="fa fa-plus"></i> Tambah MK
                </a>
            -->
            <a  href="<?=base_url("akademik/$controller/cetakTranskrip?id_his_pdk=").$id_his_pdk."&tgl=".$tgl?>" target="_blank" role="button" class="btn btn-primary btn-sm" style="margin-right: 5px;">
            <i class="fas fa-print"></i> Cetak
          </a>
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body">
    <?php 
        if(!empty($his_pdk)){
    ?>
        <div class="row">
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td width="30%">Nama Mahasiswa</td>
                            <td width="70%">
                                : <?=ucwords(getDataRow('db_data_diri_mahasiswa', ['id' => $his_pdk['id_data_diri']])['Nama_Lengkap'])?>
                            </td>
                            
                        </tr>
                        <tr>
                            <td width="30%">NIM / NPM</td>
                            <td width="70%">: <?=$his_pdk['NIM']?> / <?=$his_pdk['NIMKO']?></td>
                            
                        </tr>
                        <tr>
                            <td width="30%">Tahun Masuk</td>
                            <td width="70%">: <?=getDataRow('db_data_diri_mahasiswa', ['id' => $his_pdk['id_data_diri']])['th_angkatan']?></td>
                        </tr>
                        
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td width="30%">Fakultas</td>
                            <td width="70%">
                                : <?=ucwords(getDataRow('prodi', ['singkatan'=>$his_pdk['Prodi']])['fakultas'])?>
                            </td>
                        </tr>
                        <tr>

                            <td width="30%">Program Studi</td>
                            <td width="70%">: <?=ucwords(getDataRow('prodi', ['singkatan'=>$his_pdk['Prodi']])['nm_prodi'])?></td>
                        </tr>
                        <tr>

                            <td width="30%">Kelas Perkuliahan</td>
                            <td width="70%">: <?=$his_pdk['Program']?></td>
                        </tr>
                        
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row">
    <?php }
        if(!empty($nilai)){
           $arrays = array_chunk($nilai, ceil(count($nilai) / 2));
           //dd($arrays);
           $no = 1;
           $jmlSks = 0;
           $mutu = 0;
           $jmlMutu = 0;
           foreach($arrays as $chunk){

    ?>
        <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%" class="text-center">No</th>
                                <th width="60%" class="text-center">Mata Kuliah</th>
                                <th width="10%" class="text-center">SKS</th>
                                <th width="10%" class="text-center">NA</th>
                                <th width="10%" class="text-center">NH</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($chunk as $subarray) { //dd($subarray)
                                    $jmlSks += $subarray->SKS;
                                    $mutu = number_format($subarray->am, 2) * $subarray->SKS;
                                    $jmlMutu += $mutu;
                            ?>
                                    
                            <tr>
                                <td class="text-center"><?=$no++?></td>
                                <td ><?=$subarray->nama_mk?></td>
                                <td class="text-center"><?=$subarray->SKS?></td>
                                <td class="text-center"><?=number_format($subarray->am, 2)?></td>
                                <td class="text-center"><?=$subarray->hm?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
    <?php } } $ipk = number_format(($jmlMutu/$jmlSks), 2);?>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tr>
                        <td width="20%">TOTAL SKS</td>
                        <td width="80%">: <?=$jmlSks?></td>
                        
                    </tr>
                    <tr>
                        <td width="20%">INDEKS PRESTASI KUMULATIF</td>
                        <td width="80%">: <?=$ipk?></td>
                        
                    </tr>
                    <tr>
                        <td width="20%">PREDIKAT KELULUSAN</td>
                        <td width="80%">: 
                            <?php
                                if($ipk > 3.75){
                                    echo "Cumlaude";
                                }
                                if($ipk > 3.50 && $ipk <= 3.75){
                                    echo "Sangat Memuaskan";
                                }
                                if($ipk > 3.00 && $ipk <= 3.50){
                                    echo "Memuaskan";
                                }
                                if($ipk <= 3.00){
                                    echo "-";
                                }
                            ?>
                        </td>
                    </tr>
                    
                </table>
            </div>
        </div>
    </div>