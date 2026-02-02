
  <style type="text/css">

    .textarea{
      float: left;
      padding-left: 16mm;
      padding-right: 12mm;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11pt;
      line-height: 1.4;
    }
    .kolom1{
      width: 20%;
      float: left;
      font-family: Arial, Helvetica, sans-serif;
     
    }
    .kolom2{
      width: 5%; 
      float: left;
      text-align: center;
      font-family: Arial, Helvetica, sans-serif;
      
    }
    .kolom3{
      width: 75%; 
      float: left;
      font-family: Arial, Helvetica, sans-serif;
    }

    .ttd{
        
    float: right;
    width: 8cm;
    height: 5cm;
    padding-left: 15mm;
  }
  td
    {
      height:40px;
    }
    .strike{
        text-decoration: line-through underline overline wavy;
      
    }
    /*.strike {
      text-decoration: none;
      background-image: -webkit-linear-gradient(transparent 7px,#cc1f1f 7px,#cc1f1f 9px,transparent 9px);
      background-image:    -moz-linear-gradient(transparent 7px,#cc1f1f 7px,#cc1f1f 9px,transparent 9px);
      background-image:     -ms-linear-gradient(transparent 7px,#cc1f1f 7px,#cc1f1f 9px,transparent 9px);
      background-image:      -o-linear-gradient(transparent 7px,#cc1f1f 7px,#cc1f1f 9px,transparent 9px);
      background-image:         linear-gradient(transparent 7px,#cc1f1f 7px,#cc1f1f 9px,transparent 9px);
    }*/
    
  </style>

  <div class="textarea">
    <div style="text-align: center; "><strong>LEMBAR NILAI</strong></div>
    <div style="text-align: center;"><strong>SIDANG MUNAQASYAH SKRIPSI</strong></div>
    <div style="text-align: center;"><strong>SEMESTER <?=getDataRow('tahun_akademik', ['kode' => $data['skripsi']['tahun_akademik']])['semester']==1?"GASAL":"GENAP";?> TAHUN AKADEMIK <?=getDataRow('tahun_akademik', ['kode' => $data['skripsi']['tahun_akademik']])['tahunAkademik'];?></strong></div>
    <br>
    
    <div style="width: 100%;">
      <div class="kolom1">Nama</div>
      <div class="kolom2">:</div>
      <div class="kolom3">
        <div><?=ucwords(getDataRow('db_data_diri_mahasiswa', ['id'=>$data['id_data_diri']])['Nama_Lengkap']);?></div>
      </div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">NIM</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=getDataRow('histori_pddk', ['id_his_pdk' => $data['skripsi']['id_his_pdk']])['NIM'];?></div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Program Studi</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['skripsi']['id_his_pdk']])['Prodi']])['nm_prodi'];?></div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Fakultas</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['skripsi']['id_his_pdk']])['Prodi']])['fakultas'];?></div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Judul</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=strtoupper(strip_tags($data['skripsi']['judul_skripsi']));?></div>
    </div>
    <br>
   
    <div style="text-align: center; "><strong>NILAI</strong></div>
    <div style="width: 100%; float: left;">
      <table width="100%" style=" topntail: 0.02cm solid #000000; font-family: 'Tahoma', sans-serif; font-size: 12pt;" border="0" autosize="1.8">
        <thead >
          <tr >
            <th style="text-align:center;" width="5%">No.</th>
            <th style="text-align:center;" width="25%">Unsur Penilaian</th>
            <th style="text-align:center;" width="15%">Interval Skor</th>
            <th style="text-align:center;">Penguji 1</th>
            <th style="text-align:center;">Penguji 2</th>
            <th style="text-align:center;">Total</th>
            <th style="text-align:center;">Rata-Rata</th>
          </tr>
        </thead>
        <tbody>

    		<tr>
    		    <?php 
				        $nilai1 = getDataRow('hasil_skripsi', ['id_munaqasyah' => $data['skripsi']['id_munaqasyah'], 'penguji' => '1']);
                        $nilai2 = getDataRow('hasil_skripsi', ['id_munaqasyah' => $data['skripsi']['id_munaqasyah'], 'penguji' => '2']);
                        $nilai3 = getDataRow('hasil_skripsi', ['id_munaqasyah' => $data['skripsi']['id_munaqasyah'], 'penguji' => '3']);
                ?>
    			<td style="text-align:center;">1</td>
    			<td >Penyampaian</td>
    			<td style="text-align:center;">1 - 10</td>
    			<td style="text-align:center;"><?=(!empty($nilai1))?number_format($nilai1['penyampaian'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai2))?number_format($nilai2['penyampaian'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format($nilai1['penyampaian']+$nilai2['penyampaian'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format(($nilai1['penyampaian']+$nilai2['penyampaian'])/2,2):'';?></td>
    		</tr>
    		<tr>
    			<td style="text-align:center;">2</td>
    			<td >Teknik Penulisan</td>
    			<td style="text-align:center;">1 - 25</td>
    			<td style="text-align:center;"><?=(!empty($nilai1))?number_format($nilai1['penulisan'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai2))?number_format($nilai2['penulisan'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format($nilai1['penulisan']+$nilai2['penulisan'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format(($nilai1['penulisan']+$nilai2['penulisan'])/2,2):'';?></td>
    		</tr>
    		<tr>
    			<td style="text-align:center;">3</td>
    			<td >Ketepatan Metode</td>
    			<td style="text-align:center;">1 - 25</td>
    			<td style="text-align:center;"><?=(!empty($nilai1))?number_format($nilai1['metode'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai2))?number_format($nilai2['metode'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format($nilai1['metode']+$nilai2['metode'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format(($nilai1['metode']+$nilai2['metode'])/2,2):'';?></td>
    		</tr>
    		<tr>
    			<td style="text-align:center;">4</td>
    			<td >Konten</td>
    			<td style="text-align:center;">1 - 40</td>
    			<td style="text-align:center;"><?=(!empty($nilai1))?number_format($nilai1['konten'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai2))?number_format($nilai2['konten'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format($nilai1['konten']+$nilai2['konten'],2):'';?></td>
    			<td style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format(($nilai1['konten']+$nilai2['konten'])/2,2):'';?></td>
    		</tr>
    		
          
        </tbody>
        <tfoot >
            <tr>
    			<th colspan="2" style="text-align:center;">Total</th>
    			<th style="text-align:center;">100</th>
    			<th style="text-align:center;"><?=(!empty($nilai1))?number_format($nilai1['penyampaian']+$nilai1['penulisan']+$nilai1['metode']+$nilai1['konten'],2):'';?></th>
    			<th style="text-align:center;"><?=(!empty($nilai2))?number_format($nilai2['penyampaian']+$nilai2['penulisan']+$nilai2['metode']+$nilai2['konten'],2):'';?></th>
    			<th style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format($nilai1['penyampaian']+$nilai1['penulisan']+$nilai1['metode']+$nilai1['konten']+$nilai2['penyampaian']+$nilai2['penulisan']+$nilai2['metode']+$nilai2['konten'],2):'';?></th>
    			<th style="text-align:center;"><?=(!empty($nilai1) && !empty($nilai2))?number_format(($nilai1['penyampaian']+$nilai1['penulisan']+$nilai1['metode']+$nilai1['konten']+$nilai2['penyampaian']+$nilai2['penulisan']+$nilai2['metode']+$nilai2['konten'])/2,2):'';?></th>
    		</tr>
        </tfoot>
      </table>
    </div>
    <br>
    <div style="text-align: center; ">Jombang, <?=(!empty($data['skripsi']['tgl_sidang']))?short_tgl_indonesia_date($data['skripsi']['tgl_sidang']):'';?></div>
    <div style="text-align: center; "><strong>MAJELIS PENGUJI</strong></div>
    <div style="width: 100%; float: left;">
      <table width="100%" style=" topntail: 0.02cm solid #000000; font-family: Arial, Helvetica, sans-serif;; font-size: 11pt;" border="0" autosize="1.8">
        <thead >
          <tr >
            <th>No.</th>
            <th style="text-align:left;" width="50%">Nama</th>
            <th  style="text-align:left;">Jabatan</th>
            <th colspan="2" style="text-align:left;">Tanda Tangan</th>
          </tr>
        </thead>
        <tbody>
          <?php 
				$no = 1;
				$no2 = 1;
                $jml_penguji = getCount('penguji_skripsi', ['id_munaqasyah' => $data['skripsi']['id_munaqasyah']],null, 'kd_dosen')['kd_dosen'];
                $penguji = dataDinamis('penguji_skripsi', ['id_munaqasyah' => $data['skripsi']['id_munaqasyah']], 'tugas ASC');
				foreach ($penguji as $r ) {
				    if($r->tugas==1){
				        $jabatan = "Penguji 1";
				    }elseif($r->tugas==2){
				        $jabatan = "Penguji 2";
				    }else{
				        $jabatan = "Pimpinan Sidang";
				    }
				    
				?>
        		<tr>
        			<td style="text-align:center;"><?=$no++;?></td>
        			<td ><?=(!empty($r->kd_dosen))?getDataRow('data_dosen', ['Kode' => $r->kd_dosen])['Nama_Dosen']:'';?></td>
        			<td style="text-align:left;"><?=$jabatan;?></td>
        			<td style="font-size: 10pt; vertical-align:top; text-align:right;"><?=$no2++;?></td>
        			<td colspan="<?=$jml_penguji;?>" style="font-size: 10pt; vertical-align:top;"><img src="<?=$data['qrcode'];?>" width="75" height="75"></td>
        			
        		</tr>
        
        		<?php } ?>
        </tbody>
      </table>
    </div>
    <div style="text-align: justify;">
      Catatan :
    </div>
    <div style="border-top: 1px dashed #000000; width: 0px; display: inline-block;"></div>
    <br>
    <?php if(!empty($nilai1) || !empty($nilai2)){ ?>
        <table width="100%" style=" topntail: 0.02cm solid #000000; font-family: Arial, Helvetica, sans-serif;; font-size: 9pt;" border="0" autosize="1.8">
            <thead >

              <tr >
                <th  width="10%">Aspek</th>
                <th >Penguji 1</th>
                <th >Penguji 2</th>
                <th >Ketua</th>
              </tr>
            </thead>
            <tbody>
                <tr >    			
              	<td style="vertical-align:top;">Cover, Motto, Halaman Persembahan, dll.</td>
        			<td style="vertical-align:top;"><?=(!empty($nilai1))?$nilai1['bag_depan']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai2))?$nilai2['bag_depan']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai3))?$nilai3['bag_depan']:'';?></td>
        		</tr>
              	
              	<tr >    			
              	<td style="vertical-align:top;">BAB I</td>
        			<td style="vertical-align:top;"><?=(!empty($nilai1))?$nilai1['bab1']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai2))?$nilai2['bab1']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai3))?$nilai3['bab1']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">BAB II</td>
        			<td style="vertical-align:top;"><?=(!empty($nilai1))?$nilai1['bab2']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai2))?$nilai2['bab2']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai3))?$nilai3['bab2']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">BAB III</td>
        			<td style="vertical-align:top;"><?=(!empty($nilai1))?$nilai1['bab3']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai2))?$nilai2['bab3']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai3))?$nilai3['bab3']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">BAB IV</td>
        			<td style="vertical-align:top;"><?=(!empty($nilai1))?$nilai1['bab4']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai2))?$nilai2['bab4']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai3))?$nilai3['bab4']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">BAB V</td>
        			<td style="vertical-align:top;"><?=(!empty($nilai1))?$nilai1['bab5']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai2))?$nilai2['bab5']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai3))?$nilai3['bab5']:'';?></td>
        		</tr>
        		<?php if(!empty($data['skripsi']['bab6'])){ ?>
        		<tr>
        			<td style="vertical-align:top;">BAB VI</td>
        			<td style="vertical-align:top;"><?=(!empty($nilai1))?$nilai1['bab6']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai2))?$nilai2['bab6']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai3))?$nilai3['bab6']:'';?></td>
        		</tr>
        		<?php } ?>
        		<tr>
        			<td style="vertical-align:top;">Daftar Pustaka</td>
        			<td style="vertical-align:top;"><?=(!empty($nilai1))?$nilai1['pustaka']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai2))?$nilai2['pustaka']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai3))?$nilai3['pustaka']:'';?></td>
        		</tr>
        		<?php if(!empty($data['skripsi']['lampiran'])){ ?>
        		<tr>
        			<td style="vertical-align:top;">Lampiran-lampiran</td>
        			<td style="vertical-align:top;"><?=(!empty($nilai1))?$nilai1['lampiran']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai2))?$nilai2['lampiran']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($nilai3))?$nilai3['lampiran']:'';?></td>
        		</tr>
        		<?php } ?>
            </tbody>
          </table>
    <?php }else{ ?>
    <br><br><br><br><br><br><br><br><br><br>
    <?php } ?>
    <br>
    <div style="border-top: 1px dashed #000000; width: 0px; display: inline-block;"></div>
    
  </div>

