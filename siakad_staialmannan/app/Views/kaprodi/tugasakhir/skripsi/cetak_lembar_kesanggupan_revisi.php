
  <style type="text/css">

    .textarea{
      float: left;
      padding-left: 16mm;
      padding-right: 12mm;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11pt;
      line-height: 1.35;
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
    <div style="text-align: center; "><strong>SURAT PERNYATAAN</strong></div>
    <div style="text-align: center;"><strong>KESANGGUPAN REVISI SKRIPSI</strong></div>
    <div style="text-align: center;"><strong>SEMESTER <?=getDataRow('tahun_akademik', ['kode' => $data['skripsi']['tahun_akademik']])['semester']==1?"GASAL":"GENAP";?> TAHUN AKADEMIK <?=getDataRow('tahun_akademik', ['kode' => $data['skripsi']['tahun_akademik']])['tahunAkademik'];?></strong></div>
    
    <div style="text-align: justify;">
      Yang bertandatangan di bawah ini: 
    </div>
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
    <div style="text-align: justify;">
      Berdasarkan hasil Sidang Munaqasyah Skripsi yang dilaksanakan pada  
    </div>
    <div style="width: 100%;">
      <div class="kolom1">Hari, Tanggal</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=(!empty($data['skripsi']['tgl_sidang']))?tgl_indonesia_date($data['skripsi']['tgl_sidang']):'';?></div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Tempat</div>
      <div class="kolom2">:</div>
      <div class="kolom3">Ruang Sidang Institut Agama Islam Bani Fattah Jombang</div>
    </div>
    <div style="text-align: justify;">
      menyatakan dengan sadar dan sukarela bahwa saya sanggup melakukan revisi skripsi selambat-lambatnya tanggal <strong>
      <?php
            $tgl_sidang = $data['skripsi']['tgl_sidang'];
            $tgl_revisi = date('Y-m-d', strtotime('+14 days', strtotime($tgl_sidang))); //operasi penjumlahan tanggal sebanyak 14 hari
            echo short_tgl_indonesia_date($tgl_revisi);
      ?></strong>.  
    </div>
    <div style="text-align: justify;">
      Apabila saya terbukti menyalahi pernyataan ini, maka saya siap melakukan sidang munaqasyah ulang. Demikian surat pernyataan ini kami buat dengan sebenar-benarnya.
    </div>
    <br>
    <div style="text-align: justify; ">Jombang, <?=(!empty($data['skripsi']['tgl_sidang']))?short_tgl_indonesia_date($data['skripsi']['tgl_sidang']):'';?></div>
    <div style="text-align: justify; "><strong>Peserta Munaqasyah,</strong></div>
    <br><br><br><br>
    <div style="text-align: justify; "><strong><u><?=ucwords(getDataRow('db_data_diri_mahasiswa', ['id'=>$data['id_data_diri']])['Nama_Lengkap']);?></u></strong></div>    
    <div style="text-align: justify; "><?=getDataRow('histori_pddk', ['id_his_pdk' => $data['skripsi']['id_his_pdk']])['NIM'];?></div> 
    <br>
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
    
    
  </div>

