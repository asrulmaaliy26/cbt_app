
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
    <div style="text-align: center;"><strong>SEMESTER <?=getDataRow('tahun_akademik', ['kode' => $data['proposal']['tahun']])['semester']==1?"GASAL":"GENAP";?> TAHUN AKADEMIK <?=getDataRow('tahun_akademik', ['kode' => $data['proposal']['tahun']])['tahunAkademik'];?></strong></div>
    <br>
    <div style="text-align: justify;">
      Dengan ini, Kami Majelis Penguji menyatakan bahwa mahasiswa dengan identitas:
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Nama</div>
      <div class="kolom2">:</div>
      <div class="kolom3">
        <div><?=ucwords(getDataRow('db_data_diri_mahasiswa', ['id'=>$data['id_data_diri']])['Nama_Lengkap']);?></div>
      </div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">NIM / NIMKO</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=getDataRow('histori_pddk', ['id_his_pdk' => $data['proposal']['id_his_pdk']])['NIM'];?></div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Program Studi</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['proposal']['id_his_pdk']])['Prodi']])['nm_prodi'];?></div>
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">Judul</div>
      <div class="kolom2">:</div>
      <div class="kolom3"><?=ucwords(strip_tags($data['proposal']['judul']));?></div>
    </div>
    <br>
    
    <div style="text-align: justify;">
      telah melaksanakan Seminar Proposal Skripsi pada <?=(!empty($data['proposal']['tgl_seminar']))?tgl_indonesia_date($data['proposal']['tgl_seminar']):'';?>. Berdasarkan unsur penilaian: (a) Materi dan Judul; (b) Penyampaian; (c) Metodologi Penelitian; (d) Teknik Penulisan dan Tata Bahasa, kami memberi penilaian dengan nilai (
     
      <strong>
            <?php
                $komen1 = getDataRow('hasil_sempro', ['id_sempro' => $data['proposal']['id'], 'penguji' => '1']);
                $komen2 = getDataRow('hasil_sempro', ['id_sempro' => $data['proposal']['id'], 'penguji' => '2']);
                if(!empty($komen1['nilai']) && !empty($komen2['nilai'])){
                    $nilai = number_format(($komen1['nilai']+$komen2['nilai'])/2,2);
            		$grade_nilai=  dataDinamis('grade_nilai');
            		foreach ($grade_nilai as $s)
                    {
                        if($nilai >=$s->batas_bawah and $nilai <= $s->batas_atas)
                        {
                            $predikat= $s->grade;
                        }
                    }
                }
                
                if(!empty($komen1['rekom']) && !empty($komen2['rekom'])){
                    if($komen1['rekom']==1 || $komen2['rekom']==1){
                        $rekom = 1;
                    }elseif($komen1['rekom']==2 || $komen2['rekom']==2){
                        $rekom = 2;
                    }elseif($komen1['rekom']==3 || $komen2['rekom']==3){
                        $rekom = 3;
                    }
                }
                if(isset($predikat)){
            ?>
          <span <?=$predikat=='D'?'':'class="strike"';?>> D / </span>
          <span <?=$predikat=='C-'?'':'class="strike"';?>> C- / </span>
          <span <?=$predikat=='C'?'':'class="strike"';?>> C / </span>
          <span <?=$predikat=='C+'?'':'class="strike"';?>> C+ / </span>
          <span <?=$predikat=='B-'?'':'class="strike"';?>> B- / </span>
          <span <?=$predikat=='B'?'':'class="strike"';?>> B / </span>
          <span <?=$predikat=='B+'?'':'class="strike"';?>> B+ / </span>
          <span <?=$predikat=='A-'?'':'class="strike"';?>> A- / </span>
          <span <?=$predikat=='A'?'':'class="strike"';?>> A / </span>
          <span <?=$predikat=='A+'?'':'class="strike"';?>> A+ </span>
          <?php } else{ ?>
          <span> D / </span>
          <span> C- / </span>
          <span> C / </span>
          <span> C+ / </span>
          <span> B- / </span>
          <span> B / </span>
          <span> B+ / </span>
          <span> A- / </span>
          <span> A / </span>
          <span> A+ </span>
          <?php } ?>
    </strong>)*, dan menyatakan bahwa proposal tersebut:
    </div>
    <div style="width: 100%;">
        <div style="text-align: center; width:5%; border: 0.2mm solid #000000; float:left; "><?=(isset($rekom) && $rekom==3)?'&#8730;':'&nbsp;';?></div>
        <div style="text-align: left; width:30%; margin-bottom: 5pt; float:left;">&nbsp;Lulus Tanpa Perbaikan</div>
        <div style="text-align: center; width:5%; border: 0.2mm solid #000000; float:left;"><?=(isset($rekom) && $rekom==2)?'&#8730;':'&nbsp;';?></div>
        <div style="text-align: left; width:30%; margin-bottom: 5pt; float:left;">&nbsp;Lulus Dengan Perbaikan</div>
        <div style="text-align: center; width:5%; border: 0.2mm solid #000000; float:left;"><?=(isset($rekom) && $rekom==1)?'&#8730;':'&nbsp;';?></div>
        <div style="text-align: left; width:20%; margin-bottom: 5pt; float:left;">&nbsp;Ditolak</div>
    </div>
    <div style="text-align: justify;">
      Waktu terakhir pengumpulan Proposal Skripsi yang telah direvisi adalah <strong>2 (Dua) Minggu</strong> setelah seminar dilaksanakan, dengan rekomendasi:
    </div>
    <div style="border-top: 1px dashed #000000; width: 0px; display: inline-block;"></div>
    <br>
    <?php if(!empty($komen1) || !empty($komen2)){ ?>
        <table width="100%" style=" topntail: 0.02cm solid #000000; font-family: Arial, Helvetica, sans-serif;; font-size: 9pt;" border="0" autosize="1.8">
            <thead >

              <tr >
                <th  width="20%">Aspek</th>
                <th >Penguji 1</th>
                <th >Penguji 2</th>
              </tr>
            </thead>
            <tbody>
              	
              	<tr >    			
              	<td style="vertical-align:top;">Judul</td>
        			<td style="vertical-align:top;"><?=(!empty($komen1))?$komen1['judul']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($komen2))?$komen2['judul']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">Latar Belakang / Konteks Penelitian</td>
        			<td style="vertical-align:top;"><?=(!empty($komen1))?$komen1['latar_konteks']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($komen2))?$komen2['latar_konteks']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">Rumusan Masalah / Fokus Penelitian</td>
        			<td style="vertical-align:top;"><?=(!empty($komen1))?$komen1['rumusan']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($komen2))?$komen2['rumusan']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">Tujuan </td>
        			<td style="vertical-align:top;"><?=(!empty($komen1))?$komen1['tujuan']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($komen2))?$komen2['tujuan']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">Metode </td>
        			<td style="vertical-align:top;"><?=(!empty($komen1))?$komen1['metode_penelitian']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($komen2))?$komen2['metode_penelitian']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">Penelitian Terdahulu </td>
        			<td style="vertical-align:top;"><?=(!empty($komen1))?$komen1['kajian_terdahulu']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($komen2))?$komen2['kajian_terdahulu']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">Konsep / Teori</td>
        			<td style="vertical-align:top;"><?=(!empty($komen1))?$komen1['konsep_teori']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($komen2))?$komen2['konsep_teori']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">Rencana Pembahasan</td>
        			<td style="vertical-align:top;"><?=(!empty($komen1))?$komen1['rencana_pembahasan']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($komen2))?$komen2['rencana_pembahasan']:'';?></td>
        		</tr>
        		<tr>
        			<td style="vertical-align:top;">Daftar Pustaka</td>
        			<td style="vertical-align:top;"><?=(!empty($komen1))?$komen1['daftar_pustaka']:'';?></td>
        			<td style="vertical-align:top;"><?=(!empty($komen2))?$komen2['daftar_pustaka']:'';?></td>
        		</tr>
        		
            </tbody>
          </table>
        <?php }else{ ?>
        <br><br><br><br><br><br><br><br><br><br>
        <?php } ?>
		
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
      <div class="kolom3"><?=(!empty($data['proposal']['tgl_seminar']))?short_tgl_indonesia_date($data['proposal']['tgl_seminar']):'';?></div>
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
                $jml_penguji = getCount('penguji_sempro', ['id_sempro' => $data['proposal']['id']],null, 'kd_dosen')['kd_dosen'];
                $penguji = dataDinamis('penguji_sempro', ['id_sempro' => $data['proposal']['id']], 'tugas ASC');
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
        			<td style="text-align:center;"><?=$jabatan;?></td>
        			<td style="font-size: 10pt; vertical-align:top; text-align:right;"><?=$no2++;?></td>
        			<td colspan="<?=$jml_penguji;?>" style="font-size: 10pt; vertical-align:top;"><img src="<?=$data['qrcode'];?>" width="75" height="75"></td>
        			
        		</tr>
        
        		<?php } ?>
        </tbody>
      </table>
    </div>
    
    
  </div>

