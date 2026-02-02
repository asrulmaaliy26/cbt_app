<style>
    .qrcode{
        background-image: url(<?=$data['qrcode']?>);
      background-repeat: no-repeat;
      background-size: 300px 300px;
    float: right;
    width: 2.7cm;
    height: 2.7cm;
  }
</style>

<?php
        $mk = getDataRow('mata_kuliah', ['id' => $data['id_mk']]);
?>

<div align="center" style="font-family: 'Arial Bold', sans-serif; font-size:12px;font-weight:bold;">JURNAL PERKULIAHAN</div>
<div style="font-family: 'Arial Bold', sans-serif; font-size:12px; text-align:center;font-weight:bold;">STAI AL-MANNAN TULUNGAGUNG</div>
<div style="font-family: 'Arial Bold', sans-serif; font-size:12px; text-align:center;font-weight:bold;">SEMESTER <?=getDataRow('tahun_akademik', ['kode' => $mk['Kd_Tahun']])['semester'] == '1' ? 'GASAL':'GENAP';?> TAHUN AKADEMIK <?=getDataRow('tahun_akademik', ['kode' => $mk['Kd_Tahun']])['tahunAkademik'];?></div>
<div class="qrcode"></div><br><br>
<div style=" width: 20%; float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; ">FAKULTAS</div>
<div style=" width: 5%; float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; ">:</div>
<div style=" float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; "><?=strtoupper(getDataRow('prodi', ['singkatan' => $mk['Prodi']])['fakultas']);?></div>
<div style=" width: 20%; float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; ">PROGRAM STUDI</div>
<div style=" width: 5%; float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; ">:</div>
<div style=" float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; "><?=strtoupper(getDataRow('prodi', ['singkatan' => $mk['Prodi']])['nm_prodi']);?></div>
<div style=" width: 20%; float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; ">SEMESTER</div>
<div style=" width: 5%; float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; ">:</div>
<div style=" float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; ">SMT <?=$mk['SMT'];?> / <?=$mk['Kelas'];?></div>
<div style=" width: 20%; float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; ">MATA KULIAH</div>
<div style=" width: 5%; float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; ">:</div>
<div style=" float: left; font-family: 'Arial Bold', sans-serif; font-size:12px; font-weight:bold; "><?=$mk['Mata_Kuliah'];?></div>
<br>
<div>    
    <table style="width:100%; font-family: 'Arial Bold', sans-serif; font-size:12px;" border="1">
    	<thead>
    		<tr>
    			<th class="center" width="5%" >NO</th>
    			<th class="center" width="10%">TANGGAL</th>
    			<th class="center" width="55%">MATERI</th>
    			<th class="center" width="15%">METODE</th>
    			<th class="center" width="15%">TTD</th>
    		</tr>
    		
    	</thead>
    	<tbody>
    		<?php 
    				
                    
                    for ($i=1;$i<=16;$i++) {
    					
    				
    				?>
    		<tr>
    			<td style="text-align:center;"><?=$i;?></td>
    			<td ></td>
    			<td ></td>
    			<td style="text-align:center;"></td>
    			<td style="text-align:center;"></td>
    			
    		</tr>
    
    		<?php  } ?>
    	</tbody>
    </table>
</div>
<br><br>
<div>    
    <table style="width:100%; font-family: 'Arial Bold', sans-serif; font-size:12px;" >
    	
    	<tbody>
    		
    		<tr>
    			<td width="60%">Dosen<br><br><br><br><br><br><br><strong><u><?=getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']])['Nama_Dosen'];?></u></strong><br><?=getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']])['NIY'];?></td>
    			<td width="40%">Ketua Prodi<br><br><br><br><br><br><br><strong><u><?=getDataRow('prodi', ['singkatan' => $mk['Prodi']])['kaprodi'];?></u></strong><br><?=getDataRow('prodi', ['singkatan' => $mk['Prodi']])['niy'];?></td>
    			
    		</tr>
    	</tbody>
    </table>
</div>