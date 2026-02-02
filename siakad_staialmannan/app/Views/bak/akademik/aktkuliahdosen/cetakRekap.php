
<body style="font-family: 'Arial', sans-serif; font-size: 12pt;">
<div style="text-align: center;">
	<?=$data['templateJudul']?>
	<br><br>
</div>

<div>    
    <table style="width:100%; font-family: 'Arial Bold', sans-serif; font-size:11px;" border="1">
	<thead>
		<tr>
            <th style="text-align:center; ">No</th>
            <th style="text-align:center; ">Dosen</th>
            <th style="text-align:center; ">Mata Kuliah</th>
            <th style="text-align:center; ">Pelaksanaan</th>
            <th style="text-align:center; ">Prodi</th>
            <th style="text-align:center; ">Kelas</th>
            <th style="text-align:center; ">SMT</th>
            <th style="text-align:center; ">Pertemuan</th>
        </tr>
	</thead>
	<tbody>
		<?php 
				
			if(!empty($data['mk'])){
				$no = 0;
				foreach ($data['mk'] as $list ) {
				    //$id_data_diri = getDataRow('histori_pddk',['id_his_pdk'=>$list['id_his_pdk']])['id_data_diri'];
				    $prodi = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $list['kd_kelas_perkuliahan']], null, 'Prodi');
                    $prod =[]; 
                    foreach ($prodi as $key ) {
                       $prod[] = $key->Prodi;
                    }
                    $kelas = dataDinamis('mata_kuliah', ['kd_kelas_perkuliahan' => $list['kd_kelas_perkuliahan']], null, 'Kelas');
                    $kls =[]; 
                    foreach ($kelas as $key ) {
                       $kls[] = $key->Kelas;
                    }
					$no++;
				?>
    		<tr>
    			<td style="text-align:center; "><?=$no;?></td>
    			<td ><?=(!empty($list['Kd_Dosen']))?getDataRow('data_dosen',['Kode'=>$list['Kd_Dosen']])['Nama_Dosen']:'';?></td>
    			<td ><?=$list['Mata_Kuliah'];?></td>
    			<td style="text-align:center; "><?=(!empty($list['Pelaksanaan']))?getDataRow('ref_option', ['opt_group' => 'pelaksanaan_kuliah', 'opt_id' => $list['Pelaksanaan']])['opt_val']:'-';?></td>
    			<td style="text-align:center; "><?=implode(" - ",$prod)?></td>
    			<td style="text-align:center; "><?=implode(" - ",$kls)?></td>
    			<td style="text-align:center; "><?=$list['SMT']?></td>
    			<td style="text-align:center; "><?=getCount('tb_jurnal_kuliah', ['kd_kelas_perkuliahan' => $list['kd_kelas_perkuliahan'], 'tanggal >=' => $data['tgl_awal'], 'tanggal <=' => $data['tgl_akhir']], null, 'tanggal')['tanggal']?></td>
    		</tr>

		<?php } }else{ ?>
		        <tr>
		            <td style="text-align:center; " colspan="8"></td>
		        </tr>
		<?php } ?>
	</tbody>
</table>

</div>

</body>