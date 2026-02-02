
  <style type="text/css">

    .textarea{
      float: left;
      padding-left: 16mm;
      padding-right: 12mm;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 11pt;
      line-height: 1.5;
    }
    .kolom1{
      width: 25%;
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
      width: 70%; 
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
    <div style="text-align: center; "><strong>LEMBAR KEPUTUSAN</strong></div>
    <div style="text-align: center;"><strong>MAJELIS PENGUJI SEMINAR PROPOSAL SKRIPSI</strong></div>
    <div style="text-align: center;"><strong>SEMESTER <?=$proposal['semester']==1?"GASAL":"GENAP";?> TAHUN AKADEMIK <?=$proposal['tahunAkademik'];?></strong></div>
    <br>
    <div style="text-align: justify;">
      Dengan ini, Kami Majelis Penguji menyatakan bahwa mahasiswa dengan identitas:
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Nama</div>
      <div class="kolom2">:</div>
      <div class="kolom3">
        <div><?=ucwords($proposal['Nama_MHS']);?></div>
      </div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">NIM / NIMKO</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=$proposal['NIM'];?> / <?=$proposal['NIMKO'];?></div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Program Studi</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=$proposal['nm_prodi'];?></div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Judul</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=ucwords(strip_tags($proposal['judul']));?></div>
    </div>
    <br>
    
    <div style="text-align: justify;">
      telah melaksanakan Seminar Proposal Skripsi pada <?=longdate_indo($proposal['tgl_seminar']);?>. Berdasarkan unsur penilaian: (a) Materi dan Judul; (b) Penyampaian; (c) Metodologi Penelitian; (d) Teknik Penulisan dan Tata Bahasa, kami memberi penilaian dengan nilai (
     
      <strong>
          <span > D / </span>
          <span > C- / </span>
          <span > C / </span>
          <span > C+ / </span>
          <span > B- / </span>
          <span > B / </span>
          <span > B+ / </span>
          <span > A- / </span>
          <span > A / </span>
          <span > A+ </span>
    </strong>)*, dan menyatakan bahwa proposal tersebut:
    </div>
    <div style="width: 100%;">
        <div style="text-align: center; width:5%; border: 0.2mm solid #000000; float:left; ">&nbsp;</div>
        <div style="text-align: left; width:30%; margin-bottom: 5pt; float:left;">&nbsp;Lulus Tanpa Perbaikan</div>
        <div style="text-align: center; width:5%; border: 0.2mm solid #000000; float:left;">&nbsp;</div>
        <div style="text-align: left; width:30%; margin-bottom: 5pt; float:left;">&nbsp;Lulus Dengan Perbaikan</div>
        <div style="text-align: center; width:5%; border: 0.2mm solid #000000; float:left;">&nbsp;</div>
        <div style="text-align: left; width:20%; margin-bottom: 5pt; float:left;">&nbsp;Ditolak</div>
    </div>
    <div style="text-align: justify;">
      Waktu terakhir pengumpulan Proposal Skripsi yang telah direvisi adalah 
      
      <strong><?php
            $tgl_sidang = date_YMD($proposal['tgl_seminar']);
            $tgl_revisi = date('d-m-Y', strtotime('+14 days', strtotime($tgl_sidang))); //operasi penjumlahan tanggal sebanyak 14 hari
            echo date_indo($tgl_revisi);
      ?></strong>, dengan rekomendasi:
    </div>
    <div style="border-top: 1px dashed #000000; width: 0px; display: inline-block;"></div>
    <br><br><br><br><br><br><br><br><br><br>
        
    <br>
    <div style="border-top: 1px dashed #000000; width: 0px; display: inline-block;"></div>
    <div style="text-align: justify;">
      Demikian keputusan ini dibuat untuk diperhatikan dan dilaksanakan. 
    </div>
    <div style="width: 100%;">
      <div class="kolom1">Diputuskan di</div>
      <div class="kolom2">:</div>
      <div class="kolom3">Jombang</div>
    </div>
    <div style="width: 100%;">
      <div class="kolom1">Pada tanggal</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=date_indo($proposal['tgl_seminar']);?></div>
    </div>
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
                $jml_penguji = $penguji->num_rows();
				foreach ($penguji->result() as $r ) {
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
        			<td ><?=$r->Nama_Dosen;?></td>
        			<td style="text-align:center;"><?=$jabatan;?></td>
        			<td style="font-size: 10pt; vertical-align:top; text-align:right;"><?=$no2++;?></td>
        			<td colspan="<?=$jml_penguji;?>" style="font-size: 10pt; vertical-align:top;"></td>
        			
        		</tr>
        
        		<?php } ?>
        </tbody>
      </table>
    </div>
    
    
  </div>

