<style>
    tr,td
    {
      height:30px;
      vertical-align:middle;
    }
    .qrcode{
        background-image: url(<?=$data['qrcode']?>);
      background-repeat: no-repeat;
      background-size: 300px 300px;
    float: right;
    padding-right: 0.5cm;
    width: 2.7cm;
    height: 2.7cm;
  }
</style>
<?php
        $mk = getDataRow('mata_kuliah', ['id' => $data['id_mk']]);
?>

<div class="qrcode"></div>
<div style="text-align: center; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px;font-weight:bold; padding-left: 26.5mm;">DAFTAR HADIR MAHASISWA</div>
<?php if($mk['jenjang'] == 'S2'){ ?>
<div style="text-align: center; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px;font-weight:bold; padding-left: 26.5mm;">PROGRAM PASCASARJANA</div>
<?php } ?>    
<div style="text-align: center; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px;font-weight:bold; padding-left: 26.5mm;">STAI AL-MANNAN TULUNGAGUNG</div>
<div style="text-align: center; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px;font-weight:bold; padding-left: 26.5mm;">SEMESTER <?=getDataRow('tahun_akademik', ['kode' => $mk['Kd_Tahun']])['semester'] == '1' ? 'GASAL':'GENAP';?> TAHUN AKADEMIK <?=getDataRow('tahun_akademik', ['kode' => $mk['Kd_Tahun']])['tahunAkademik'];?></div>
<br>
<?php if($mk['jenjang'] == 'S1'){ ?>
<div style=" width: 20%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; padding-left: 20mm;">FAKULTAS</div>
<div style=" width: 5%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; ">:</div>
<div style=" width: 55%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; "><?=strtoupper(getDataRow('prodi', ['singkatan' => $mk['Prodi']])['fakultas']);?></div>
<?php } ?>
<div style=" width: 20%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; padding-left: 20mm;">PROGRAM STUDI</div>
<div style=" width: 5%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; ">:</div>
<div style=" width: 55%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; "><?=strtoupper(getDataRow('prodi', ['singkatan' => $mk['Prodi']])['nm_prodi']);?></div>
<div style=" width: 20%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; padding-left: 20mm;">SEMESTER</div>
<div style=" width: 5%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; ">:</div>
<div style=" width: 55%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; ">SMT <?=$mk['SMT'];?> / <?=$mk['Kelas'];?></div>
<div style=" width: 20%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; padding-left: 20mm;">MATA KULIAH</div>
<div style=" width: 5%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; ">:</div>
<div style=" width: 55%; float: left; font-family: 'Arial Bold', sans-serif; font-size:14px; font-weight:bold; "><?=strtoupper($mk['Mata_Kuliah']);?></div>
<br>
<div>    
    <table style="width:100%; font-family: 'Arial Bold', sans-serif; font-size:11px;" border="1">
	<thead>
		<tr>
			<th class="center" rowspan="2">No</th>
			<th class="center" rowspan="2">Nama</th>
			<th class="center" rowspan="2">NIM</th>
			<th class="center" colspan="16">Pertemuan</th>
			
			<th class="center" rowspan="2">JML</th>
		</tr>
		<tr>
			<th class="center">Ke-1</th>
			<th class="center">Ke-2</th>
			<th class="center">Ke-3</th>
			<th class="center">Ke-4</th>
			<th class="center">Ke-5</th>
			<th class="center">Ke-6</th>
			<th class="center">Ke-7</th>
			<th class="center">Ke-8</th>
			<th class="center">Ke-9</th>
			<th class="center">Ke-10</th>
			<th class="center">Ke-11</th>
			<th class="center">Ke-12</th>
			<th class="center">Ke-13</th>
			<th class="center">Ke-14</th>
			<th class="center">Ke-15</th>
			<th class="center">Ke-16</th>
		</tr>
	</thead>
	<tbody>
		<?php 
				
			if(!empty($data['list_mhs'])){
				$no = 0;
				foreach ($data['list_mhs'] as $list ) {
				    $id_data_diri = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['id_data_diri'];
					$no++;
				?>
    		<tr>
    			<td ><?=$no;?></td>
    			<td ><?=strtoupper(getDataRow('db_data_diri_mahasiswa',['id'=>$id_data_diri])['Nama_Lengkap']);?></td>
    			<td ><?=getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['NIM'];?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P1!='' && $r->validasi!='1'?'':$r->P1;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P2!='' && $r->validasi!='1'?'':$r->P2;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P3!='' && $r->validasi!='1'?'':$r->P3;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P4!='' && $r->validasi!='1'?'':$r->P4;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P5!='' && $r->validasi!='1'?'':$r->P5;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P6!='' && $r->validasi!='1'?'':$r->P6;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P7!='' && $r->validasi!='1'?'':$r->P7;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P8!='' && $r->validasi!='1'?'':$r->P8;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P9!='' && $r->validasi!='1'?'':$r->P9;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P10!='' && $r->validasi!='1'?'':$r->P10;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P11!='' && $r->validasi!='1'?'':$r->P11;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P12!='' && $r->validasi!='1'?'':$r->P12;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P13!='' && $r->validasi!='1'?'':$r->P13;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P14!='' && $r->validasi!='1'?'':$r->P14;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P15!='' && $r->validasi!='1'?'':$r->P15;?></td>
    			<td style="text-align:center; font-size:6px;"><?//=$r->P16!='' && $r->validasi!='1'?'':$r->P16;?></td>
    			<td style="text-align:center; "></td>
    		</tr>

		<?php } }else{ ?>
		        <tr>
		            <td style="text-align:center; " colspan="20">Belum Ada Mahasiswa Yang KRS</td>
		        </tr>
		<?php } ?>
	</tbody>
</table>

</div>
<div style="font-size:10px;">* Bagi Mahasiswa/i yang namanya belum tercantum pada absensi dan belum memiliki NIM, segera konfirmasi ke bagian BAAK (Badan Akademik dan Kemahasiswaan)</div>
<br>
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