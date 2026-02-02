
  <style type="text/css">
    
    .textarea{
      float: left;
      padding-left: 16mm;
      padding-right: 12mm;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12pt;
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
      height:50px;
    }
  </style>


  <div class="textarea">
    <div style="text-align: center; "><strong>BERITA ACARA</strong></div>
    <div style="text-align: center;"><strong>SEMINAR PROPOSAL SKRIPSI</strong></div>
    <div style="text-align: center;"><strong>SEMESTER <?=$proposal['semester']==1?"GASAL":"GENAP";?> TAHUN AKADEMIK <?=$proposal['tahunAkademik'];?></strong></div>
    <br>
    <div style="text-align: justify;">
      Dengan ini, Kami Majelis Penguji menerangkan bahwa pada:
    </div>
    
    <div style="width: 100%;">
      <div class="kolom1">
        <div >Hari, tanggal</div>
        <div >Tempat</div>
        
        
      </div>
      <div class="kolom2">
        <div>:</div>
        <div>:</div>
        
      </div>
      <div class="kolom3">
        <div><?=longdate_indo($proposal['tgl_seminar']);?></div>
        <div>Ruang Sidang Institut Agama Islam Bani Fattah Jombang</div>
        
      </div>
    </div>
    <div style="text-align: justify;">
      Telah dilaksanakan Seminar Proposal Skripsi dengan identitas:
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
      <div class="kolom3"><div><?=ucwords(strip_tags($proposal['judul']));?></div></div>
    </div>
    <br>
    <div style="width: 100%;">
      <div class="kolom1">Paraf Mahasiswa</div>
      <div class="kolom2">:</div>
      <div class="kolom3"></div>
    </div>
    
    <div style="text-align: justify;">
      Demikian Berita Acara ini dibuat pada tanggal <?=date_indo($proposal['tgl_seminar']);?>
    </div>
    <br>
    <div style="text-align: center; "><strong>MAJELIS PENGUJI</strong></div>
    <div style="width: 100%; float: left;">
      <table width="100%" style=" topntail: 0.02cm solid #000000; font-family: 'Tahoma', sans-serif; font-size: 12pt;" border="0" autosize="1.8">
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
    <div style="text-align: justify;">
      Catatan :
    </div>
    <div style="border: 1px solid #000000; background-color: #000000;">
    
    
  </div>
  <div>
    
  </div>

