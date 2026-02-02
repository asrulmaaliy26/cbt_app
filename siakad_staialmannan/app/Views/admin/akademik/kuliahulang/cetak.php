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
    $id_data_diri = getDataRow('histori_pddk', ['id_his_pdk' => $data['ku']['id_his_pdk']])['id_data_diri'];
    foreach($data['mk_ku'] as $key){
      
?>
<div style="text-align: center; font-family: Tahoma; font-size: 12pt; font-weight: bold;">
    FORMULIR PENDAFTARAN
</div>

<div style="text-align: center; font-family: Tahoma; font-size: 12pt; font-weight: bold;">
    KULIAH ULANG SEMESTER <?=getDataRow('tahun_akademik', ['kode' => $data['ku']['kd_ta']])['semester']==1?'GASAL':'GENAP';?> TAHUN AKADEMIK <?=getDataRow('tahun_akademik', ['kode' => $data['ku']['kd_ta']])['tahunAkademik'];?> 
</div>
<br>
<div style="padding-left: 5mm; padding-right: 5mm; font-family: Tahoma; font-size: 12pt;">
    
    <p>Dengan hormat, saya yang bertanda tangan di bawah ini :</p>
    <p>    <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Nama</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'];?></div>
        </div>
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">NIM</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=getDataRow('histori_pddk', ['id_his_pdk' => $data['ku']['id_his_pdk']])['NIM'];?></div>
        </div>
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Program Studi</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=getDataRow('histori_pddk', ['id_his_pdk' => $data['ku']['id_his_pdk']])['Prodi'];?></div>
        </div>
        
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Semester</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=romawi_bulan($data['ku']['smt']);?></div>
        </div></p>
    <p>Mendaftar untuk mengikuti Program Kuliah Ulang Semester <?=getDataRow('tahun_akademik', ['kode' => $data['ku']['kd_ta']])['semester']==1?'Gasal':'Genap';?> Tahun Akademik <?=getDataRow('tahun_akademik', ['kode' => $data['ku']['kd_ta']])['tahunAkademik'];?> pada :</p>    
    <p>    <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Matakuliah</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=getDataRow('mata_kuliah', ['id' => $key['id_mk']])['Mata_Kuliah'];?></div>
        </div>
        <div style="width: 100%; margin-left: 25px;">
          <div class="kolom1">Dosen</div>
          <div class="kolom2">:</div>
          <div class="kolom3"><?=(!empty(getDataRow('mata_kuliah', ['id' => $key['id_mk']])['Kd_Dosen']))?getDataRow('data_dosen', ['Kode' => getDataRow('mata_kuliah', ['id' => $key['id_mk']])['Kd_Dosen']])['Nama_Dosen']:'';?></div>
        </div>
    </p>
    <p>Adapun nilai yang telah saya peroleh pada matakuliah tersebut sebagai berikut :</p>
    <table width="100%"  style="border-top: 1px dotted #000000; border-left: 1px dotted #000000; border-right: 1px dotted #000000;  font-size: 12pt; autosize:2.4;">
        <thead>
        
        	<tr >
        		
        		<th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">UTS</th>
        		<th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">TGS</th>
        		<th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">UAS</th>
        		<th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">P</th>
        		<th style="text-align: center; border-right: 1px dotted #000000; border-bottom: 1px dotted #000000;">AM</th>
        		
        	</tr>
        </thead>
        <tbody>
            <tr style="border-right: 1px solid #000000; border-bottom:  1px solid #000000;">
    			
    			<td align="center" style="border-right: 1px dotted #000000; border-bottom:  1px dotted #000000;"><?=number_format($key['Nilai_UTS'],2);?></td>
    			<td align="center" style="border-right: 1px dotted #000000; border-bottom:  1px dotted #000000;"><?=number_format($key['Nilai_TGS'],2);?></td>
    			<td align="center" style="border-right: 1px dotted #000000; border-bottom:  1px dotted #000000;"><?=number_format($key['Nilai_UAS'],2);?></td>
    			<td align="center" style="border-right: 1px dotted #000000; border-bottom:  1px dotted #000000;"><?=number_format($key['Nilai_Performance'],2);?></td>
    			<td align="center" style="border-right: 1px dotted #000000; border-bottom:  1px dotted #000000;"><?=number_format($key['Nilai_Akhir'],2);?></td>
    		</tr>
    	</tbody>
    </table>
    <br>
    Jombang, <?=YMDtotglindo($data['ku']['created_at']);?><br>
    <div class="colttd1">
        Mahasiswa<br><br><br><br><br><u><?=getDataRow('db_data_diri_mahasiswa', ['id' => $id_data_diri])['Nama_Lengkap'];?></u>
    </div>
    <div class="colttd2">
        Dosen<br><br><br><br><br><u><?=(!empty(getDataRow('mata_kuliah', ['id' => $key['id_mk']])['Kd_Dosen']))?getDataRow('data_dosen', ['Kode' => getDataRow('mata_kuliah', ['id' => $key['id_mk']])['Kd_Dosen']])['Nama_Dosen']:'';?></u>
    </div>
    <br>
    <div class="colttd2">
        Menyetujui<br>Ketua Prodi <?=getDataRow('histori_pddk', ['id_his_pdk' => $data['ku']['id_his_pdk']])['Prodi'];?><br><br><br><br><br><u><?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['ku']['id_his_pdk']])['Prodi']])['kaprodi'];?></u>
    </div>
    <div class="colttd1">
        Mengetahui<br>Ka. Bag. Akademik (BAAK)<br><br><br><br><br><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
    </div>
    
</div>

<pagebreak margin-left="10mm" margin-right="10mm" margin-top="40mm" margin-bottom="10mm" />

<?php } ?>