
<style type="text/css">
	
	.kolom1{
		float: left;
		width: 7cm;
		font-size: 11pt;
	}
	.kolom2{
		float: right;
		width: 10cm;
		font-size: 8pt;
	}

</style>
</head>


<body style="font-family: 'Arial', sans-serif; font-size: 12pt;">
<div style="text-align: center;">
	ABSENSI PESERTA<br>UJIAN TENGAH SEMESTER (UTS) <?=getDataRow('tahun_akademik', ['kode'=>$data['kd_tahun_mk']])['semester'] == '1'?'GASAL':'GENAP';?><br>STAI AL-MANNAN TULUNGAGUNG<br>TAHUN AKADEMIK <?=getDataRow('tahun_akademik', ['kode'=>$data['kd_tahun_mk']])['tahunAkademik'];?>
	<br><br>
</div>
<?php
        $mk = getDataRow('mata_kuliah', ['id' => $data['id_mk']]);
?>
<div>
	<table border="0" style="font-size: 11pt;">
		<tr>
			<td width="16%">Fakultas</td>
			<td width="35%">: <?=ucwords(getDataRow('prodi', ['singkatan' => $mk['Prodi']])['fakultas']);?></td>
			<td width="16%">Mata Kuliah</td>
			<td >: <?=$mk['Mata_Kuliah'];?></td>
		</tr>
		<tr>
			<td>Prodi</td>
			<td>: <?=$mk['Prodi'];?></td>
			<td>Dosen</td>
			<td>: <?=getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']])['Nama_Dosen'];?></td>
		</tr>
		<tr>
			<td>Semester</td>
			<td>: <?=$mk['SMT'];?> - <?=$mk['Kelas'];?></td>
			<td>Hari/Tanggal</td>
			<td>: <?=$mk['Hari_UTS'];?> / <?=date_indo($mk['Tgl_UTS']."-".$mk['Bln_UTS']."-".$mk['Thn_UTS']);?></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td>Pukul</td>
			<td>: <?=$mk['Jam_UTS'];?> WIB</td>
		</tr>
	</table>
</div>

<div>
	<table width="100%" style="border-collapse: collapse; font-size: 9pt;">
		<tr>
			<td width="5%" rowspan="2" style="border: 1px solid black; text-align: center;">No</td>
			<td width="25%" rowspan="2" style="border: 1px solid black; text-align: center;">No Induk</td>
			<td width="30%" rowspan="2" style="border: 1px solid black; text-align: center;">Nama</td>
			<td colspan="4" style="border: 1px solid black; text-align: center;">Nilai</td>
			<td width="12%" rowspan="2" style="border: 1px solid black; text-align: center;">Tanda Tangan</td>
		</tr>
		<tr>
			<td width="7%" style="border: 1px solid black; text-align: center;">UTS</td>
			<td width="7%" style=" border: 1px solid black; text-align: center;">Tugas</td>
			<td width="7%" style="border: 1px solid black; text-align: center;">UAS</td>
			<td width="7%" style="border: 1px solid black; text-align: center;">Perf</td>
		</tr>
		<?php 
				
			if(!empty($data['listsNilai'])){
				$no = 0;
				foreach ($data['listsNilai'] as $list ) {
				    $id_data_diri = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['id_data_diri'];
					$no++;
				?>
		<tr>
			<td style="border: 1px solid black; text-align: center; height: 0.75cm;"><?=$no++;?></td>
			<td style="border: 1px solid black; "><?=getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['NIM'];?></td>	
			<td style="border: 1px solid black; "><?=strtoupper(getDataRow('db_data_diri_mahasiswa',['id'=>$id_data_diri])['Nama_Lengkap']);?></td>
			<td style="border: 1px solid black; text-align: center;"><?=$list['Nilai_UTS']=='' | 0.00?'':number_format($list['Nilai_UTS'],2);?></td>
			<td style="border: 1px solid black; text-align: center;"></td>
			<td style="border: 1px solid black; text-align: center;"></td>
			<td style="border: 1px solid black; text-align: center;"></td>
			<td style="border: 1px solid black; text-align: center; font-size: 8pt;">
			    <?
			        if($list['Nilai_UTS']!=0){
			            $v= "Digital Signed Valid";
			        }else{
			            $v="";
			        }
			        echo $v;
			    ?>
			</td>
		</tr>
		<?php } } ?>
	</table>
</div>

<br>
<table border="0" style="font-size: 11pt;">
	<tr>
		<td width="60%">Dosen<br><br><br><br><br><br><?=getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']])['Nama_Dosen'];?><br><?=getDataRow('data_dosen', ['Kode' => $mk['Kd_Dosen']])['NIY'];?></td>
		<td width="40%" style="text-align: right; vertical-align: top;">
			<table style="border-collapse: collapse; font-size: 8pt;">
				<tr>
					<td colspan="3" style="border: 1px solid black; text-align: center;">RANGE NILAI MATA KULIAH (NMK)</td>
					<td style="border: 1px solid black; text-align: center;">Status</td>
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">&lt;1.75</td>
					<td style="border: 1px solid black; text-align: center;">0.5</td>
					<td style="border: 1px solid black; text-align: center;">D</td>
					<td style="border: 1px solid black; text-align: center;">Tidak Lulus</td>
					
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">1.76 - 1.99</td>
					<td style="border: 1px solid black; text-align: center;">1.76</td>
					<td style="border: 1px solid black; text-align: center;">C-</td>
					<td style="border: 1px solid black; text-align: center;">Tidak Lulus</td>
					
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">2.00 - 2.25</td>
					<td style="border: 1px solid black; text-align: center;">2.00</td>
					<td style="border: 1px solid black; text-align: center;">C</td>
					<td style="border: 1px solid black; text-align: center;">Lulus</td>
					
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">2.26 - 2.50</td>
					<td style="border: 1px solid black; text-align: center;">2.26</td>
					<td style="border: 1px solid black; text-align: center;">C+</td>
					<td style="border: 1px solid black; text-align: center;">Lulus</td>
					
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">2.51 - 2.75</td>
					<td style="border: 1px solid black; text-align: center;">2.51</td>
					<td style="border: 1px solid black; text-align: center;">B-</td>
					<td style="border: 1px solid black; text-align: center;">Lulus</td>
					
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">2.76 - 3.00</td>
					<td style="border: 1px solid black; text-align: center;">3.00</td>
					<td style="border: 1px solid black; text-align: center;">B</td>
					<td style="border: 1px solid black; text-align: center;">Lulus</td>
					
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">3.01 - 3.25</td>
					<td style="border: 1px solid black; text-align: center;">3.01</td>
					<td style="border: 1px solid black; text-align: center;">B+</td>
					<td style="border: 1px solid black; text-align: center;">Lulus</td>
					
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">3.26 - 3.50</td>
					<td style="border: 1px solid black; text-align: center;">3.26</td>
					<td style="border: 1px solid black; text-align: center;">A-</td>
					<td style="border: 1px solid black; text-align: center;">Lulus</td>
					
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">3.51 - 3.75</td>
					<td style="border: 1px solid black; text-align: center;">3.51</td>
					<td style="border: 1px solid black; text-align: center;">A</td>
					<td style="border: 1px solid black; text-align: center;">Lulus</td>
					
				</tr>
				<tr>
					<td style="border: 1px solid black; text-align: center;">3.76 - 4.00</td>
					<td style="border: 1px solid black; text-align: center;">4.00</td>
					<td style="border: 1px solid black; text-align: center;">A+</td>
					<td style="border: 1px solid black; text-align: center;">Lulus</td>
					
				</tr>
				<tr>
					<td colspan="4" style="border: 1px solid black; text-align: center;"><u>(N. UTS x 20) + (N.TGS x 30) + (N.UAS x 30) + (N.P x 20)</u><br>100</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<dir class="kolom2">
	
</dir>

<br><br><br>

<!--<div style="font-size: 8pt;">*Dokumen ini diakses melalui siakad online dan telah diverifikasi oleh petugas yang berwenang</div>-->

</body>