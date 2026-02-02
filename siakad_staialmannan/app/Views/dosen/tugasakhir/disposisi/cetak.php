<style>
ol, ul { text-align: justify;}

</style>

<br>
<div style="text-align: center; font-family: Tahoma; font-size: 12pt; font-weight: bold;">
    FORMULIR DISPOSISI JUDUL SKRIPSI<br>PROGRAM STUDI <?=strtoupper(getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['Prodi']])['nm_prodi']);?>
</div>
<br>
<div style="padding-left: 13mm; padding-right: 13mm; font-family: Tahoma; font-size: 12pt;">
    
    <table style="width:100%; font-family: Tahoma; font-size: 12pt;" >
       
        <tbody>
            <tr>
                <td style="width: 25%;">Nama Mahasiswa</td>
                <td style="width: 5%;">:</td>
                <td><?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $data['id_data_diri']])['Nama_Lengkap']);?></td>
            </tr>
            <tr>
                <td style="width: 25%;">NIM</td>
                <td style="width: 5%;">:</td>
                <td><?=getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['NIM'];?></td>
            </tr>
            <tr>
                <td style="width: 25%;">Dosen Pembimbing</td>
                <td style="width: 5%;">:</td>
                <td><?=(!empty($data['disposisi']['dosen_pembimbing']))?getDataRow('data_dosen', ['Kode' => $data['disposisi']['dosen_pembimbing']])['Nama_Dosen']:'';?></td>
            </tr>
            <tr>
                <td style="width: 25%;">Tahun Akademik</td>
                <td style="width: 5%;">:</td>
                <td><?=getDataRow('tahun_akademik', ['kode' => $data['disposisi']['tahun_akademik']])['tahunAkademik'];?></td>
            </tr>
            
        </tbody>
    </table>
</div>
<div style="padding-left: 13mm; padding-right: 13mm; font-family: Tahoma; font-size: 12pt;">
    <table style="width:100%; font-family: Tahoma; font-size: 12pt;" border="1">
        <thead>
            <tr>
                <th style="width: 26%; text-align: center;">Keterangan</th>
                <th style="text-align: center;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Judul</td>
                <td><?=$data['disposisi']['judul_disposisi'];?></td>
            </tr>
            <tr>
                <td>Problem Hukum / Masalah Penelitian</td>
                <td><?=$data['disposisi']['problem_disposisi'];?></td>
            </tr>
            <tr>
                <td>Rumusan Masalah</td>
                <td><div></div><?=$data['disposisi']['rumusan_disposisi'];?></div></td>
            </tr>
        </tbody>
    </table>
</div>
<br>
<div style="padding-left: 13mm; font-family: Tahoma; font-size: 12pt;">
    Jombang, <?=tgl_indonesia_short($data['disposisi']['created_at']);?>
</div>
<div style="padding-left: 11mm; padding-right: 13mm; ">    
    <table style="width:100%; font-family: Tahoma; font-size: 12pt;" border="0" >
    	
    	<tbody>
    		
    		<tr>
    			<td width="60%">Kaprodi<br><br><br><br><br><br><br><strong><u><?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['Prodi']])['kaprodi'];?></u></strong><br><?=getDataRow('prodi', ['singkatan' => getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['Prodi']])['niy'];?></td>
    			<td >Mahasiswa<br><br><br><br><br><br><br><strong><u><?=strtoupper(getDataRow('db_data_diri_mahasiswa', ['id' => $data['id_data_diri']])['Nama_Lengkap']);?></u></strong><br><?=getDataRow('histori_pddk', ['id_his_pdk' => $data['id_his_pdk']])['NIM'];?></td>
    			
    		</tr>
    	</tbody>
    </table>
</div>