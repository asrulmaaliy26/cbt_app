<style type="text/css">

    .textarea{
      float: left;
      padding-left: 16mm;
      padding-right: 12mm;
      font-family: Tahoma, Helvetica, sans-serif;
      font-size: 11pt;
      line-height: 1.35;
    }
    .kolom1{
      width: 25%;
      float: left;
      font-family: Tahoma, Helvetica, sans-serif;
     
    }
    .kolom2{
      width: 5%; 
      float: left;
      text-align: center;
      font-family: Tahoma, Helvetica, sans-serif;
      
    }
    .kolom3{
      width: 70%; 
      float: left;
      font-family: Tahoma, Helvetica, sans-serif;
    }
    .colttd1{
        width: 50%; 
        float: left;
        font-family: Tahoma, Helvetica, sans-serif;
    }
    .colttd2{
        width: 50%; 
        float: left;
        font-family: Tahoma, Helvetica, sans-serif;
    }
  
  </style>
  
<?php 
    $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $data['cuti']['id_his_pdk']])['id_data_diri'];
   
?>
<div style="text-align: center; font-family: Tahoma; font-size: 12pt; font-weight: bold;">
    SURAT PERMOHONAN CUTI KULIAH
</div>
<br>
<div style="padding-left: 13mm; padding-right: 5mm; font-family: Tahoma; font-size: 12pt;">
    Kepada Yth.<br>
    Dekan Fakultas <?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['cuti']['id_his_pdk']])['Prodi']])['fakultas'];?> <br>
    STAI Al-Mannan Tulungagung <br>
    Di-<br>
    <div style="margin-left: 25px;">Tempat</div><br>
    <p><b>Assalamu'alaikum Wr. Wb.</b></p>
    <p>Dengan hormat, saya yang bertanda tangan di bawah ini :</p>
    <p>    <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Nama</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);?></div>
        </div>
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">NIM</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=getDataRow('histori_pddk', ['id_his_pdk' => $data['cuti']['id_his_pdk']])['NIM'];?></div>
        </div>
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Tempat, Tgl. Lahir</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Kota_Lhr'];?>, <?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Tgl_Lhr'];?></div>
        </div>
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Program Studi</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['cuti']['id_his_pdk']])['Prodi']])['nm_prodi'];?></div>
        </div>
        
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">No. HP</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=$data['cuti']['no_hp'];?></div>
        </div></p>
    <p>Bermaksud mengajukan cuti kuliah pada :</p>    
    <p>    
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Tahun Akademik</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=getDataRow('tahun_akademik', ['kode' => $data['cuti']['kd_ta']])['tahunAkademik'];?> <?=getDataRow('tahun_akademik', ['kode' => $data['cuti']['kd_ta']])['semester']==1?'Gasal':'Genap';?></div>
        </div>
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Alasan</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=$data['cuti']['alasan'];?></div>
        </div></p>
    <p style="text-align: justify;">Sebagai persyaratan cuti kuliah saya lampirkan :</p>
    <ol style="text-align: justify;">
        <li>Surat keterangan bebas biaya administrasi akademik sampai dengan semester terakhir mengikuti perkuliahan;</li>
        <li>Bukti bebas tanggungan perpustakaan</li>
    </ol>
    <p style="text-align: justify;">Demikian permohonan cuti kuliah ini saya sampaikan, atas perhatiannya saya ucapkan terimakasih.</p>
    <p><b>Wassalamu'alaikum Wr. Wb.</b></p>
    <br>
    Jombang, <?=tgl_indonesia_short($data['cuti']['created_at']);?><br>
    <div class="colttd1">
        Pemohon<br><br><br><br><u><?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap']);?></u>
    </div>
    <div class="colttd2">
        Kepala BAK<br><br><br><br><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    </div>
    <br>
    <div class="colttd1">
        Mengetahui<br>Ketua Prodi <?=getDataRow('histori_pddk', ['id_his_pdk' => $data['cuti']['id_his_pdk']])['Prodi'];?><br><br><br><br><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    </div>
    <div class="colttd2">
        Menyetujui<br>Dekan Fakultas <?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['cuti']['id_his_pdk']])['Prodi']])['fakultas'];?><br><br><br><br><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    </div>
    
</div>

